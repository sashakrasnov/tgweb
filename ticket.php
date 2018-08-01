<?php

error_reporting(E_ALL & ~E_NOTICE);
date_default_timezone_set('Europe/Moscow');

define('SALT_KEY', '7QU=64&3F4a%');
define('IMG_ADDR', './images/t/');
define('QR_S', 300);
define('IMG_TYPE', explode('.', $_SERVER['REDIRECT_URL'])[1]);

function load_ticket_file($id)
{
    $fn = IMG_ADDR.$id.'.'.IMG_TYPE;

    header('Content-type: image/'.IMG_TYPE);
    //header('Cache-control: public');
    //header('Pragma: cache');
    //header('Expires: ' . gmdate('D, d M Y H:i:s', time()+ 86400*365) . ' GMT');
    //header('Content-Length: ' . filesize($fn));

    @readfile($fn);
}

/**
 *  Входные параметры
 */

$t_no = $_GET['id'];     // Полный номер билета, состоит из <code>-<id>
$key  = $_GET['key'];    //

$o = 0; // Будет не равно нулю, если c <key> все в порядке

for($i=1; $i<=4; $i++)
    if(md5($t_no.$i.SALT_KEY) == $key)
    {
        $o = $i;
        break;
    }

// <key> правильный
if($o)
{
    if(file_exists(IMG_ADDR.$t_no.'.'.IMG_TYPE))
        load_ticket_file($t_no);
    else
    {
        $check_url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].'/checkin/?t='.$t_no;
        $qr_url = 'https://chart.googleapis.com/chart?'.
                   http_build_query(['chs' => QR_S.'x'.QR_S, 'cht' => 'qr', 'chl' => $check_url, 'choe'=>'UTF-8']);

        $tpl = @imagecreatefrompng(IMG_ADDR.'tpl/'.$o.'.png');
        $qr  = @imagecreatefromstring(file_get_contents($qr_url));

        if($tpl && $qr)
        {
            $font = 5;
            $font_h = imagefontheight($font);
            $font_w = imagefontwidth($font);

            $fo = IMG_ADDR.$t_no.'.'.IMG_TYPE;

            imagestring($qr, 5, round((QR_S-strlen($t_no)*$font_w)/2), round(QR_S-(34+$font_h)/2), $t_no,imagecolorallocate($qr, 0, 0, 0));
            imagecopy($tpl, $qr, 0, imagesy($tpl)-QR_S, 0, 0, QR_S, QR_S);

            header('Content-type: image/'.IMG_TYPE);

            if(IMG_TYPE == 'jpg')
            {
                @imagejpeg($tpl, null, 100);
                @imagejpeg($tpl, $fo, 100);
            }
            elseif(IMG_TYPE == 'png')
            {
                @imagepng($tpl, null, 9);
                @imagepng($tpl, $fo, 9);
            }
            elseif(IMG_TYPE == 'gif')
            {
                @imagegif($tpl);
                @imagegif($tpl, $fo);
            }
        }
        else
        {
            load_ticket_file('tpl/no-image');
        }
    }
}
else
{
  load_ticket_file('tpl/no-image');
}

?>