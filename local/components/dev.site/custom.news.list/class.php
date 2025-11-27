<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

class CustomNewsList extends CBitrixComponent 
{
    protected $errors = [];

    public function onPrepareComponentParams($arParams)
	{
        $arParams['CACHE_TIME'] = (int)$arParams['CACHE_TIME'];
        $arParams['IBLOCK_ID'] = empty($arParams['IBLOCK_ID']) ? 0 : (int)$arParams['IBLOCK_ID'];
        $arParams['IBLOCK_TYPE_ID'] = empty($arParams['IBLOCK_TYPE_ID']) ? '' : (string)$arParams['IBLOCK_TYPE_ID'];
        $arParams['FILTER'] = is_array($arParams['FILTER'] ?? null) ? $arParams['FILTER'] : [];
		return $arParams;
	}

    protected function checkRequiredParams () : bool 
    {
        if($this->arParams['IBLOCK_TYPE_ID'] == 0) {
            $this->errors[] = 'Отсутсвует обязательный параметр TypeId';
            return false;
        }
        return true;
    }

    private function getElemsByType () : void 
    {
        $filter = [
            'ACTIVE' => 'Y', 
            'IBLOCK_TYPE' => $this->arParams['IBLOCK_TYPE_ID'],
        ];

        if($this->arParams['IBLOCK_ID'] > 0) {
            $filter ['IBLOCK_ID'] = $this->arParams['IBLOCK_ID'];
        }
        $filter = array_merge($filter, $this->arParams['FILTER']);
        $dbRes = CIBlockElement::GetList(
            ['sort' => 'asc'],
            $filter,
        );

        $this->arResult['ITEMS'] = [];
        while ($element = $dbRes->Fetch()) {
            $this->arResult['ITEMS'][$element['IBLOCK_ID']][] = $element;
        }
    }

    public function executeComponent()
    {
        try {
            if ($this->checkRequiredParams()) {
                if ($this->startResultCache($this->arParams['CACHE_TIME'])) {
                $this->getElemsByType();
                $this->showErrors();
                $this->includeComponentTemplate();
                }
            }
        
        } catch (Exception $e) {
            $this->abortResultCache();
            $this->errors[] = $e->getMessage();
        }

        if (!empty($this->errors)) {
            $this->showErrors();
        }
    }

    protected function showErrors() : void
    {
        if (!empty($this->errors)) {
            foreach ($this->errors as $error) {
                ShowError((string)$error);
            }
        }
    }

}