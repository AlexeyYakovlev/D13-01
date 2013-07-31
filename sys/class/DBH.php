<?php

/**
 * @author Yakovlev
 * @version 1.0.0
 * Data Base Handler (Singleton). 
 * Выборка данных из БД.
 */
class DBH {
    /*
     * @access private
     * Посредник.
     */

    private static $_mHandler;

    /*
     * @access private
     * Конструктор по умолчанию зарещает напрямую создавать экземпляры данного класса.
     */

    private function __construct() {
        
    }

    /*
     * @access public
     * Get instanse.
     * Создаст или вернет экземпляр класса PDO.
     */

    private static function GetHandler() {
        if (!isset(self::$_mHandler)) {
            try {
                self::$_mHandler = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::ATTR_PERSISTENT => DB_PERSISTENCY));
                self::$_mHandler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$_mHandler->query("set names utf8");
            } catch (PDOException $e) {
                self::Close();
                trigger_error($e->getMessage(), E_USER_ERROR);
            }
        }
        return self::$_mHandler;
    }

    /*
     * @access public
     * Close connection.
     * Уничтожает соединение.
     */

    public static function Close() {
        self::$_mHandler = null;
    }

    /*
     * @access public
     * Execute query.
     * Выполняет запрос.
     */

    public static function Execute($sqlQuery, $params = null) {
        try {
            $database_handler = self::GetHandler();
            $statement_handler = $database_handler->prepare($sqlQuery);
            $statement_handler->execute($params);
        } catch (PDOException $e) {
            self::Close();
            trigger_error($e->getMessage(), E_USER_ERROR);
        }
    }

    /*
     * @access public
     * Get all the results on the query.
     * Получить все результаты запроса.
     */

    public static function GetAll($sqlQuery, $params = null, $fetchStyle = PDO::FETCH_ASSOC) {
        $result = null;
        try {
            $database_handler = self::GetHandler();
            $statement_handler = $database_handler->prepare($sqlQuery);
            $statement_handler->execute($params);
            $result = $statement_handler->fetchAll($fetchStyle);
        } catch (PDOException $e) {
            self::Close();
            trigger_error($e->getMessage(), E_USER_ERROR);
        }
        return $result;
    }

    /*
     * @access public
     * Get a row of the query result.
     * Получить строку таблицы результата запроса.
     */

    public static function GetRow($sqlQuery, $params = null, $fetchStyle = PDO::FETCH_ASSOC) {
        $result = null;
        try {
            $database_handler = self::GetHandler();
            $statement_handler = $database_handler->prepare($sqlQuery);
            $statement_handler->execute($params);
            $result = $statement_handler->fetch($fetchStyle);
        } catch (PDOException $e) {
            self::Close();
            trigger_error($e->getMessage(), E_USER_ERROR);
        }
        return $result;
    }

    /*
     * @access public
     * Get a value of the query result.
     * Получить значение результата запроса.
     */

    public static function GetOne($sqlQuery, $params = null) {
        $result = null;
        try {
            $database_handler = self::GetHandler();
            $statement_handler = $database_handler->prepare($sqlQuery);
            $statement_handler->execute($params);
            $result = $statement_handler->fetch(PDO::FETCH_NUM);
            $result = $result[0];
        } catch (PDOException $e) {
            self::Close();
            trigger_error($e->getMessage(), E_USER_ERROR);
        }
        return $result;
    }

}