<?php

class App
{
    const OAUTH_TOKEN = 'y0__xDl48TlARiEqTwggcGn1RUwu4fX3Aew1W_FWv97C1DFSq6mqiw9ZFvYXA';

    public static function getDisk()
    {
        //Подавление ошибок Deprecated (так как библиотека старая, а PHP 8.3)
        error_reporting(E_ALL & ~E_DEPRECATED);

        $autoloadPath = __DIR__ . '/../vendor/autoload.php';

        if (file_exists($autoloadPath)) {
            require_once $autoloadPath;
        } else {
            die('Ошибка: Папка vendor не найдена. В консоли выполни: composer require arhitector/yandex --ignore-platform-reqs');
        }

        return new \Arhitector\Yandex\Disk(self::OAUTH_TOKEN);
    }

    public static function getCurrentPath() 
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return $_SESSION['path'] ?? '/';
    }

    public static function setPath($path)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['path'] = $path;
    }
}