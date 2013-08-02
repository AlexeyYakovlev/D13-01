<?php

// Подгружаем ядро
require SYSPATH . 'class/Core.php';


ini_set('memory_limit', '1024M');
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
 * Подключаем собственный атозагрузчик классов
 */
spl_autoload_register(array('Core', 'auto_load'));

/**
 * Инициализация ядра
 *
 * Следующие настройки могут установлены:
 *
 * + caching - Кешировать результат поиска расположения файлов?
 *             Рекомендуется в продакшене устанавливать в TRUE.
 */
Core::init(array(
    'caching' => FALSE, // В продакшене включить
));

/* @todo содержимое этого файла нужно пере-распределить
 * а желательно вообще использовать класс Config
 * который будет автоматически всё оттуда считывать
 */
require 'config.php';

/**
 * Время жизни куки
 * @var integer
 */
Cookie::$expiration = Date::WEEK;

/**
 * Соль для генерации куков
 * @var string
 */
Cookie::$salt = Preference::getInstance()->get("Salt");

/**
 * Ограничение домена для куки
 * @var string
 */
Cookie::$domain = Preference::getInstance()->get("SiteUrl");