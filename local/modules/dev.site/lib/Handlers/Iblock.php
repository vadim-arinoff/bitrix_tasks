<?php
namespace Only\Site\Handlers;

use Bitrix\Main\Loader;
use CIBlock;

Loader::includeModule("iblock");


class Iblock
{
    public function addLog(&$arFields)
    {
        $logBlockId = \Only\Site\Helpers\IBlock::getIblockID('LOG', 'service');
        /*
         * Temp fix Log ID:
         $logBlockId = 3;
         */

        // 1.2
        if ($arFields['IBLOCK_ID'] == $logBlockId) {
            return; 
        }
        
        if (!isset ($arFields ['IBLOCK_ID']) || !$arFields ['IBLOCK_ID'] > 0) {
            return;
        }

        $resIblock = \CIBlockElement::GetByID($arFields ['IBLOCK_ID'])->GetNext();
        $resIblockName = $resIblock['NAME'];
        $resIblockCode = $resIblock['CODE'];
        
        // 1.3
        $sectionID = 0;
        $resSection = \CIBlockSection::GetList(
            [], //$arOrder
            [
                'IBLOCK_ID' => $logBlockId,
                'CODE' => $resIblockCode
            ],
            false,
            ['ID']
        );

        if ($arSection = $resSection->Fetch()) {
            $sectionID = $arSection['ID'];
        } else {
            $bs = new \CIBlockSection;
            $arSectionFields = [
                'ACTIVE' => 'Y',
                'IBLOCK_ID' => $logBlockId,
                'NAME' => $resIblockName,
                'CODE' => $resIblockCode
            ];
            $newSectionId = $bs->Add($arSectionFields);
            if($newSectionId) {
                $sectionID = $newSectionId;
            } else {
                return;
            }
        }

        $activeFrom = ConvertTimeStamp(time(), "FULL"); // 1.5
        
        $pathString = self::getSectionPath($arFields['IBLOCK_SECTION_ID']);
        $previevText = $resIblockName . ' -> ' . $pathString . $arFields['NAME']; // 1.6

        $logElementFields = [
            "ACTIVE" => "Y",
            "IBLOCK_ID" => $logBlockId,
            "IBLOCK_SECTION_ID" => $sectionID,
            "NAME" => $arFields['ID'], // 1.4
            "CODE" => "log_" . $arFields['ID'],
            "ACTIVE_FROM" => $activeFrom, // 1.5
            "PREVIEW_TEXT" => $previevText, // 1.6
        ];

        $el = new \CIBlockElement;
        $rsLog = \CIBlock::GetList(
            [],
            [
                'IBLOCK_ID' => $logBlockId,
                'NAME' => $arFields['ID'],
            ],
            false,
            false,
            ['ID'],
        );

        // 1.2 
        if ($arLog = $rsLog -> Fetch()) {
            $el->Update($arLog['ID'], $logElementFields);
        } else {
            $el->Add($logElementFields);
        }
    }
        private static function getSectionPath($sectionID) 
        {
            if (!$sectionID) {
                return ''; //If elem fundamentally
            }

            $nav = \CIBlockSection::GetNavChain(false, $sectionID); // 1.7
            $path = [];
            while ($arSection = $nav->Fetch()){
                $path[] = $arSection['NAME'];
            }

            return implode (' -> ', $path) . ' -> ';
        }


