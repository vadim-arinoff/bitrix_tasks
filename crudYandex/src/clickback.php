<?php
require_once '../classes/App.php';

$current = App::getCurrentPath();

if ($current !== '/') {
    $parent = substr($current, 0, strrpos($current, '/'));
    if ($parent === '') $parent = '/';
    App::setPath($parent);
}

header("Location: ../index.php");