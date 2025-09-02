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

<section class="page-section" id="news">
    <div class="container text-center">
        <h2 class="section-heading">Новости</h2>
        <hr class="divider my-4">
    </div>
    <div class="container">
        <div class="news-grid">
            <? foreach ($arResult["ITEMS"] as $arItem): ?>
                <?
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

                $previewImage = CFile::ResizeImageGet(
                    $arItem["PREVIEW_PICTURE"]["ID"],
                    array("width" => 400, "height" => 250),
                    BX_RESIZE_IMAGE_EXACT,
                    true
                );
                // Устанавливаем заглушку, если картинки нет
                $previewImageSrc = $previewImage['src'] ?? SITE_TEMPLATE_PATH.'/images/no-photo.jpg';
                ?>

                <div class="news-card" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                    <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="news-card__image-link">
                        <img class="news-card__image" src="<?=$previewImageSrc?>" alt="<?=htmlspecialchars($arItem["NAME"])?>">
                    </a>
                    <div class="news-card__body">
                        <h5 class="news-card__title">
                            <a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a>
                        </h5>
                        <? if ($arItem["PREVIEW_TEXT"]): ?>
                            <p class="news-card__text">
                                <?=TruncateText($arItem["PREVIEW_TEXT"], 100)?>
                            </p>
                        <? endif; ?>
                        <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="news-card__button">Подробнее</a>
                    </div>
                </div>
            <? endforeach; ?>
        </div>
    </div>
</section>

<? endif; ?>