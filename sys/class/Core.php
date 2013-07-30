<?php

/**
 * Ядро приложения
 *
 * @package  Survey\Core
 * @author   Yakovlev
 * @version  1.0.0
 */
class Core {

    /** Номер версии для удобства */
    const VERSION = '1.0.0';

    /**
     * Индикатор, был ли уже запущен метод [Core::init]
     * @var boolean
     */
    protected static $_init = FALSE;

    /**
     * Использовать кеширование, например при поиске файлов в [Core::find_file]?
     * Устанавливается в [Core::init]
     * @var boolean
     */
    public static $caching = FALSE;

    /**
     * Кэш путей к файлу
     * @var array
     */
    protected static $_files = array();

    /**
     * Содержит места поиска файлов
     * @var array
     */
    protected static $_paths = array(APPPATH, SYSPATH);

    /**
     * Инициализация окружения
     *
     * Следующие настройки могут установлены:
     *
     * + caching - Кешировать результат поиска расположения файлов или нет?
     *             Рекомендуется в продакшене устанавливать в TRUE.
     *             Это делается в файле bootstrap.php
     */
    public static function init(array $settings = NULL) {
        if (Core::$_init){
            // Не позволяем запуститься дважды
            return;
        }

        // Инициализируем ядро
        Core::$_init = TRUE;

        // Включение буферизации вывода
        ob_start();

        if (isset($settings['caching'])) {
            // Включение или выключение кеширование результатов поиска
            Core::$caching = (bool) $settings['caching'];
        }

        if (Core::$caching === TRUE) {
            // Тут должна быть загрузка результатов поиска из кеша
            // @todo Написать метод складывающий результаты поиска в кеш
            // Core::$_files = ...
        }
    }

    /**
     * Очистка переменных окружения
     */
    public static function deinit() {
        if (Core::$_init) {

            // Отключаем собственный автозагрузчик
            spl_autoload_unregister(array('Core', 'auto_load'));

            // Сбрасываем хранилище файлов
            Core::$_paths = array(APPPATH, SYSPATH);

            // Сбрасываем индикатор
            Core::$_init = FALSE;
        }
    }

    /**
     * Автозагрузка классов с использованием SPL
     *
     * Метод обеспечивает поддержку автозагрузки классов, которые
     * были названы в соответствии с стандартом PSR-0 именования классов.
     *
     * Пример №1:<br>
     * <code>
     * // Загрузка класса class/My/Class/Name.php
     * Core::auto_load('My_Class_Name');
     * </code>
     *
     * Пример №2:<br>
     * <code>
     * // Загрузка класса не из стандартной директории, из директории vendor
     * // Следующий код ищет My/Class/Name.php в папке vendor
     * Core::auto_load('My_Class_Name', 'vendor');
     * </code>
     *
     * В принципе нет видимых причин для использования этого метода напрямую.
     * Вместо этого достаточно обратиться к классу по его имени, например
     * Name::function(...) и это приведёт к вызову этого метода.
     *
     * Для того, чтоб этот метод нормально работал, следует до метода
     * Core::init, вызывать spl_autoload_register(array('Core', 'auto_load'))
     * И желательно это делать прямо в bootstrap.php
     *
     * @param   string  $class      Имя класса
     * @param   string  $directory  Дирректория поиска [Опционально]
     *
     * @return  boolean
     */
    public static function auto_load($class, $directory = 'class') {
        // Трансформируем имя класса в соответствии в стандартом PSR-0
        $class = ltrim($class, '\\');
        $file = '';
        $ns = '';

        $last_ns_position = strripos($class, '\\');

        if ($last_ns_position)
        {
            $ns = substr($class, 0, $last_ns_position);
            $class = substr($class, $last_ns_position + 1);
            $file = str_replace('\\', DS, $ns).DS;
        }

        /**
         * Трансформируем имя класса в путь
         *
         * Если класс назвается так Cache_Core, то путь будет Cache/Core
         * Если класс назвается так Config_Wrapper_Xml, то путь будет Config/Wrapper/Xml
         */
        $file .= str_replace('_', DS, $class);

        // см. Core::find_file
        if ($path = Core::find_file($directory, $file))
        {
            // Загружаем класс
            require $path;

            // Класс успешно найден
            return TRUE;
        }

        // Класс не найден в файловой системе приложения
        return FALSE;
    }

