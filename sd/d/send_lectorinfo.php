<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="ru" http-equiv="Content-Language" />
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Сообщить информацию о преподавателе</title>
<link rel="stylesheet" href="/css/style.css" type="text/css" />
</head>

<body>

<h2>Сообщить информацию о преподавателе</h2>
<div id="errors" align="center">
<?php
if (!empty($_GET['error']))
    $error = strrev(sprintf("%10b", $_GET['error']));
else
    $error = "0000000000";
?>
<?php
if ($error != "0000000000")
{
?>
<div style="background-color: #FFD2D2; border: 6px ridge #FF6C6C; color: #FF2222; width: 80%; text-align: left;">
<ul>
<?php

    if ($error[0] == "1")
    {
        echo "<li>Неправильно введён код с картинки</li>\n";
    }
    if ($error[1] == "1")
    {
        echo "<li>Информация не заполнена</li>\n";
    }
?>
</ul>
</div>
<?php
}

if (!empty($_GET['formdata']))
    $formdata = base64_decode($_GET['formdata']);
else
    $formdata = "";

if ($formdata != "")
{
    $formfields = explode("|", $formdata);
}
else
    $formfields = "00000000000000000";
?>
</div>
<p>Помогите нам составить полный и подробный список преподавателей.</p>
<p style="text-decoration: underline">Заполнять всё - не обязательно. Заполните то, что хотите добавить/исправить/заменить, остальные поля можете оставить пустыми</p>
<form method="post" action="send_action.php">
<input name="datatype" type="hidden" value="lector" />
<input name="object_id" type="hidden" value="<?= intval($_GET['obj_id']); ?>" />
<p>Полные ФИО<br /><input value="<?= ($formdata != "") ? base64_decode($formfields[1]) : "" ?>" name="fullname" type="text" style="width: 488px" />
</p>
<p>Учёная степень<br /><input value="<?= ($formdata != "") ? base64_decode($formfields[2]) : "" ?>" name="scince_rank" type="text" style="width: 488px" /></p>
<p>Комментарий (в т.ч. сообщение об увольнении преподавателя из университета)<br />
<textarea name="comment" rows="6" cols="150" style="width: 488px; height: 96px;"><?= ($formdata != "") ? htmlspecialchars(base64_decode($formfields[3])) : "" ?></textarea></p>
    <p>
    <?php
        // show captcha HTML using Securimage::getCaptchaHtml()
        require_once dirname(__FILE__) . '/../securimage/securimage.php';
        $options = array();
        $options['input_name']             = 'wordofchuckenshit';
        $options['disable_flash_fallback'] = false; // allow flash fallback

        if (!empty($_SESSION['ctform']['captcha_error'])) {
            // error html to show in captcha output
            $options['error_html'] = $_SESSION['ctform']['captcha_error'];
        }

        echo "<div id='captcha_container_1'>\n";
        //echo Securimage::getCaptchaHtml($options);
        echo Securimage::getCaptchaHtml($options, Securimage::HTML_IMG);
        echo Securimage::getCaptchaHtml($options, Securimage::HTML_AUDIO);
        echo Securimage::getCaptchaHtml($options, Securimage::HTML_ICON_REFRESH);
        echo "<br>\nВведите текст на картинке:<br>\n";
        echo Securimage::getCaptchaHtml($options, Securimage::HTML_INPUT);
        echo "\n</div>\n";

        /*
        // To render some or all captcha components individually
        $options['input_name'] = 'ct_captcha_2';
        $options['image_id']   = 'ct_captcha_2';
        $options['input_id']   = 'ct_captcha_2';
        $options['namespace']  = 'captcha2';

        echo "<br>\n<div id='captcha_container_2'>\n";
        echo Securimage::getCaptchaHtml($options, Securimage::HTML_IMG);

        echo Securimage::getCaptchaHtml($options, Securimage::HTML_ICON_REFRESH);
        echo Securimage::getCaptchaHtml($options, Securimage::HTML_AUDIO);

        echo '<div style="clear: both"></div>';

        echo Securimage::getCaptchaHtml($options, Securimage::HTML_INPUT_LABEL);
        echo Securimage::getCaptchaHtml($options, Securimage::HTML_INPUT);
        echo "\n</div>";
        */
    ?>
    </p>
    <p>
    <input name="send" style="width: 121px" type="submit" value="Отправить" /></p>
</form>
</body>

</html>
