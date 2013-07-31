<?php

/**
 * Сookie Salt Encoder
 *
 * Продукт (Factory method)
 * 
 * @package  Survey\Cookie
 * @author   Yakovlev
 * @version  1.0.0
 */
class CookieSaltEncoder extends SaltEncoder {

    // string
    public $name;
    // string
    public $value;

    /*
     * запрещает создание объекта без параметров имени и значение куки
     *
     * @param   string  $name   Имя куки
     * @param   string  $value  Значение куки
     * 
     */

    public function __construct($name, $value) {
        // инициализируем переменные
        $this->name = $name;
        $this->value = $value;

        // Требуем соль
        if (!Cookie::$salt)
            throw new Exception('Требуется правильная соль для кукисов. Пожалуйста установите Cookies::$salt на начальном этапе!');
    }

    /**
     * Генерирует строку соли для куков основываясь на имени куки и её значении
     *
     * Пример:<br>
     * <code>
     * $salt = CookieSaltEncoder('theme', 'red');
     * $salt->encode();
     * </code>
     *

     *
     * @return  string
     */
    function encode() {
        // конкатенация HTTP_USER_AGENT, имя куки, значение куки и соли
        $data = UserAgent::getTolower() . $this->name . $this->value . Cookie::$salt;
        /**
         * (PHP 5 &gt;= 5.1.2, PECL hash &gt;= 1.1)<br/>
         * Generate a keyed hash value using the HMAC method
         * @link http://php.net/manual/en/function.hash-hmac.php
         * @param string $algo <p>
         * Name of selected hashing algorithm (i.e. "md5", "sha256", "haval160,4", etc..) See <b>hash_algos</b> for a list of supported algorithms.
         * </p>
         * @param string $data <p>
         * Message to be hashed.
         * </p>
         * @param string $key <p>
         * Shared secret key used for generating the HMAC variant of the message digest.
         * </p>
         * @param bool $raw_output [optional] <p>
         * When set to <b>TRUE</b>, outputs raw binary data.
         * <b>FALSE</b> outputs lowercase hexits.
         * </p>
         * @return string a string containing the calculated message digest as lowercase hexits
         * unless <i>raw_output</i> is set to true in which case the raw
         * binary representation of the message digest is returned.
         */
        return hash_hmac('sha1', $data, Cookie::$salt);
    }

}

?>
