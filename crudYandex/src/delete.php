<?php
require_once '../classes/App.php';

if (isset($_GET['path'])) {
    $disk = App::getDisk();
    try {
        $resource = $disk->getResource($_GET['path']);
        if ($resource->has()) {
            $resource->delete();
        }
    } catch (Exception $e) {
        // Обработка ошибок
    }
}
header("Location: ../index.php");