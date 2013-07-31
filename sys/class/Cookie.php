<?php

/**
 * Cookie Manager
 *
 * Установка удаление кук.
 * Используется совместно с:
 *      ¤ Salt Manager
 *      ¤ Salt Encoder
 *      ¤ Cookie Salt Manager
 *      ¤ Cookie Salt Encoder
 * 
 * @package  Survey\Cookie
 * @author   Yakovlev
 * @version  1.0.3
 */
class Cookie {

    /**
     * Соль для генерации куков
     * @var string
     */
    public static $salt = NULL;

    /**
     * Количество секунд по умолчанию
     * @var integer
     */
    public static $expiration = 0;

    /**
     * Ограничение пути для куки
     * @var string
     */
    public static $path = '/';

    /**
     * Ограничение домена для куки
     * @var string
     */
    public static $domain = NULL;

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
     * Запрос времени жизни куки
     *
     * Пример:<br>
     * <code>
     * Cookie::getExpiration();
     * </code>
     * @access private
     * @param   integer  $expiration  Время жизни в секундах [Optional]
     *
     * @return  int
     */
    private static function getExpiration($expiration) {
        if (is_null($expiration)) {
            // Используем время жизни по умолчанию
            $expiration = Cookie::$expiration;
        }

        if ($expiration !== 0) {
            $expiration += time();
        } else {
            throw new Exception('Время жизни куки не инициализировано. Укажите времмя жизни куки в Cookie::$expiration в bootstrap.php');
        }
        return $expiration;
    }

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
        /*
         * Добавляяем соль к значению куки
         */
        $salt = new CookieSaltEncoder($name, $value);
        $value = $salt->encode() . '~' . $value;
        unset($salt);
        return setcookie($name, $value, Cookie::getExpiration($expiration), Cookie::$path, Cookie::$domain, Cookie::$secure, Cookie::$httponly);
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
        $salt = new CookieSaltEncoder(NULL, NULL);
        if (!isset($_COOKIE[$key])) {
            // Если куки нет, вернём значение по умолчанию
            return $default;
        }
        // Получаем значение куки
        $cookie = $_COOKIE[$key];
        $salt->name = $key;
        // Находим положение разделения между солью и содержимым куки
        $split = strlen($salt->encode());

        if (isset($cookie[$split]) AND $cookie[$split] === '~') {
            // Разделяем соль и значение куки
            list ($hash, $value) = explode('~', $cookie, 2);
            $salt->value = $value;
            if ($salt->encode() === $hash) {
                // Подпись куки верна, возвращаем значение
                return $value;
            }

            // Подпись куки не верна, удаляем куку
            Cookie::delete($key);
        }
        unset($salt);
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
