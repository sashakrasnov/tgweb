<?php

if(basename($_SERVER['PHP_SELF']) == basename(__FILE__)) die;

/**
 *  Обработка самбитов
 */

if($_POST['submit']):

/**
 *  Логины и Логауты
 */

if($_REQUEST['task'] == 'logout')    // выход из системы
{
    unset_auth();

    header($ADMIN_PAGE_LOC);
    exit;
}

if($_REQUEST['task'] == 'login')   // вход в систему
{
    if($_POST['email'] && $_POST['passw'] && $U = get_user('email', $_POST['email'])) // есть такой пользователь
    {
        //if(password_verify($_POST['passw'], $u['passw']))
        if(hash_equals(md5($_POST['passw'].SALT_KEY), $U['passw'])) // пароль совпадает
        {
            $old_auth = $U['auth_key'];

            $U['auth_key'] = md5($U['id'].$U['email'].microtime(true));

            upd_user($old_auth, 'auth_key', $U['auth_key']);
            set_auth($U['auth_key']);

            header($ADMIN_PAGE_LOC);
            exit;
        }
        else // неправильный пароль
        {
            $MSG = 'Неверное имя пользователя или пароль.'; unset($U);
        }
    }
    // пользователь не найден
    else
    {
        $MSG = 'Неверное имя пользователя или пароль.'; unset($U);
    }
}

/**
 *  Только аутентифицированные пользователи
 */

if($_REQUEST['task'] == 'events' && $_REQUEST['p'] == 'edit' && $U['auth_key'])
{
    list($dd, $mm, $yy) = explode('.', $_POST['d']);
    list($hh, $ii) = explode(':', $_POST['t']);

    // Приводим все в числовой вид
    $P = array_map('intval', $_POST);

    // Дата мероприятия
    $dt = $yy.'-'.$mm.'-'.$dd.' '.$hh.':'.$ii;

    // Идентификатор события. Может быть "0", но впоследсвии будет хранить id нового мероприятия, если все ok
    $event_id = $P['event_id'];

    if(!$P['org'])
        $MSG .= '<li>Организацию, проводящую мероприятие</li>';

    if(!$P['city'])
        $MSG .= '<li>Город проведния мероприятия</li>';

    if(!$P['lang'])
        $MSG .= '<li>Язык, но котором будет проводиться мероприятие</li>';

    if(!($dd && $mm && $yy && checkdate($mm, $dd, $yy) && $hh >= '00' && $hh <= '23' && $ii >= '00' && $ii <= '59' && ($dt >= strftime('%Y-%m-%d %H:%M') || $event_id)))
        $MSG .= '<li>Дату и время проведения мероприятия. Обратите внимание, она не может быть ранее текущих даты и времени</li>';

    if($P['price'] <= 0)
        $MSG .= '<li>Стоимость билета на мероприятие</li>';

    if($P['count_min'] <= 0)
        $MSG .= '<li>Минимальное количество проданных билетов, при котором мероприятие состоится</li>';

    if($P['count_max'] <= 0 || $P['count_max'] < $P['count_min'])
        $MSG .= '<li>Максимальное количество билетов на мероприятие</li>';

    if($P['count_free'] < 0 || $P['count_free'] > $P['count_max'])
        $MSG .= '<li>Количество бесплатных билетов на мероприятие</li>';

    if(!$_POST['game'])
        $MSG .= '<li>Тип мероприятия</li>';

    if(!$_POST['title'])
        $MSG .= '<li>Название мероприятия</li>';
    
    if(!$_POST['addr'])
        $MSG .= '<li>Адрес проведения мероприятия</li>';
    
    if(!$_POST['map'])
        $MSG .= '<li>Ссылку на карту местонахождения мероприятия</li>';
    
    if(!$_POST['descr'])
        $MSG .= '<li>Краткое описание мероприятия</li>';

    if(!$_POST['long_descr'])
        $MSG .= '<li>Длинное описание мероприятия</li>';

    if($_POST['link'] && !filter_var($_POST['link'], FILTER_VALIDATE_URL))
        $MSG .= '<li>Корректную ссылку на отчет о мероприятии</li>';

    // Обновляем или добавляем информацию только если не было ошибок
    if(!$MSG)
    {
        $link   = $DB->escape_string($_POST['link']);
        $title  = $DB->escape_string($_POST['title']);
        $addr   = $DB->escape_string($_POST['addr']);
        $map    = $DB->escape_string($_POST['map']);
        $descr  = $DB->escape_string($_POST['descr']);
        $ldescr = $DB->escape_string($_POST['long_descr']);

        // Обновляем мероприятие, только те поля, которые необходимы, и не более
        if($event_id)
        {
            $res = $DB->query("UPDATE `events` SET `title`='$title', `addr`='$addr', `map`='$map', `descr`='$descr', `descr`='$descr', `long_descr`='$ldescr', `admin_id`={$U['id']}, `game_id`={$P['game']} WHERE `id`=".$event_id);

            if(!$res)
                $MSG .= '<li>Произошла ошибка при работе с БД на сервере при обновлении информации о мероприятии</li>';
        }
        // Добавляем новое мероприятие и получаем его идентификатор, если все прошло ok
        else
        {
            $res = $DB->query("INSERT INTO `events` (`title`, `descr`, `long_descr`, `org_id`, `lang_id`, `dt`, `status`, `game_id`, `city_id`, `price`, `count_min`, `count_max`, `count_free`, `count_paid`, `link`, `admin_id`, `addr`, `map`) VALUES ('$title', '$descr', '$ldescr', {$P['org']}, {$P['lang']}, '$dt:00', 0, {$P['game']}, {$P['city']}, {$P['price']}, {$P['count_min']}, {$P['count_max']}, {$P['count_free']}, 0, '', {$U['id']}, '$addr', '$map')");

            if(!$res)
                $MSG .= '<li>Произошла ошибка при работе с БД на сервере при добавлении нового мероприятия</li>';
            else
                $event_id = $DB->insert_id;
        }
    }

    if($event_id)
    {
        //print_r($_FILES);
        for($i = 1; $i <= NUM_IMAGES; $i++)
        {
            $eimg = 'event_img_'.$i;

            if($_FILES[$eimg]['error'] == UPLOAD_ERR_OK) // картинка зааплоадена, все ок
            {
                if(dirname($_FILES[$eimg]['type']) == 'image')
                {
                    $ext = pathinfo($_FILES[$eimg]['name'], PATHINFO_EXTENSION);
                    $dst = $_SERVER['DOCUMENT_ROOT'].UPLOAD_DIR.'/'.$event_id.'-'.$i.'.'.$ext;

                    if(move_uploaded_file($_FILES[$eimg]['tmp_name'], $dst))
                    {
                        if(!$DB->query("UPDATE `events` SET `img_ext_$i`='$ext' WHERE `id`=".$event_id))
                            $MSG .= '<Li>Возникла ошибка при обновлении информации о изображении в БД на сервере</li>';
                    }
                    else
                        $MSG .= '<li>Произошла ошибка во время обработки изображения</li>';
                }
                else
                {
                    $MSG .= '<li>Загружаемый файл не является изображением</li>';
                }
            }
            //elseif($_FILES['event_img']['error'] != UPLOAD_ERR_NO_FILE)
            //{
            //    $MSG .= '<li>Произошла ошибка при загрузке файла на сервер</li>';
            //}
        }
    }

    // Проверяем еще раз на ошибки. Они могли появиться на этапе добавления в БД и сохранения картинки
    if($MSG)
    {
        $MSG = 'Необходимо корректно заполнить следующие данные:<ul>'.$MSG.'</ul>';
    }
    else
    {
        header($ADMIN_PAGE_LOC);
        exit;
    }
}

