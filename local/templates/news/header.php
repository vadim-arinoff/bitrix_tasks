<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <link rel="shortcut icon" href="<?=SITE_TEMPLATE_PATH?>/images/favicon.604825ed.ico" type="image/x-icon">
    <!--<link href="<?=SITE_TEMPLATE_PATH?>/css/common.css" rel="stylesheet">-->
    <? $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/styles.css"); ?>
    <title><? $APPLICATION->ShowTitle(); ?></title>
    <? $APPLICATION->ShowHead();?>
</head>
<body>
    <? $APPLICATION->ShowPanel(); ?>
<main class="site-content">

