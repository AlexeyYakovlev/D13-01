<?php
    /**
     * Каталог с специфическими наскройками приложения.
     * Каталог должен содержать bootstrap.php
     */
    $app = 'app';

    /**
     * Уровень ошибок для PHP
     * @link  http://php.net/error_reporting
     *
     * В продакшене использовать: E_ALL ^ E_NOTICE
     * На локальной машине использовать: E_ALL | E_STRICT
     * Для использования устаревших вещей из PHP >= 5.3: E_ALL & ~E_DEPRECATED
     */
    error_reporting(E_ALL | E_STRICT);
    ini_set('display_errors', 'yes');

    // Полный путь к корню документов
    define('DOCROOT', realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR);

    // Делаем $app относительной корню документов
    if ( ! is_dir($app) AND is_dir(DOCROOT.$app))
        $app = DOCROOT.$app;

    // Определяеем константу для $app использования в любых местах
    define('APPPATH', realpath($app).DIRECTORY_SEPARATOR);

    // Чистим память
    unset($app);

    // Подключаем bootstrap
    require APPPATH.'bootstrap.php';


    session_start();
    ob_start();
    require 'class/DBH.php';
    require 'class/Preferences.php';
    require 'config.php';
    $conf = Preferences::getInstance();
    print($conf->getProperty("ProjectName"));
    flush();
    ob_flush();
    ob_end_clean();
