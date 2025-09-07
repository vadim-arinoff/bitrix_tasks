<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
$this->setFrameMode(true);
?>

<?if (!empty($arResult["ITEMS"])): ?>
    <div class="article-list">
        <? foreach ($arResult["ITEMS"] as $arItem): ?>
            <?
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
            ?>

            <a class="article-item article-list__item" 
               href="<?= $arItem["PROPERTIES"]["LINK"]["VALUE"] ?>" 
               data-anim="anim-3" 
               id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                
                <div class="article-item__background">
                    <img src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>"
                         alt="<?= $arItem["PREVIEW_PICTURE"]["ALT"] ?>"
                         title="<?= $arItem["PREVIEW_PICTURE"]["TITLE"] ?>"/>
                </div>

                <div class="article-item__wrapper">
                    <div class="article-item__title"><?= $arItem["NAME"] ?></div>
                    <div class="article-item__content"><?= $arItem["PREVIEW_TEXT"] ?></div>
                </div>
            </a>
        <? endforeach; ?>
    </div>
<? endif; ?>