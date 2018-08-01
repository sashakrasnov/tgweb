<?php

include_once 'func.php';

session_start();

error_reporting(E_ALL & ~E_NOTICE);
date_default_timezone_set('Europe/Moscow');

define('SALT_KEY', 'qwerty123');             // соль для проверки пароля
define('TITLE', '12-й Игрок > Управление');  // название сайта
//define('RUB', '&#8381;');                  // символ рубля
define('RUB', '<i class="fa fa-rub"></i>');  // символ рубля
define('UPLOAD_DIR', '/images/e');           // папка для изображений
define('NUM_IMAGES', 2);                     // количество картинок

$URI = explode('?', $_SERVER['REQUEST_URI'])[0];
$CFG = json_decode(@file_get_contents('../cfg.ru.json'), true);

$ADMIN_PAGE_LOC = 'Location: '.$URI;

// Проверяем конфигурацию. Если ее нет, работать дальше нельзя

if(!$CFG)
    die('Ошибка подключения конфигурации.');

// Преобразуем структуру в вид, более соответствующий PHP

foreach($CFG as $k => $v)
{
    for($i=0; isset($v[$i]); $i++)
    {
        ${'C_'.$k}[$v[$i]['id']] = $v[$i]; unset(${'C_'.$k}[$v[$i]['id']]['id']);
    }

    asort(${'C_'.$k}); // Сортируем в нужном порядке, если есть необходимость
}

/**
 *  Подключение БД
 */
/* 
//$DB = new mysqli('localhost', 'root', '', 'mundial');
$DB = new mysqli('12player.mysql.database.azure.com', 'binokle@12player', 'Allevin2006', 'mundial');

if($DB->connect_errno)
{
    printf('Ошибка соединения с сервером БД.' . PHP_EOL, $DB->connect_errno);
    die;
}

$DB->set_charset('utf8mb4');
*/
/**
 *  Авторизация по ключу. Проверяем залогиненный пользователь или нет. Получаем всю инфу о нем
 */
/*
if(get_auth() && !($U = get_user('auth_key', get_auth())) )
{
    $MSG = 'Сессия истекла.';

    unset_auth(); // снимаем ключ авторизации, не удалось найти пользователя или он поменялся
}
*/
?>