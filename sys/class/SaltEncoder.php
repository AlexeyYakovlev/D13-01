<?php

/**
 * Salt Encoder
 *
 * Шифрование соли.
 * 
 * @package  Survey\Salt
 * @author   Yakovlev
 * @version  1.0.0
 */
abstract class SaltEncoder {

    // метод шифрования
    abstract function encode();
}

?>
