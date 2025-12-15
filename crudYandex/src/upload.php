<?php
require_once '../classes/App.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $disk = App::getDisk();
    $currentPath = App::getCurrentPath();
    
    $targetPath = rtrim($currentPath, '/') . '/' . $_FILES['file']['name'];
    
    try {
        $resource = $disk->getResource($targetPath);
        $resource->upload($_FILES['file']['tmp_name']);
    } catch (Exception $e) {
        // Можно записать ошибку в сессию
    }
}

header("Location: ../index.php");