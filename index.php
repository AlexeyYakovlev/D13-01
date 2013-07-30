<?php
    /**
     * Каталог с специфическими наскройками приложения.
     * Каталог должен содержать bootstrap.php
     */
    $app = 'app';

    /**
     * Каталог с системными классами, набором ядра.
     * Данный каталог всегда должен содержать class/Core.php
     */
    $sys = 'sys';

    /**
     * Расширение php-файлов по умолчанию
     * Используется в нашем автозагрузчике класов, через метод find_file
     */
    define('EXT', '.php');

    /**
     * Для удобства сократим имя константы
     */
    defined('DS') ? NULL : define('DS', DIRECTORY_SEPARATOR);

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
    define('DOCROOT', realpath(dirname(__FILE__)).DS);

    // Делаем $app относительной корню документов
    if ( ! is_dir($app) AND is_dir(DOCROOT.$app))
        $app = DOCROOT.$app;

    // Делаем $sys относительной корню документов
    if ( ! is_dir($sys) AND is_dir(DOCROOT.$sys))
        $sys = DOCROOT.$sys;

    // Определяеем константу для $app использования в любых местах
    define('APPPATH', realpath($app).DS);
    define('SYSPATH', realpath($sys).DS);

    // Чистим память
    unset($app, $sys);

    // Подключаем bootstrap
    require APPPATH.'bootstrap.php';


    /**
     * всё что ниже со временем нужно убрать полностью
     * по своим местам. тут этого быть не должно
     */

    //session_start();
    //ob_start(); // это переехало в ядро

    // содержимое этого файла нужно пере-распределисть
    require 'config.php';

    $conf = Preferences::getInstance();
    print($conf->getProperty("ProjectName"));

    //flush();
    //ob_flush();
    //ob_end_clean();
