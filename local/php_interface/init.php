<?

// Константы
require('const.php');

// Функции
require('functions.php');

// Библиотеки композера
require(dirname(__FILE__) . '/../vendor/autoload.php');

// Обработчики событий
\Local\System\Handlers::addEventHandlers();

// Модули битрикса
\Bitrix\Main\Loader::IncludeModule('iblock');
\Bitrix\Main\Loader::IncludeModule('highloadblock');

defined('_DS_') or define('_DS_', DIRECTORY_SEPARATOR);
if(is_file($_SERVER['DOCUMENT_ROOT'] . _DS_ . 'local' . _DS_ . 'WM' . _DS_ . 'autoloader.php'))
    require_once $_SERVER['DOCUMENT_ROOT'] . _DS_ . 'local' . _DS_ . 'WM' . _DS_ . 'autoloader.php';
