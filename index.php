<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Главная страница");?><div id="barba-wrapper">
</div>
<?$APPLICATION->IncludeComponent(
	"bitrix:news",
	"",
Array()
);?>
&nbsp; &nbsp;&nbsp;<?$APPLICATION->IncludeComponent(
	"dev.site:custom.news.list", 
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"IBLOCK_TYPE_ID" => "vacancies",
		"IBLOCK_ID" => "2"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>