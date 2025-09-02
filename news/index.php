<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Новость"); 
?>

<? $APPLICATION->IncludeComponent(
	"bitrix:news.detail", 
	"full_news",
	Array(
		"IBLOCK_TYPE" => "news",
		"IBLOCK_ID" => "1",	
		"ELEMENT_ID" => "",
		"ELEMENT_CODE" => $_REQUEST["ELEMENT_CODE"],
		"CHECK_DATES" => "Y",
		"FIELD_CODE" => array("DETAIL_PICTURE", "DETAIL_TEXT"),
		"PROPERTY_CODE" => array(),
		"SET_TITLE" => "Y",
		"SET_BROWSER_TITLE" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_META_DESCRIPTION" => "Y",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N", // Рекомендую отключить, чтобы не дублировать заголовок
		"ADD_SECTIONS_CHAIN" => "Y",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "360000",
	),
	false
);?>

<div class="back-link-container">
    <a href="/" class="news-card__button">Вернуться к списку новостей</a>
</div>

<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>