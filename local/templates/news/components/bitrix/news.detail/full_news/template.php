<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
$this->setFrameMode(true);
?>

<div class="news-detail-page">
    <div class="news-detail-card">
        <?// Детальное изображение, если оно есть?>
        <?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arResult["DETAIL_PICTURE"])):?>
            <img
                class="news-detail-card__image"
                src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>"
                alt="<?=$arResult["DETAIL_PICTURE"]["ALT"]?>"
                title="<?=$arResult["DETAIL_PICTURE"]["TITLE"]?>"
            />
        <?endif?>

        <?// Заголовок новости?>
        <?if($arParams["DISPLAY_NAME"]!="N" && $arResult["NAME"]):?>
            <h1 class="news-detail-card__title"><?=$arResult["NAME"]?></h1>
        <?endif;?>

        <?// Дата публикации?>
        <?if($arParams["DISPLAY_DATE"]!="N" && $arResult["DISPLAY_ACTIVE_FROM"]):?>
            <span class="news-detail-card__date"><?=$arResult["DISPLAY_ACTIVE_FROM"]?></span>
        <?endif;?>
        
        <?// Детальное описание?>
        <div class="news-detail-card__content">
            <?if($arResult["DETAIL_TEXT"] <> ''):?>
                <?echo $arResult["DETAIL_TEXT"];?>
            <?else:?>
                <?echo $arResult["PREVIEW_TEXT"];?>
            <?endif?>
        </div>
        
        <?
        // Блок "Поделиться"
        if(array_key_exists("USE_SHARE", $arParams) && $arParams["USE_SHARE"] == "Y")
        {
            ?>
            <div class="news-detail-share">
                <noindex>
                <?
                $APPLICATION->IncludeComponent("bitrix:main.share", "", array(
                        "HANDLERS" => $arParams["SHARE_HANDLERS"],
                        "PAGE_URL" => $arResult["~DETAIL_PAGE_URL"],
                        "PAGE_TITLE" => $arResult["~NAME"],
                        "SHORTEN_URL_LOGIN" => $arParams["SHARE_SHORTEN_URL_LOGIN"],
                        "SHORTEN_URL_KEY" => $arParams["SHARE_SHORTEN_URL_KEY"],
                        "HIDE" => $arParams["SHARE_HIDE"],
                    ),
                    $component,
                    array("HIDE_ICONS" => "Y")
                );
                ?>
                </noindex>
            </div>
            <?
        }
        ?>
    </div>
</div>