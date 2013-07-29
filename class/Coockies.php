<?php

/**
 * @author Yakovlev
 * @version 1.0
 * Coockies manager. 
 * Установка удаление кук.
 */
class Coockies {
    /*
     * @var $variable string
     * @var $value string
     * @var $period int
     * Устанавливает куки на выбранный период.
     */

    static function install($variable, $value, $period = 1987200) {
        setcookie($variable, $value, time() + $period);
    }

    /*
     * @var $variable string
     * @var $value string
     * @var $period int
     * Удаляет куки.
     */

    static function uninstall($variable, $value, $period = 1987200) {
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
