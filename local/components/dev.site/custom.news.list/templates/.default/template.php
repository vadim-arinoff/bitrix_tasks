<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/*echo "<pre>";
var_dump($arParams);
var_dump($arResult);
echo "</pre>";
*/

if (count($arResult['ITEMS']) > 0): ?>
    <?php foreach ($arResult['ITEMS'] as $iblockId => $items): ?>
    <div class ="i-block-div" data-iblock-id ="<?= $iblockId?>">
        <h2>Инфоблок №<?= (int)$iblockId?></h2>
        <div class="news-div">
            <?php foreach ($items as $item): ?>
                <?php 
                $name = htmlspecialcharsbx($item['NAME']);
                $link = $item['DETAIL_PAGE_URL'];
                ?>

                <div class="news-div-items">
                    <?php if ($link): ?>
                        <a href="<?= $link ?>"><? echo $name ?></a>
                        <?php else: ?>
                        <? echo $name ?></a>
                        <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
        <?php endforeach; ?>
<?php else: ?>
    <p>Элемент не найден</p>
    <?php endif; ?>