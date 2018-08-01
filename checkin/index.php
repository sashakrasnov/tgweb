<?php

include '../admin/inc/cfg.php';

if(get_auth())
{
    include '../admin/inc/db.php';

    if($U = get_user('auth_key', get_auth())) // авторизация
    {
        $tid = $_GET['t'];

        $id = intval(substr($tid, 12));
        $code = $DB->escape_string(substr($tid, 0, 11));

        if($id && $code && $_GET['confirm'] && url_query_check())
        {
            $DB->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);

            if($DB->query("UPDATE `tickets` SET `status` = 1 WHERE `id` = $id AND `t_code`='$code' AND `status`=0"))
                $DB->commit();
            else
                $DB->rollback();
        }

        $t = $DB->query("SELECT `t`.*, `e`.`title`, `e`.`city_id`, DATE_FORMAT(`e`.`dt`, '%d.%m.%Y') AS `d`, DATE_FORMAT(`e`.`dt`, '%h:%m') AS `t` FROM `tickets` AS `t`, `events` AS `e` WHERE `t`.`id`=$id AND `t`.`t_code`='$code' AND `t`.`event_id`=`e`.`id` AND `e`.`status`>=0".($U['org_id'] ? ' AND `e`.`org_id`='.$U['org_id'] : ''))->fetch_assoc();

        $DB->close();
    }
    else
    {
        $DB->close();

        header('Location: /');
    }
}
else
    header('Location: /');

?>

<!DOCTYPE html lang="ru">
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>

    <style>
    .div-center {
        width: 400px;
        height: 400px;
        background-color: #fff;
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        margin: auto;
        max-width: 100%;
        max-height: 100%;
        overflow: auto;
        display: table;
    }
    .div-content {
        display: table-cell;
        vertical-align: middle;
    }
    </style>

    <title>12-й Игрок > Погашение билетов</title>
</head>
<body>
    <div class="div-center">
      <div class="div-content jumbotron bg-light text-center">
        <!--<img src="/logo/web_icon_48.png">-->
        <img src="/logo/12-trans-mid.png" style="height: 50px; object-fit: contain;">
        <?php if($U['org_id']): ?>
        <img src="/css/org/<?=$U['org_id'];?>.png" class="ml-3" style="height: 70px; object-fit: contain;">
        <?php endif; ?>
        <h3 class="mt-2"><small>Погашение билета</small></h3>
        <?php if($t): ?>
        <div class="my-4">
          <p><strong>Название:</strong> <?=$t['title'];?></p>
          <p><strong>Дата и время:</strong> <?=$t['d'];?> <?=$t['t'];?></p>
          <p><strong>Город:</strong> <?=$C_cities[$t['city_id']]['title'];?></p>
          <p><strong>Билет №:</strong> <?=$t['t_code'];?>-<?=$t['id'];?></p>
        </div>
            <?php if($t['status'] > 0): ?>
        <div class="alert alert-success mt-5">Билет погашен.</div>
            <?php elseif($t['status'] == 0): ?>
        <a href="./?<?=url_query_make('t='.$tid, false);?>"><button type="submit" name="submit" value="confirm-submit" class="btn btn-primary btn-lg w-100">Погасить</button></a>
        <!--
        <form action="./?<?=url_query_make('t='.$tid, false);?>" method="post">
          <div class="form-group">
            <button type="submit" name="submit" value="confirm-submit" class="btn btn-primary btn-lg w-100">Погасить</button>
          </div>
        </form>
        -->
            <?php else: ?>
        <div class="alert alert-danger mt-4">Билет не действителен, т.к. по нему был осуществлен возврат средств.</div>
            <?php endif;?>
        <?php else: ?>
        <div class="alert alert-danger mt-4">Билет с таким номером не найден!</div>
        <?php endif; ?>
      </div>
    </div>
</body>
</html>