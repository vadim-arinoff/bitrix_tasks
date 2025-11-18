<?php

namespace Dev\Site\Agents;
//namespace Only\Site\Agents;
use Bitrix\Main\Loader;
use Bitrix\Iblock\IblockTable;
use CIBlockElement;

class Iblock
{
    public static function clearOldLogs()
    {
        if (!Loader::includeModule('iblock')) {
            return '\Dev\Site\Agents\Iblock::clearOldLogs();';
        }
        $logIblockId = 3;
        $res = IblockTable::getList([
            'select' => ['ID'],
            'filter' => ['=CODE' => 'LOG', '=IBLOCK_TYPE_ID' => 'service'],
            'limit' => 1,
        ]);

        if ($iblock = $res->fetch()) {
            $logIblockId = (int)$iblock['ID'];
        }

        if (!$logIblockId) {
            return '\Dev\Site\Agents\Iblock::clearOldLogs();';
        }

        $rsElements = CIBlockElement::GetList(
            ['ACTIVE_FROM' => 'DESC', 'ID' => 'DESC'], // Sort by new
            ['IBLOCK_ID' => $logIblockId, 'CHECK_PERMISSIONS' => 'N'], // arFilter
            false, // arGroupBy
            false, // arNavStartParams
            ['ID']
        );

        $elementIdsToDelete = [];
        $count = 0;
         while ($arElement = $rsElements->Fetch()) {
            $count++;
            if ($count > 10) {
                $elementIdsToDelete[] = $arElement['ID'];
            }
         }

         if (!empty($elementIdsToDelete)) {
            foreach ($elementIdsToDelete as $id) {
                CIBlockElement::Delete($id);
            }
         }

         return '\Dev\Site\Agents\Iblock::clearOldLogs();';
    }

    public static function example()
    {
        global $DB;
        if (\Bitrix\Main\Loader::includeModule('iblock')) {
            $iblockId = \Only\Site\Helpers\IBlock::getIblockID('QUARRIES_SEARCH', 'SYSTEM');
            $format = $DB->DateFormatToPHP(\CLang::GetDateFormat('SHORT'));
            $rsLogs = \CIBlockElement::GetList(['TIMESTAMP_X' => 'ASC'], [
                'IBLOCK_ID' => $iblockId,
                '<TIMESTAMP_X' => date($format, strtotime('-1 months')),
            ], false, false, ['ID', 'IBLOCK_ID']);
            while ($arLog = $rsLogs->Fetch()) {
                \CIBlockElement::Delete($arLog['ID']);
            }
        }
        return '\\' . __CLASS__ . '::' . __FUNCTION__ . '();';
    }
}
