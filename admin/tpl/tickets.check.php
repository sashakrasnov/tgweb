<?php

if($_POST['tid1'] && $_POST['tid2'] && $_POST['tid3'])
{
    $tid = intval($_POST['tid3']);
    $tcode = intval($_POST['tid1']).'-'.intval($_POST['tid2']);
}

if($_GET['i'] && $_GET['code'] && url_query_check())
{
    $tid = intval($_GET['i']);
    $tcode = $DB->escape_string($_GET['code']);
}

if($tid && $tcode)
{
    #$t = $DB->query("SELECT `t`.*, `e`.`title`, `e`.`city_id`, DATE_FORMAT(`e`.`dt`, '%d.%m.%Y') AS `d`, DATE_FORMAT(`e`.`dt`, '%h:%m') AS `t` FROM `tickets` AS `t`, `events` AS `e` WHERE `t`.`id`=$tid AND `t`.`t_code`='$tcode' AND `t`.`status`>=0 AND `t`.`event_id`=`e`.`id` AND `e`.`status`>=0")->fetch_assoc();
    $t = $DB->query("SELECT `t`.*, `e`.`title`, `e`.`city_id`, DATE_FORMAT(`e`.`dt`, '%d.%m.%Y') AS `d`, DATE_FORMAT(`e`.`dt`, '%h:%m') AS `t` FROM `tickets` AS `t`, `events` AS `e` WHERE `t`.`id`=$tid AND `t`.`t_code`='$tcode' AND `t`.`event_id`=`e`.`id` AND `e`.`status`>=0".($U['org_id'] ? ' AND `e`.`org_id`='.$U['org_id'] : ''))->fetch_assoc();
}
?>
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

    <div class="div-center">
      <div class="div-content jumbotron bg-light">
        <h3 class="mb-2 text-center"><small>Погашение билета</small></h3>
        <!--<hr class="my-3">-->
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
        <form action="./?<?=url_query_make('task=tickets&p=check&i='.$tid.'&code='.$tcode, false);?>" method="post">
          <div class="form-group">
            <button type="submit" name="submit" value="check-submit" class="btn btn-primary btn-lg w-100">Погасить</button>
          </div>
        </form>
            <?php else: ?>
        <div class="alert alert-danger mt-5">Билет не действителен, т.к. по нему был осуществлен возврат средств.</div>
            <?php endif;?>
        <?php elseif($tid && $tcode): ?>
        <div class="alert alert-danger mt-5">Билет с таким номером не найден!</div>
        <?php else: ?>
        <form action="./?task=tickets&p=check" method="post">
          <div class="form-group text-center row">
            <div class="col"><input type="text" size="5" maxlength="5" name="tid1" id="tid1" placeholder="" value="" class="form-control custom-input" onkeyup="if($(this).val().length==5) $('#tid2').focus();"></div>
            <div class="col"><input type="text" size="5" maxlength="5" name="tid2" id="tid2" placeholder="" value="" class="form-control custom-input" onkeyup="if($(this).val().length==5) $('#tid3').focus();"></div>
            <div class="col-5"><input type="text" size="9" maxlength="9" name="tid3" id="tid3" placeholder="" value="" class="form-control custom-input"></div>
          </div>
          <div class="form-group">
            <button type="submit" name="submit" value="find-submit" class="btn btn-primary btn-lg w-100">Найти</button>
          </div>
        </form>
        <?php endif; ?>
      </div>
    </div>
</body>
</html