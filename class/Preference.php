<?php

/**
 * @author Yakovlev
 * @version 1.0
 * Preferenses (Singleton). 
 * Реализует конфигурацию.
 */
class Preference {
    /*
     * @access private
     * Массив, который будет содержать все данные настроек.
     */

    private $props = array();

    /*
     * @access private
     * Посредник.
     */
    private static $instance;

    /*
     * @access private
     * Конструктор по умолчанию зарещает напрямую создавать экземпляры данного класса.
     */

    private function __construct() {
        
    }

    /*
     * @access public
     * Get instanse.
     * Создаст или вернет экземпляр данного класса.
     */

    public static function getInstance() {
        if (empty(self::$instance)) {
            self::$instance = new Preference();
        }
        return self::$instance;
    }

    /*
     * @access public
     * Set property.
     */

    public function setProperty($key, $val) {
        $this->props[$key] = $val;
    }

    /*
     * @access public
     * Get property.
     */

    public function getProperty($key) {
        return $this->props[$key];
    }

}

?>
