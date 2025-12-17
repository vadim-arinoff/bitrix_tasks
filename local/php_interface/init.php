<?php
use Bitrix\Main\EventManager;

$eventManager = EventManager::getInstance();

$eventManager->addEventHandler(
    'iblock',
    'OnAfterIBlockElementAdd',
    [
        '\Dev\Site\Handlers\Iblock',
        'addLog'
    ]
);

$eventManager->addEventHandler(
    'iblock',
    'OnAfterIBlockElementUpdate',
    [
        '\Dev\Site\Handlers\Iblock',
        'addLog'
    ]
);