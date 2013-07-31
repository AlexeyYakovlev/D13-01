<?php

/**
 * User Agetn
 *
 * Определение HTTP_USER_AGENT
 * 
 * @package  Survey\Cookie
 * @author   Yakovlev
 * @version  1.0.0
 */
class UserAgent {

    // возвращает либо HTTP_USER_AGENT, либо unknown
    public static function get() {
        if (isset($_SERVER['HTTP_USER_AGENT']))
            return $_SERVER['HTTP_USER_AGENT'];
        else
            return 'unknown';
    }

    // форматирует HTTP_USER_AGENT в нижний регистр
    public static function getTolower() {
        return strtolower(UserAgent::get());
    }

}

?>
