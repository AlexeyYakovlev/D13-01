<?php

/*
 * Файл конфигурации проекта.
 * @author Yakovlev
 * @version 1.1
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
define('DB_DATABASE', 'D13_01');
// Строка подключения к БД
define('PDO_DSN', 'mysql:host=' . DB_SERVER . ';dbname=' . DB_DATABASE);

/* НАСТРОЙКИ ПРОЕКТА */
//инициализация ссылки на объект Preferences
$pref = Preferences::getInstance();
//выборка всех параметров настройки из БД
$sql = "select * from config";
//установка параметров проекта как свойства объекта Preferences
foreach (DBH::GetAll($sql) as $array) {
    $pref->setProperty($array['name'], $array['value']);
}
//номер проекта
define('PROJECT_NUMBER', $pref->getProperty('ProjectNumber'));

/* ПУТИ */
// Корень сайта
define('ROOT_DIR', dirname(__FILE__) . "/");
// Путь к каталогу библиотеки классов
define('CLASS_DIR', ROOT_DIR . 'class/');
// Относительный путь
define('VIRTUAL_ROOT_DIR', "/projects/");
// Путь к каталогу шаблонов
define('PRESENTATION_DIR', ROOT_DIR . 'templates/');
// Относительный путь к каталогу шаблонов
define('VIRTUAL_TEMPLATE_DIR', VIRTUAL_ROOT_DIR . "templates/");
// Путь к библиотеке Smarty
define('SMARTY_DIR', CLASS_DIR . 'smarty/');
// Путь к каталогу шаблона
define('TEMPLATE_DIR', PRESENTATION_DIR);
// Путь к каталогу кеша шаблона
define('COMPILE_DIR', ROOT_DIR . 'templates_c/');
// Путь к каталогу конфигураций
define('CONFIG_DIR', ROOT_DIR . 'configs/');
// Путь к логам ошибок
define('LOG_ERROR_FILE', ROOT_DIR . 'logs/error.log');

/* СИСТЕМНЫЕ НАСТРОЙКИ */
// Включать ли обработчкик ошибок при фатальных ошибках (true вкл, false выкл)
define('IS_WARRNING_FATAL', true);
// Режим отладки (1 вкл, 0 выкл)
define('DEBUGGING', 0);
// Кеширование (1 вкл, 0 выкл)
define('CACHING', 0);
// Тип обрабатываемых ошибок
define('ERROR_TYPES', E_ALL);
// Писать лог ошибок (true вкл, false выкл)
define('LOG_ERROR', true);
// Шаблон текста о ошибке
define('GENERIC_ERROR_MESSAGE', '<h1>Error!</h1>');
// Отправлять письма о ошибках (true вкл, false выкл)
define('SEND_ERROR_MAIL', false);
// Выключить сайт для пользователей
define('UNDER_CONSTRUCTION', false);
// Страница ошибки по умолчанию
define('ERROR_PAGE', "ToIndex");

/* ПОЧТОВЫЕ НАСТРОЙКИ */
// Административный почтовый ящик
define('ADMIN_ERROR_MAIL', "support@radar-survey.ru");
// Отправлять письма от
define('SENDMAIL_FROM', "info@radar-survey.ru");
// Почтовый сервер
define('SMTP_SERVER', "radar-survey.ru");
// Логин к почтовому серверу
define('SMTP_LOGIN', "info@radar-survey.ru");
// Пароль к почтовому серверу
define('SMTP_PASSWORD', "3QmZyiQZ");
// Тип отправляемых сообщений
define('MAIL_MESSAGE_TYPE', "html");
// Приоритет писем
define('MAIL_PRIORITY', 1);
// Кодировка писем
define('MAIL_CHARSET', 'utf-8');
// Дректива для php о отправителе
ini_set('sendmail_from', SENDMAIL_FROM);
?>
