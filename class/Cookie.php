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

        if ($expiration !== 0) {
            $expiration += time();
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

    /**
     * Получение подписанной куки
     *
     * Неподписанные куки не будут возвращаться.
     * Метод Cookie::set подписывает кукисы с помощью Cookie::getSalt.
     * Если всё же кука подписана, но испорчена, то она удаляется.
     * Зачем нам хранить порченные куки?:)
     *
     * Пример:<br>
     * <code>
     * // Получение куки "theme", или "blue" по умолчанию, если "theme" нет
     * $theme = Cookie::get('theme', 'blue');
     * </code>
     *
     * @param   string  $key      Имя куки
     * @param   mixed   $default  Значение по умолчанию [Optional]
     *
     * @return  string
     */
    public static function get($key, $default = NULL) {
        if ( ! isset($_COOKIE[$key])) {
            // Если куки нет, вернём значение по умолчанию
            return $default;
        }
        // Получаем значение куки
        $cookie = $_COOKIE[$key];

        // Находим положение разделения между солью и содержимым куки
        $split = strlen(Cookie::getSalt($key, NULL));

        if (isset($cookie[$split]) AND $cookie[$split] === '~') {
            // Разделяем соль и значение куки
            list ($hash, $value) = explode('~', $cookie, 2);

            if (Cookie::getSalt($key, $value) === $hash) {
                // Подпись куки верна, возвращаем значение
                return $value;
            }

            // Подпись куки не верна, удаляем куку
            Cookie::delete($key);
        }

        return $default;
    }

    /**
     * Удаляет куку
     *
     * Помещаяет в куку NULL и делает её старой
     *
     * Пример:<br>
     * <code>
     * Cookie::delete('theme');
     * </code>
     *
     * @param   string  $name  Имя куки
     *
     * @return  boolean
     */
    public static function delete($name) {
        // Удаляем куку
        unset($_COOKIE[$name]);

        // Помещаяет в куку NULL и делает её старой
        return setcookie($name, NULL, time() - 1, Cookie::$path, Cookie::$domain, Cookie::$secure, Cookie::$httponly);
    }

}

?>