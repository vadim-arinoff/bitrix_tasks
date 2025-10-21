<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
$this->setFrameMode(true);
?>

<div class="article-card">
    <div class="article-card__title"><?=$arResult["NAME"]?></div>

    <?if($arParams["DISPLAY_DATE"]!="N" && $arResult["DISPLAY_ACTIVE_FROM"]):?>
        <div class="article-card__date"><?=$arResult["DISPLAY_ACTIVE_FROM"]?></div>
    <?endif;?>

    <div class="article-card__content">
        <?if($arResult["DETAIL_PICTURE"]["SRC"]):?>
            <div class="article-card__image sticky">
                <img src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>"
                     alt="<?=$arResult["DETAIL_PICTURE"]["ALT"]?>"
                     title="<?=$arResult["DETAIL_PICTURE"]["TITLE"]?>"
                     data-object-fit="cover"/>
            </div>
        <?endif;?>

        <div class="article-card__text">
            <div class="block-content" data-anim="anim-3"><p><?=$arResult["DETAIL_TEXT"];?></p></div>
            <a class="article-card__button" href="<?=$arResult["LIST_PAGE_URL"]?>">Назад к новостям</a></div>
    </div>
</div>