// редактирование/создание Телеграм-пользователей
if($_REQUEST['task'] == 'bot' && $_REQUEST['p'] == 'users' && $U)
{
    $org_id = intval($_GET['i']);

    if(url_query_check() && $org_id)
    {
        foreach($U['city_id'] ? array($U['city_id']) : array_keys($C_cities) as $c)
        {
            if(isset($_POST['city-'.$c]))
            {
                $usr = array_map('trim', explode(',', $_POST['city-'.$c]));

                $DB->query("DELETE FROM `{$_GET['b']}_admins` WHERE `org_id`=$org_id AND `city_id`=$c");

                for($u = 0; $u < count($usr); $u++) if($usr[$u] != '') if(!$DB->query("INSERT INTO `{$_GET['b']}_admins` (`uname`, `org_id`, `city_id`) VALUES ('{$usr[$u]}', $org_id, $c)"))
                    $MSG .= 'Произошла ошибка во время обновления БД';
            }
        }
    }

    //header($ADMIN_PAGE_LOC);
    //exit;
}

if($_REQUEST['task'] == 'tickets' && $_REQUEST['p'] == 'check' && $U)
{
    $tid = intval($_GET['i']);
    $tcode = $DB->escape_string($_GET['code']);

    if($tid && $tcode && url_query_check())
    {
        $DB->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);

        if($DB->query("UPDATE `tickets` SET `status` = 1 WHERE `id` = $tid AND `t_code`='$tcode'"))
            $DB->commit();
        else
            $DB->rollback();
    }
}

endif;

if($_REQUEST['task'] == 'events' && $_REQUEST['p'] == 'status-up' && $U['auth_key'])
{
    if(url_query_check())
    {
        $DB->query("UPDATE `events` SET `status`=1 WHERE `id`=".intval($_REQUEST['i']));
    }

    header($ADMIN_PAGE_LOC);
    exit;
}

if($_REQUEST['task'] == 'events' && $_REQUEST['p'] == 'status-dn' && $U['auth_key'])
{
    if(url_query_check())
    {
        $DB->query("UPDATE `events` SET `status`=-1 WHERE `id`=".intval($_REQUEST['i']));
    }

    header($ADMIN_PAGE_LOC);
    exit;
}

if($_REQUEST['task'] == 'events' && $_REQUEST['p'] == 'remove' && $U['auth_key'])
{
    if(url_query_check())
    {
        $e = $DB->query("SELECT `id`, `img_ext` FROM `events` WHERE `id`=".intval($_REQUEST['i']))->fetch_assoc();

        unlink($_SERVER['DOCUMENT_ROOT'].UPLOAD_DIR.'/'.$e['id'].'.'.$e['img_ext']);

        $DB->query("DELETE FROM `events` WHERE `id`=".$e['id']);
        //$DB->query("DELETE FROM `tickets` WHERE `event_id`=".$e['id']);
    }

    header($ADMIN_PAGE_LOC);
    exit;
}

?>