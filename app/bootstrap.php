<?php
    // Подгружаем ядро
    require DOCROOT.'classes/Core.php';

    ini_set('memory_limit', '16000M');
    ini_set('max_execution_time', 0);
    ini_set('session.gc_maxlifetime', 1800);
    ini_set('session.cookie_lifetime', 1800);

    /**
     * Установка часового пояса по умолчанию
     * @link  http://php.net/timezones
     */
    date_default_timezone_set('Europe/Moscow');

    /**
     * Установка локали по умолчанию
     * @link http://www.php.net/manual/function.setlocale
     */
    setlocale(LC_ALL, 'ru_RU.utf-8');

    /**
     * Инициализация ядра
     */
    Core::init();

    /**
     * Время жизни куки
     * @var integer
     */
    Cookie::$expiration = Date::WEEK;

    /**
     * Соль для генерации куков
     * @var string
     */
    Cookie::$salt = Preference::getInstance()->getgetProperty("Salt");

    /**
     * Ограничение домена для куки
     * @var string
     */
    Cookie::$domain = 'www.site.com';
