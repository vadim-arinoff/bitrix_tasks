<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

?>
<form action="" method="GET">
    <label>Начало поездки: <input type="datetime-local" name="date_start" required></label><br>
    <label>Окончание поездки: <input type="datetime-local" name="date_end" required></label><br>
    <button type="submit">Найти доступные автомобили</button>

<?php if (!empty($arResult['CARS'])): ?>
    <h2>Доступные автомобили на выбранное время:</h2>
    <ul>
        <?php foreach ($arResult['CARS'] as $car): ?>
            <li>
                <strong>Модель:</strong> <?= $car['MODEL'] ?><br>
                <strong>Гос. номер:</strong> <?= $car['NUMBER'] ?><br>
                <strong>Категория:</strong> <?= $car['CATEGORY_XML_ID']?><br>
                <strong>Водитель:</strong> <?= $car['DRIVER_NAME'] ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php elseif (isset($arResult['CARS'])):?>
    <div>На выбранное время нет свободных автомобилей, соответствующих вашей должности.</div>
<?php endif; ?>
</form>
<?php if (!empty($arResult['ERROR'])): ?>
    <div><?=$arResult['ERROR']?></div>
<?php endif; ?>
