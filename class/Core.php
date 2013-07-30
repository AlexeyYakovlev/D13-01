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
     * Инициализация переменных окружения
     */
    public static function init() {
        if (Core::$_init){
            // Не позволяем запуститься дважды
            return;
        }

        // Инициализируем ядро
        Core::$_init = TRUE;
    }

    /**
     * Очистка переменных окружения
     */
    public static function deinit() {
        if (Core::$_init) {

            // Сбрасываем индикатор
            Core::$_init = FALSE;
        }
    }
}