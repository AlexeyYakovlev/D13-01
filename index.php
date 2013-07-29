<?php

ini_set('display_errors', 'yes');
ini_set('memory_limit', '16000M');
ini_set('max_execution_time', 0);
ini_set('session.gc_maxlifetime', 1800);
ini_set('session.cookie_lifetime', 1800);
error_reporting(E_ALL);
date_default_timezone_set('Europe/Moscow');
session_start();
ob_start();
require 'class/DBH.php';
require 'class/Preferences.php';
require 'config.php';
$conf = Preferences::getInstance();
print($conf->getProperty("ProjectName"));
flush();
ob_flush();
ob_end_clean();
?>
