<?php
require_once '../classes/App.php';

if (isset($_GET['path'])) {
    App::setPath($_GET['path']);
}
header("Location: ../index.php");