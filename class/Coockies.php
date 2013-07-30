<?php

/**
 * Cookie Manager
 *
 * Установка удаление кук.
 *
 * @package  Survey\Cookie
 * @author   Yakovlev
 * @version  1.0.1
 */
class Cookie {

    /**
     * Соль для генерации куков
     * @todo Значение этого параметра нужно вынести в конфиг
     * @var string
     */
    public static $salt = 'gj8GH53koksw90wenmnkHHHUj2478';

    /**
     * Количество секунд по умолчанию
     * @todo Значение этого параметра нужно вынести в конфиг
     * @var integer
     */
    public static $expiration = 1987200;

    /**
     * Ограничение пути для куки
     * @var string
     */
    public static $path = '/';

    /**
     * Ограничение домена для куки
     * @todo Значение этого параметра должно формироваться вначале
     * @var string
     */
    public static $domain = 'www.site.com';

    /**
     * Защищённое хранение
     * @var boolean
     */
    public static $secure = FALSE;

    /**
     * Передавать куки только по HTTP, отключение JavaScript доступа
     * @var boolean
     */
    public static $httponly = FALSE;

    /**
     * Установка куки
     *
     * Пример:<br>
     * <code>
     * Cookie::set('theme', 'red');
     * </code>
     *
     * @param   string   $name        Имя куки
     * @param   string   $value       Значение куки
     * @param   integer  $expiration  Время жизни в секундах [Optional]
     *
     * @return  boolean
     */
    public static function set($name, $value, $expiration = NULL) {
        if (is_null($expiration)) {
            // Используем время жизни по умолчанию
            $expiration = Cookie::$expiration;
        }

        // Добавляяем соль к значению куки
        $value = Cookie::getSalt($name, $value).'~'.$value;

        return setcookie($name, $value, $expiration, Cookie::$path, Cookie::$domain, Cookie::$secure, Cookie::$httponly);
    }

    /**
     * Генерирует строку соли для куков основываясь на имени куки и её значении
     *
     * Пример:<br>
     * <code>
     * $salt = Cookie::getSalt('theme', 'red');
     * </code>
     *
     * @param   string  $name   Имя куки
     * @param   string  $value  Значение куки
     *
     * @return  string
     */
    public static function getSalt($name, $value) {
        // Требуем соль
        // Из этого класса значение соли нужно убрать, а где нибудь в
        // инициализирующем месте соль нужно назначать, например так:
        // Cookies::$salt = 'skdjfhskuSKLDIFU39VJN4Ikdfjh';
        if ( ! Cookie::$salt) {
            throw new Exception('Требуется правильная соль для кукисов. Пожалуйста установите Cookies::$salt на начальном этапе!');
        }

        // Определяем юзер-агента
        $agent = isset($_SERVER['HTTP_USER_AGENT']) ? strtolower($_SERVER['HTTP_USER_AGENT']) : 'unknown';

        return hash_hmac('sha1', $agent.$name.$value.Cookie::$salt, Cookie::$salt);
    }

    /*
     * @var $variable string
     * @var $value string
     * @var $expiration int
     * Удаляет куки.
     */

    static function uninstall($variable, $value, $expiration = 1987200) {
        setcookie($variable, $value, time() - $period);
    }

    /*
     * @var $variable string
     * @var $value string
     * @var $period int
     * Возвращает куки если они есть.
     */

    static function get($variable) {
        if (isset($_COOKIE[$variable]))
            return $_COOKIE[$variable];
        else
            return false;
    }

}

?>