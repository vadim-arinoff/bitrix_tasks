<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;

if (!Loader::includeModule('iblock'))
{
	return;
}

$dbIBlockType = CIBlockType::GetList(
	['sort' => 'asc'],
);

$dbIblockId = CIBlock::GetList(
	['sort' => 'asc'],
);

$arTypesEx = CIBlockParameters::GetIBlockTypes();
$arIBlockIds = [];
while ($arBlockId = $dbIblockId->Fetch())
{
	$arIBlockIds[$arBlockId['ID']] = '['.$arBlockId['ID'].'] '.$arBlockId['NAME'];
}

$arComponentParameters = [
	"GROUPS" => [
		"SETTINGS" => [
			"NAME" => 'Настройки выборки'
		],
	],
	'PARAMETERS' => [
		'IBLOCK_TYPE_ID' => [
			'PARENT' => 'SETTINGS',
			'NAME' => 'Типы инфоблоков',
			'TYPE' => 'LIST',
			'ADDITIONAL_VALUES' => 'Y',
			'VALUES' => $arTypesEx,
			'REFRESH' => 'Y'
		],
		'IBLOCK_ID' => [
			'PARENT' => 'SETTINGS',
			'NAME' => 'Инфоблок ID',
			'TYPE' => 'LIST',
			'ADDITIONAL_VALUES' => 'Y',
			'VALUES' => $arIBlockIds,
			'REFRESH' => 'Y'
		],
	'CACHE_TIME' => ['DEFAULT' => 3600],
	]
];
?>