<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$arComponentDescription = [
	'NAME' => Loc::getMessage('HL_COMPONENT_NAME'),
	'DESCRIPTION' => Loc::getMessage('HL_COMPONENT_DESCRIPTION'),
	'SORT'       => 30,
	'CACHE_PATH' => 'Y',
	'PATH' 		 => [
		'ID' => 'dev',
		'NAME'  => Loc::getMessage('HL_COMPONENT_CATEGORY_TITLE'),
	],
];

?>