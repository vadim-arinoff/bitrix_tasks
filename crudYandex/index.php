<?php

require_once 'classes/App.php';

$disk = App::getDisk();
$currentPath = App::getCurrentPath();

try {
    $folder = $disk->getResource($currentPath)->setLimit(1000);

    if ($folder->has('items')) {
        $resources = $folder->items;
    }
} catch (Exception $e) {
    $error = "Ошибка: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Yandex Disk</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
    <h1>Проводник: <?= htmlspecialchars($currentPath) ?></h1>

    <?php if (isset($error)): ?>
        <div class="error-msg"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <!-- Btn Back -->
    <?php if ($currentPath !== '/'): ?>
        <a href="src/clickback.php" class="btn btn-back">&larr; Назад</a>
    <?php endif; ?>

    <!-- Upload form -->
    <div class="upload-box">
        <form action="src/upload.php" method="post" enctype="multipart/form-data">
            <label>Добавить файл: </label>
            <input type="file" name="file" required>
            <button type="submit">Загрузить</button>
        </form>
    </div>

     <!-- Files list -->
    <div class="file-list">
        <?php if (count($resources) === 0): ?>
            <p>Папка пуста</p>
        <?php endif; ?>

        <?php foreach ($resources as $resource): ?>
            <div class="file-item">
                <?php 
                    $isDir = $resource->isDir(); 
                    $name = $resource->get('name');
                    $path = $resource->get('path');
                    $size = $resource->has('size') ? round($resource->get('size') / 1024, 1) . ' KB' : '';
                ?>

                <div class="file-info">
                    <?php if ($isDir): ?>
                        <!-- Dir -->
                        <span class="badge badge-dir">DIR</span>
                        <a href="src/clickdir.php?path=<?= urlencode($path) ?>" class="item-name">
                            <?= htmlspecialchars($name) ?>
                        </a>
                    <?php else: ?>

                    <!-- File -->
                        <span class="badge badge-file">FILE</span>
                        <span class="item-name is-file">
                            <?= htmlspecialchars($name) ?> 
                            <span class="file-size">(<?= $size ?>)</span>
                        </span>
                    <?php endif; ?>
                </div>

                <div class="file-actions">
                    <a href="src/delete.php?path=<?= urlencode($path) ?>" 
                       class="btn btn-delete"
                       onclick="return confirm('Вы уверены, что хотите удалить <?= htmlspecialchars($name) ?>?');">
                       Удалить
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>