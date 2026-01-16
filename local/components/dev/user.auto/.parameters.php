<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Loader;
use \Bitrix\Main\Localization\Loc;
use \Bitrix\Highloadblock\HighloadBlockTable as HLT;

Loc::loadMessages(__FILE__);

if (!Loader::includeModule('iblock') || !Loader::includeModule('highloadblock')) {
    return;
}

$arIBlocks = [];
$rsIBlock = \CIBlock::GetList(
    ['SORT'=> 'ASC'],
    ['ACTIVE' => 'Y']
);

while ($arr = $rsIBlock->fetch()) {
    $arIBlocks[$arr['ID']] = '[' . $arr['ID'] . '] ' . $arr['NAME'];
}

$arHLBlocks = [];
$rsHLBlock = HLT::getList([
    'select' => ['ID', 'NAME', 'TABLE_NAME'],
    'order' => ['NAME' => 'ASC']
]);

while ($arr = $rsHLBlock->fetch()) {
    $arHLBlocks[$arr['ID']] = '[' . $arr['ID'] . '] ' . $arr['NAME'];
}

/**
 * Параметры
 * 
 * IBLOCK_CARS_ID (ID Инфоблока Автомобили)
 * HL_BOOKING_ID (ID HL Бронирования)
 * HL_LINKS_ID (ID HL "Связь Группа-Категория")
 * HL_CATEGORIES_ID (ID HL "Категории авто")
 */

$arComponentParameters = [
    'GROUPS' => [],
    'PARAMETERS' => [
        'IBLOCK_CARS_ID' => [
            'PARENT' => 'BASE',
            'NAME' => Loc::getMessage('IBLOCK_CARS_ID'),
            'TYPE' => 'LIST',
            'VALUES' => $arIBlocks,
            'REFRESH' => 'N',
            'MULTIPLE' => 'N'
        ],
        'HL_BOOKING_ID' => [
            'PARENT' => 'BASE',
            'NAME' => Loc::getMessage('HL_BOOKING_ID'),
            'TYPE' => 'LIST',
            'VALUES' => $arHLBlocks,
        ],
        'HL_LINKS_ID' => [
            'PARENT' => 'BASE',
            'NAME' => Loc::getMessage('HL_LINKS_ID'),
            'TYPE' => 'LIST',
            'VALUES' => $arHLBlocks,
        ],
        'HL_CATEGORIES_ID' => [
            'PARENT' => 'BASE',
            'NAME' => Loc::getMessage('HL_CATEGORIES_ID'),
            'TYPE' => 'LIST',
            'VALUES' => $arHLBlocks,
        ],
        'CACHE_TIME'  =>  ['DEFAULT'=>36000000]
    ],
];
?>
