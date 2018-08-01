<?php

if(basename($_SERVER['PHP_SELF']) == basename(__FILE__)) die;

/**
 *  Функции
 */
 
// Функция отправки письма в формате html в кодировке utf-8
function html_mail($to, $subj, $body, $from)
{
    $s = '=?utf-8?B?'.base64_encode($subj).'?=';

    return mail($to, $s, $body, "From: $from\r\nMIME-Version: 1.0\r\nContent-Type: text/html; charset=utf-8\r\nContent-Transfer-Encoding: 8bit\r\n", '-f'.$from);
}

// Функция забора данных по определенному адресу для протокола https
function get_curl_content($u)
{
    $c = curl_init();

    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL verification
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);  // Will return the response, if false it print the response
    curl_setopt($c, CURLOPT_URL, $u);               // Set the url
  
    $r = curl_exec($c);                             // Execute

    curl_close($c);                                 // Closing

    return $r ? json_decode($r, $assoc = true) : null;
}

/**
  *  Работа с пользователями
  */

// Функция выбора пользователя
function get_user($k, $v)
{
    global $DB;

    $u = null;

    $auth_res = $DB->query("SELECT *, UNIX_TIMESTAMP()-UNIX_TIMESTAMP(`updated`) AS `uts_diff` FROM `admins` WHERE `$k`='".$DB->escape_string($v)."'");

    if(!$auth_res)
    {
        printf('Ошибка соединения с БД.', $DB->errno);
        die;
    }

    if($auth_res->num_rows !== 0)
    {
        $u = $auth_res->fetch_assoc();
        $auth_res->free();
    }

    return $u;
}

function upd_user($auth_key, $k='', $v='')
{
    global $DB;

    $DB->query("UPDATE `admins` SET ".($k ? "`$k`='$v', " : "")."`updated`=NOW() WHERE `auth_key`='$auth_key'");
}

function set_auth($key)
{
    // или добавить тут смену ключа. подумать!
//    $_SESSION['token'] = $key;
    setcookie('admin_token', $key, 0, '/');
//    setcookie('admin_token', $key, 0,'/checkin/');
}

function unset_auth()
{
    global $U;

//    unset($_SESSION['token']);
    setcookie('admin_token', '', 0, '/');
//    setcookie('admin_token', '', time()-3600);
    unset($U);
}

function get_auth()
{
//  return $_SESSION['admin_token'];
    return $_COOKIE['admin_token'];
}

function url_query_make($url_query, $key=true)
{
    $url_query .= $key ? ($url_query ? '&' : '').'key='.bin2hex(random_bytes(4)) : '';//microtime(true)

    return $url_query.'&confirm='.md5($url_query.SALT_KEY);
}

function url_query_check($url_query='')
{
    $confirm = '';
    $args = [];

    $query = $url_query ? $url_query : $_SERVER['QUERY_STRING'];

    if($query)
    {
        foreach(explode('&', $query) as $chunk)
        {
            if($param = array_map('urldecode',  explode('=', $chunk, 2)))
            {
                if($param[0] == 'confirm')
                    $confirm = $param[1];
                else
                    $args[]  = $param[0].'='.$param[1];
            }
        }

        $new_query = implode('&', $args);

        return hash_equals(md5($new_query.SALT_KEY), $confirm);
    }
    else
        return true;
}

?>