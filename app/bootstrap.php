<?php

	ini_set('display_errors', 'yes');
	ini_set('memory_limit', '16000M');
	ini_set('max_execution_time', 0);
	ini_set('session.gc_maxlifetime', 1800);
	ini_set('session.cookie_lifetime', 1800);

	date_default_timezone_set('Europe/Moscow');
	setlocale(LC_ALL, 'ru_RU.utf-8');

	/**
	 * Тут самое мето для определения Cookie переменных для приложения
	 *
	 * Cookie::$salt = '';
	 * Cookie::$expiration = '';
	 * Cookie::$domain = '';
	 *
	 * Для Cookie::$path, Cookie::$secure и Cookie::$httponly
	 * достаточно значений по умолчанию из класса Cookie.
	 * В исключительных ситуациях настраивается во время выполнения
	 */
