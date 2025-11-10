<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");

if (!isset ($USER) || !$USER->IsAdmin()) {
    LocalRedirect('/');
}
\Bitrix\Main\Loader::includeModule('iblock');

const IBLOCK_CODE = 'VACANCIES';
const CSV_FILE = 'vacancy.csv';

$res = CIBlock::GetList([], ['CODE' => IBLOCK_CODE, 'CHECK_PERMISSIONS' => 'N']);
if($iblock = $res->Fetch()){
    $IBLOCK_ID = $iblock['ID'];
} else {
    "Инфоблок с кодом" . IBLOCK_CODE . "не найден";
    die();
}

$el = new CIBlockElement;
$arProps = [];
$rsPropEnums = CIBlockPropertyEnum::GetList(
    ["SORT" => "ASC", "VALUE" => "ASC"],
    ['IBLOCK_ID' => $IBLOCK_ID]
);

while ($arEnum = $rsPropEnums->Fetch()) {
    $arProps[$arEnum['PROPERTY_CODE']][trim($arEnum['Value'])] = $arEnum['ID'];
}

echo "Очистка инфоблока...<br>";
$rsElements = CIBlockElement::GetList([], ['IBLOCK_ID' => $IBLOCK_ID], false, false, ['ID']);
while ($element = $rsElements->Fetch()) {
    CIBlockElement::Delete($element['ID']);
}
echo "Очистка завершена<br>";

$row = 1;

if (($handle = fopen(CSV_FILE, "r")) !== false) {
    while (($data = fgetcsv($handle, 10000, ",")) !== false) {
        if ($row == 1) {
            $row++;
            continue;
        }

        if (!is_array($data) || empty($data[1])) {
            $row++;
            continue;
        }

    $PROP = [];
        $PROP['OFFICE']     = trim($data[1]);
        $PROP['LOCATION']   = trim($data[2]);
        $PROP['REQUIRE']    = trim($data[4]);
        $PROP['DUTY']       = trim($data[5]);
        $PROP['CONDITIONS'] = trim($data[6]);
        $PROP['EMAIL']      = trim($data[12]);
        $PROP['TYPE']       = trim($data[8]);
        $PROP['ACTIVITY']   = trim($data[9]);
        $PROP['SCHEDULE']   = trim($data[10]);
        $PROP['FIELD']      = trim($data[11]);
        $PROP['SALARY_VALUE'] = trim($data[7]);
        $PROP['DATE']       = date('d.m.Y H:i:s');
    
        foreach ($PROP as $code => &$value) {
            if (in_array($code, ['REQUIRE', 'DUTY', 'CONDITIONS']) && strpos($value, '•') !== false) {
                $value = explode('•', $value);
                array_shift($value);
                foreach ($value as &$str) {
                    $str = trim($str);
                }
            }
            elseif (isset($arProps[$code])) {
                $enumId = $arProps[$code][$value] ?? null;
                if ($enumId) {
                    $value = $enumId;
                } else {
                    $value = null;
                }
            }
        }
        unset($value);

        if ($PROP['SALARY_VALUE'] == '-' || empty($PROP['SALARY_VALUE'])) {
            $PROP['SALARY_VALUE'] = '';
            $PROP['SALARY_TYPE'] = null;
        } elseif (strtolower($PROP['SALARY_VALUE']) == 'по договоренности') {
            $PROP['SALARY_VALUE'] = '';
            $PROP['SALARY_TYPE'] = $arProps['SALARY_TYPE']['Договорная'] ?? null;
        } else {
            $arSalary = explode(' ', $PROP['SALARY_VALUE']);
            $salaryTypeStr = strtolower($arSalary[0]);

            if ($salaryTypeStr == 'От' || $salaryTypeStr == 'До') {
                $PROP['SALARY_TYPE'] = $arProps['SALARY_TYPE'][strtoupper($salaryTypeStr)] ?? null;
                array_shift($arSalary);
                $PROP['SALARY_VALUE'] = implode(' ', $arSalary);
            } else {
                $PROP['SALARY_TYPE'] = $arProps['SALARY_TYPE']['='] ?? null;
            }
        }

        $arLoadProductArray = [
            "MODIFIED_BY" => $USER->GetID(),
            "IBLOCK_SECTION_ID" => false,
            "IBLOCK_ID" => $IBLOCK_ID,
            "PROPERTY_VALUES" => $PROP,
            "NAME" => trim($data[3]),
            "ACTIVE" => "Y",
        ];

        if ($PRODUCT_ID = $el->Add($arLoadProductArray)) {
            echo "Строка $row: Успешно добавлена вакансия '{$arLoadProductArray['NAME']}' (ID: $PRODUCT_ID) <br>";
        } else {
            echo "Строка $row: Ошибка добавления вакансии '{$arLoadProductArray['NAME']}'" . $el->LAST_ERROR . '<br>';
        }

        $row++;
    }
    fclose($handle);
    echo "<hr><b>Импорт завершён.</b>";
} else {
    echo "Не удалось открыть файл " . CSV_FILE;
}