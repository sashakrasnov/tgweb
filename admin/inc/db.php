<?php

if(basename($_SERVER['PHP_SELF']) == basename(__FILE__)) die;

/**
 *  Подключение БД
 */
 
//$DB = new mysqli('localhost', 'root', '', 'mundial');
$DB = new mysqli('12playerdb.mysql.database.azure.com', '<Azure username>', '<Azure password>', 'mundial');

if($DB->connect_errno)
{
    printf('Ошибка соединения с сервером БД.' . PHP_EOL, $DB->connect_errno);
    die;
}

$DB->set_charset('utf8mb4');

?>