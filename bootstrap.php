<?php
require_once 'helpers.php';

require __DIR__ . "/vendor/autoload.php";

/**
 * Директория в корень сайта
 */
define('ROOT', dirname(__FILE__));

/**
 * Директория view
 */
define('VIEW_DIR', __DIR__ . "/layout/");

/**
 * Директория view
 */
define('DEFAULT_LAYOUT', "default.php");

/**
 * Количество знаков к аннотации к посту
 */
define('IMG_DIR', __DIR__ . "/uploads/img");

/**
 * Путь к файлу логирования рассылки
 */
define('PATH_TO_SENDER_LOG', __DIR__ . "/tmp/sender.log");

/**
 * Путь к директории с настройками
 */
define('CONFIGS_DIR', "configs");

/**
 * Базовый URL для создания ссылок
 */
$url = 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 's' : '') . '://';
$url = $url . $_SERVER['SERVER_NAME'];
define('BASE_URL', $url);

/**
 * Количество знаков к аннотации к посту
 */
define('SHORT_POST_TEXT', 400);

/**
 * Формат вывода даты к посту
 */
define('POST_DATE_FORMAT', 'd/n/Y');



