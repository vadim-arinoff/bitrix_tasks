<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Главная страница");?>
<div id="barba-wrapper">
    <div class="article-list"><a class="article-item article-list__item" href="for-individuals.html"
                                 data-anim="anim-3">
        <div class="article-item__background"><img src="<?=SITE_TEMPLATE_PATH?>/images/article-item-bg-6.jpg"
                                                   data-src="xxxHTMLLINKxxx0.39186223192351520.41491856731872767xxx"
                                                   alt=""/></div>
        <div class="article-item__wrapper">
            <div class="article-item__title">Для физических лиц</div>
            <div class="article-item__content">Лучшие решения для вашего дома: быстрый интернет, доступное кабельное&nbsp;TV,
                удобный домашний телефон
            </div>
        </div>
    </a><a class="article-item article-list__item" href="#" data-anim="anim-3">
        <div class="article-item__background"><img src="<?=SITE_TEMPLATE_PATH?>/images/article-item-bg-3.jpg"
                                                   data-src="xxxHTMLLINKxxx0.153709056148504830.8920151245249737xxx"
                                                   alt=""/></div>
        <div class="article-item__wrapper">
            <div class="article-item__title">Средний и малый бизнес</div>
            <div class="article-item__content">Быстро и&nbsp;качественно помогаем предпринимателям в&nbsp;решении
                бизнес-задач
            </div>
        </div>
    </a><a class="article-item article-list__item" href="for-state.html" data-anim="anim-3">
        <div class="article-item__background"><img src="<?=SITE_TEMPLATE_PATH?>/images/article-item-bg-4.jpg"
                                                   data-src="xxxHTMLLINKxxx0.83331501539025420.9635873669140569xxx"
                                                   alt=""/></div>
        <div class="article-item__wrapper">
            <div class="article-item__title">Государственные заказчики</div>
            <div class="article-item__content">Решения для государственных структур, повышение безопасности и&nbsp;комфорта
                городской среды
            </div>
        </div>
    </a><a class="article-item article-list__item" href="for-federals.html" data-anim="anim-3">
        <div class="article-item__background"><img src="<?=SITE_TEMPLATE_PATH?>/images/article-item-bg-5.jpg"
                                                   data-src="xxxHTMLLINKxxx0.274858315149753230.570917169144997xxx"
                                                   alt=""/></div>
        <div class="article-item__wrapper">
            <div class="article-item__title">Федеральные клиенты</div>
            <div class="article-item__content">Повышаем эффективность бизнес-процессов за&nbsp;счет внедрения
                современных средств передачи и&nbsp;защиты данных
            </div>
        </div>
    </a><a class="article-item article-list__item" href="for-telecommunications.html" data-anim="anim-3">
        <div class="article-item__background"><img src="<?=SITE_TEMPLATE_PATH?>/images/article-item-bg-2.jpg"
                                                   data-src="xxxHTMLLINKxxx0.4314468597192560.505419651272456xxx"
                                                   alt=""/></div>
        <div class="article-item__wrapper">
            <div class="article-item__title">Операторы связи</div>
            <div class="article-item__content">Предлагаем партнерство и&nbsp;взаимовыгодное сотрудничество</div>
        </div>
    </a><a class="article-item article-list__item" href="innovative-projects.html" data-anim="anim-3">
        <div class="article-item__background"><img src="<?=SITE_TEMPLATE_PATH?>/images/article-item-bg-1.jpg"
                                                   data-src="xxxHTMLLINKxxx0.2544727135416540.7321213588928357xxx"
                                                   alt=""/></div>
        <div class="article-item__wrapper">
            <div class="article-item__title">Инновационные проекты</div>
            <div class="article-item__content">Предоставляем услуги широкополосного доступа в&nbsp;интернет и&nbsp;комплексные
                решения на&nbsp;базе технологий промышленного интернета вещей (IoT)
            </div>
        </div>
    </a></div>
</div>

<?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	".default", // Имя вашего шаблона компонента
	Array(
		"IBLOCK_TYPE" => "news",	// Тип инфоблока
		"IBLOCK_ID" => "1",	// ID инфоблока с новостями
		"NEWS_COUNT" => "4",	// Количество новостей на странице
		"SORT_BY1" => "ACTIVE_FROM",	// Поле для первой сортировки
		"SORT_ORDER1" => "DESC",	// Направление первой сортировки
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"FILTER_NAME" => "",
		"FIELD_CODE" => array(
			0 => "NAME",
			1 => "PREVIEW_TEXT",
			2 => "PREVIEW_PICTURE",
			3 => "",
		),
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "/news/#ELEMENT_CODE#/", // URL, ведущий на детальную страницу
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"PREVIEW_TRUNCATE_LEN" => "",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"SET_TITLE" => "N", // Не устанавливать заголовок страницы
		"SET_BROWSER_TITLE" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_LAST_MODIFIED" => "N",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N", // Не включать инфоблок в навигационную цепочку
		"ADD_SECTIONS_CHAIN" => "N", // Не включать раздел в навигационную цепочку
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"INCLUDE_SUBSECTIONS" => "Y",
		"STRICT_SECTION_CHECK" => "N",
		"PAGER_TEMPLATE" => ".default",
		"DISPLAY_TOP_PAGER" => "N", // Не показывать постраничную навигацию сверху
		"DISPLAY_BOTTOM_PAGER" => "N", // Не показывать постраничную навигацию снизу
		"PAGER_SHOW_ALWAYS" => "N",
	),
	false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>