    /**
     * Осуществляет каскадный поиск файла в файловой системе приложения
     * и возвращает файл (путь к файлу), который имеет наивысший приоритет.
     * К примеру в дальнейшем это может быть использовано для подключения файла
     * с использованием require.
     *
     * Если установлен флаг `$array` будет возвращён массив всех файлов,
     * которые соответствуют этому пути в каскадной файловой системе.
     *
     * Если расширение файла не указано, будет использовано EXT
     * Константа установлена в index.php
     *
     * Пример №1:<br>
     * <code>
     * // Возвращает абсолютный путь к файлу "views/temp.php"
     * Core::find_file('views', 'temp');
     * // В данном примере будет в первую очередь искать temp.php
     * // в папке APPPATH/views, если найдёт, то остановит поиск, если не найдёт,
     * // продолжит поиск в SYSPATH/views. Тут мы не указали расширение файла
     * </code>
     *
     * Пример №2:<br>
     * <code>
     * // Вернёт абсолютный путь к assets/css/style.css
     * Core::find_file('assets', 'css/style', 'css');
     * // Здесь мы явно указали папку для поиска, файл и расширение
     * </code>
     *
     * Пример №3:<br>
     * <code>
     * // Вернёт массив файлов example.php которые находятся в папке test
     * Core::find_file('test', 'example', NULL, TRUE);
     * // Если есть папки APPPATH/test и SYSPATH/test и в этих папках есть
     * // файл example.php все удачные результаты поиска будут возвращены
     * // в виде массива
     * </code>
     *
     * @param   string  $dir    Каталог поиска (views, class, ext, и т.п.)
     * @param   string  $file   Имя файла с подкаталогом
     * @param   string  $ext    Расширение файла
     * @param   boolean $array  Вернуть список файлов или первый попавшийся?
     *
     * @return  array   Список файлов если $array установлен в TRUE
     * @return  string  Один файл (путь)
     */
    public static function find_file($dir, $file, $ext = NULL, $array = FALSE) {
        if ($ext === NULL) {
            // Используем расширение по умолчанию
            $ext = EXT;
        }
        elseif ($ext) {
            // Если расширение передано, добавляем точку
            $ext = ".{$ext}";
        }
        else {
            // В противном случае не используем расширение
            $ext = '';
        }

        // Создаём путь к файлу
        $path = $dir.DS.$file.$ext;

        if (isset(Core::$_files[$path.($array ? '_array' : '_path')])) {
            // Путь находится в кэше
            return Core::$_files[$path.($array ? '_array' : '_path')];
        }

        if ($array) {
            // Подключаемые пути для поиска файлов должны
            // быть отсортированы в обратном порядке
            $paths = array_reverse(Core::$_paths);

            // Результат поиска в виде массива
            $found = array();

            foreach ($paths as $dir) {
                if (is_file($dir.$path)) {
                    // Это файл, добавляем в список
                    $found[] = $dir.$path;
                }
            }
        }
        else {
            // Изначально мы ничего не нашли
            $found = FALSE;

            foreach (Core::$_paths as $dir) {
                if (is_file($dir.$path)) {
                    // Нашили, что искали
                    $found = $dir.$path;

                    // Останавливаем поиск
                    break;
                }
            }
        }

        // Если кэширование разрешено...
        // см. Core::init
        if (Core::$caching === TRUE) {
            // Добавляем путь в кэш
            Core::$_files[$path.($array ? '_array' : '_path')] = $found;
        }

        return $found;
    }
}