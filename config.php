<?php

/*
 * Файл конфигурации проекта.
 * @author Yakovlev
 * @version 1.0
 */

/* НАСТРОЙКИ БАЗ ДАННЫХ */
define('DB_PERSISTENCY', true);
// Сервер БД
define('DB_SERVER', 'localhost');
// Логин БД
define('DB_USERNAME', 'D1301');
// Пароль БД
define('DB_PASSWORD', 'ZDqFMvRgC');
// Имя БД
define('DB_DATABASE', 'D13-01');
// Строка подключения к БД
define('PDO_DSN', 'mysql:host=' . DB_SERVER . ';dbname=' . DB_DATABASE);

$pref = Preferences::getInstance();
$sql = "select * from config";
foreach (DBH::GetAll($sql) as $array) {
    $pref->setProperty($array['name'], $array['value']);
}
?>
