<?php
use Bitrix\Main\Loader;
use Bitrix\Highloadblock as HL;
use Bitrix\Main\Type\DateTime;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

class AutoSearchComponent extends CBitrixComponent
{
    protected function checkModules()
    {
        if (!Loader::includeModule('iblock') || !Loader::includeModule('highloadblock')) {
            throw new \Exception("Не загружены необходимые модули");
        }
    }

    protected function getHLEntity($hlBlockId)
    {
        if (empty($hlBlockId)) {
            throw new \Exception("Не задан ID Highload-блока");
        }
        $hlblock = HL\HighloadBlockTable::getById($hlBlockId)->fetch();
        if (!$hlblock) {
            throw new \Exception("HL-блок с ID $hlBlockId не найден");
        }
        return HL\HighloadBlockTable::compileEntity($hlblock)->getDataClass();
    }

    public function executeComponent()
    {
        try {
            $this->checkModules();

            // Обработка дат
            $start = $_GET['date_start'] ?? '';
            $end   = $_GET['date_end'] ?? '';

            if (!$start || !$end) {
                $this->includeComponentTemplate();
                return;
            }

            try {
                $bxDateStart = DateTime::createFromTimestamp(strtotime($start));
                $bxDateEnd   = DateTime::createFromTimestamp(strtotime($end));
                
                // Проверка
                if ($bxDateEnd->getTimestamp() <= $bxDateStart->getTimestamp()) {
                    $this->arResult['ERROR'] = "Дата окончания должна быть позже начала";
                    $this->includeComponentTemplate();
                    return;
                }
            } catch (\Exception $e) {
                $this->arResult['ERROR'] = "Неверный формат даты";
                $this->includeComponentTemplate();
                return;
            }

            // Доступные категории для пользователя
            global $USER;
            $userGroups = $USER->GetUserGroupArray();
            
            $entityLinks = $this->getHLEntity($this->arParams['HL_LINKS_ID']);
            
            $rsLinks = $entityLinks::getList([
                'select' => ['UF_CATEGORY_ID'],
                'filter' => ['UF_GROUP_ID' => $userGroups]
            ]);

            $allowedCategoryIds = [];
            while ($row = $rsLinks->fetch()) {
                if (is_array($row['UF_CATEGORY_ID'])) {
                    $allowedCategoryIds = array_merge($allowedCategoryIds, $row['UF_CATEGORY_ID']);
                } else {
                    $allowedCategoryIds[] = $row['UF_CATEGORY_ID'];
                }
            }
            $allowedCategoryIds = array_unique($allowedCategoryIds);

            if (empty($allowedCategoryIds)) {
                $this->arResult['ERROR'] = "Для вашей должности нет доступных авто.";
                $this->includeComponentTemplate();
                return;
            }

            // Получаем XML_ID категорий 
            $allowedXmlIds = [];
            $entityCats = $this->getHLEntity($this->arParams['HL_CATEGORIES_ID']);
            $rsCats = $entityCats::getList([
                'select' => ['UF_XML_ID'],
                'filter' => ['ID' => $allowedCategoryIds]
            ]);
            
            while ($row = $rsCats->fetch()) {
                $allowedXmlIds[] = $row['UF_XML_ID'];
            }

            if (empty($allowedXmlIds)) {
                $this->arResult['ERROR'] = "Категории доступа найдены, но коды категорий не определены.";
                $this->includeComponentTemplate();
                return;
            }

            // 4. Находим ЗАНЯТЫЕ машины (Матрица брони)
            $busyCarIds = [];
            $entityBooking = $this->getHLEntity($this->arParams['HL_BOOKING_ID']);

            $rsBooking = $entityBooking::getList([
                'select' => ['UF_CAR_ID'],
                'filter' => [
                    '<UF_DATE_FROM' => $bxDateEnd, 
                    '>UF_DATE_TO'   => $bxDateStart
                ]
            ]);

            while ($row = $rsBooking->fetch()) {
                $busyCarIds[] = $row['UF_CAR_ID'];
            }
            $busyCarIds = array_unique($busyCarIds);


            // 5. Выборка автомобилей из Инфоблока
            $arFilter = [
                'IBLOCK_ID' => $this->arParams['IBLOCK_CARS_ID'],
                'ACTIVE' => 'Y',
                'PROPERTY_COMFORT_CATEGORY' => $allowedXmlIds // Фильтр по свойству типа "Справочник" или "Список"
            ];

            if (!empty($busyCarIds)) {
                $arFilter['!ID'] = $busyCarIds; // Исключаем занятые ID
            }

            // Выбираем свойства сразу через PROPERTY_
            $arSelect = [
                'ID', 'NAME', 
                'PROPERTY_COMFORT_CATEGORY', 
                'PROPERTY_DRIVER', 
                'PROPERTY_MODEL',
                'PROPERTY_G_NUMBER'
            ];

            $res = CIBlockElement::GetList(
                ['NAME' => 'ASC'], 
                $arFilter, 
                false, 
                false, 
                $arSelect
            );
            
            $this->arResult['CARS'] = [];
            
            // Собираем ID водителей 
            
            while ($row = $res->Fetch()) {
                $driverId = $row['PROPERTY_DRIVER_VALUE'];
                $driverName = 'Водитель не назначен';

                if ($driverId) {
                    $rsUser = \CUser::GetByID($driverId);
                    if ($arUser = $rsUser->Fetch()) {
                        $driverName = $arUser['NAME'] . ' ' . $arUser['LAST_NAME'];
                    }
                }

                $this->arResult['CARS'][] = [
                    'ID' => $row['ID'],
                    'NAME' => $row['NAME'],
                    'MODEL' => $row['PROPERTY_MODEL_VALUE'],
                    'NUMBER' => $row['PROPERTY_G_NUMBER_VALUE'],
                    'DRIVER_NAME' => $driverName,
                    'CATEGORY_XML_ID' => $row['PROPERTY_COMFORT_CATEGORY_VALUE'],
                ];
            }

            $this->includeComponentTemplate();

        } catch (Exception $e) {
            ShowError($e->getMessage());
        }
    }
}
?>