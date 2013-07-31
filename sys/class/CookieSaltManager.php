<?php

/**
 * Сookie Salt Menager
 *
 * Создатель (Factory method)
 * 
 * @package  Survey\Cookie
 * @author   Yakovlev
 * @version  1.0.0
 */
class CookieSaltManager extends SaltManager {

    function getSaltEncoder() {
        return new CookieSaltEncoder();
    }

}

?>