    function OnBeforeIBlockElementAddHandler(&$arFields)
    {
        $iQuality = 95;
        $iWidth = 1000;
        $iHeight = 1000;
        /*
         * Получаем пользовательские свойства
         */
        $dbIblockProps = \Bitrix\Iblock\PropertyTable::getList(array(
            'select' => array('*'),
            'filter' => array('IBLOCK_ID' => $arFields['IBLOCK_ID'])
        ));
        /*
         * Выбираем только свойства типа ФАЙЛ (F)
         */
        $arUserFields = [];
        while ($arIblockProps = $dbIblockProps->Fetch()) {
            if ($arIblockProps['PROPERTY_TYPE'] == 'F') {
                $arUserFields[] = $arIblockProps['ID'];
            }
        }
        /*
         * Перебираем и масштабируем изображения
         */
        foreach ($arUserFields as $iFieldId) {
            foreach ($arFields['PROPERTY_VALUES'][$iFieldId] as &$file) {
                if (!empty($file['VALUE']['tmp_name'])) {
                    $sTempName = $file['VALUE']['tmp_name'] . '_temp';
                    $res = \CAllFile::ResizeImageFile(
                        $file['VALUE']['tmp_name'],
                        $sTempName,
                        array("width" => $iWidth, "height" => $iHeight),
                        BX_RESIZE_IMAGE_PROPORTIONAL_ALT,
                        false,
                        $iQuality);
                    if ($res) {
                        rename($sTempName, $file['VALUE']['tmp_name']);
                    }
                }
            }
        }

        if ($arFields['CODE'] == 'brochures') {
            $RU_IBLOCK_ID = \Only\Site\Helpers\IBlock::getIblockID('DOCUMENTS', 'CONTENT_RU');
            $EN_IBLOCK_ID = \Only\Site\Helpers\IBlock::getIblockID('DOCUMENTS', 'CONTENT_EN');
            if ($arFields['IBLOCK_ID'] == $RU_IBLOCK_ID || $arFields['IBLOCK_ID'] == $EN_IBLOCK_ID) {
                \CModule::IncludeModule('iblock');
                $arFiles = [];
                foreach ($arFields['PROPERTY_VALUES'] as $id => &$arValues) {
                    $arProp = \CIBlockProperty::GetByID($id, $arFields['IBLOCK_ID'])->Fetch();
                    if ($arProp['PROPERTY_TYPE'] == 'F' && $arProp['CODE'] == 'FILE') {
                        $key_index = 0;
                        while (isset($arValues['n' . $key_index])) {
                            $arFiles[] = $arValues['n' . $key_index++];
                        }
                    } elseif ($arProp['PROPERTY_TYPE'] == 'L' && $arProp['CODE'] == 'OTHER_LANG' && $arValues[0]['VALUE']) {
                        $arValues[0]['VALUE'] = null;
                        if (!empty($arFiles)) {
                            $OTHER_IBLOCK_ID = $RU_IBLOCK_ID == $arFields['IBLOCK_ID'] ? $EN_IBLOCK_ID : $RU_IBLOCK_ID;
                            $arOtherElement = \CIBlockElement::GetList([],
                                [
                                    'IBLOCK_ID' => $OTHER_IBLOCK_ID,
                                    'CODE' => $arFields['CODE']
                                ], false, false, ['ID'])
                                ->Fetch();
                            if ($arOtherElement) {
                                /** @noinspection PhpDynamicAsStaticMethodCallInspection */
                                \CIBlockElement::SetPropertyValues($arOtherElement['ID'], $OTHER_IBLOCK_ID, $arFiles, 'FILE');
                            }
                        }
                    } elseif ($arProp['PROPERTY_TYPE'] == 'E') {
                        $elementIds = [];
                        foreach ($arValues as &$arValue) {
                            if ($arValue['VALUE']) {
                                $elementIds[] = $arValue['VALUE'];
                                $arValue['VALUE'] = null;
                            }
                        }
                        if (!empty($arFiles && !empty($elementIds))) {
                            $rsElement = \CIBlockElement::GetList([],
                                [
                                    'IBLOCK_ID' => \Only\Site\Helpers\IBlock::getIblockID('PRODUCTS', 'CATALOG_' . $RU_IBLOCK_ID == $arFields['IBLOCK_ID'] ? '_RU' : '_EN'),
                                    'ID' => $elementIds
                                ], false, false, ['ID', 'IBLOCK_ID', 'NAME']);
                            while ($arElement = $rsElement->Fetch()) {
                                /** @noinspection PhpDynamicAsStaticMethodCallInspection */
                                \CIBlockElement::SetPropertyValues($arElement['ID'], $arElement['IBLOCK_ID'], $arFiles, 'FILE');
                            }
                        }
                    }
                }
            }
        }
    }

}
