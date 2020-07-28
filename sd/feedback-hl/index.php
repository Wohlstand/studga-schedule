<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Обратная связь - Неофициальная система расписаний МГТУ ГА</title>
    <meta content="text/html" charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=yes, minimum-scale=1.0, maximum-scale=1.0, width=device-width"/>
</head>
<body>

<?php
$error = 0;
?>

<h1 style="text-align: center;">Обратная связь</h1>

<div id=errors align="center">
<?php
if(!empty($_GET['error']))
    $error = strrev(sprintf("%10b", $_GET['error']));
else
    $error = "0000000000";
?>
<?php if($error != "0000000000") { ?>
<div style="background-color: #FFD2D2; border: 6px ridge #FF6C6C; color: #FF2222; width: 661px; text-align: left;">
<ul>
<?php

if($error[0] == "1")
    echo "<li>Неправильно введён код с картинки</li>\n";

if($error[1] == "1")
    echo "<li>Не указано Ваше имя</li>\n";

if($error[2] == "1")
    echo "<li>Не указан обратный адрес</li>\n";

if($error[3] == "1")
    echo "<li>e-mail введён не правильно</li>\n";

if($error[4] == "1")
    echo "<li>Пожалуйста, введите Ваше сообщение</li>\n";

?>
</ul>
</div>
<?php }

if(!empty($_GET['formdata']))
    $formdata = base64_decode($_GET['formdata']);
else
    $formdata = "";

if($formdata!="")
    $formfields = explode("|", $formdata);
else
    $formfields = "00000000000000000";
?>
</div>


<table align="center" cellpadding="0" style="width: 700; border-collapse: collapse">
    <tr>
        <td style="text-align: center; height: 37px">
        <form  action="sendmail.php" method="post">
            <br>Форма связи с разработчиком Системы Расписаний МГТУ ГА:<br>
            <div class="loginpannel shedow">
            <table cellpadding="0" style="width: 100%; border-collapse: collapse" cellspacing="4">
                <tr>
                    <td colspan="1">
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left; vertical-align: top;" valign="top"><strong>Ваше имя</strong></td>
                </tr>
                <tr>
                    <td>
                    <input <?php if (($error[1]=="1")) echo "class='errorfield '";?>name="sendername" style="width: 100%;" type="text" value="<?=((!empty($_GET['formdata']))?htmlspecialchars(base64_decode($formfields[0])):"")?>"></td>
                </tr>
                <tr>
                    <td style="text-align: left; vertical-align: top;">Ваш электронный адрес (ОБЯЗАТЕЛЬНО!)</td>
                </tr>
                <tr>
                    <td><input <?php if (($error[2]=="1")||($error[3]=="1")) echo "class='errorfield '"; ?>name="mailfrom" style="width: 100%;" type="text" value="<?=((!empty($_GET['formdata']))?htmlspecialchars(base64_decode($formfields[1])):"")?>"></td>
                </tr>
                <tr>
                    <td style="text-align: left; vertical-align: top;">
                        <strong>Ваше сообщение</strong>
                        <p>Просьба при сообщении об ошибках в расписании, обязательно указать группу и поток, где они были найдены.</p>
                    </td>
                </tr>
                <tr>
                    <td><textarea <?php if (($error[4]=="1")) echo "class='errorfield '";?>cols="57" rows="10" name="messg" style="width: 100%; height: 167px"><?=((!empty($_GET['formdata']))?htmlspecialchars(base64_decode($formfields[2])):"")?></textarea></td>
                </tr>
                <tr style="display: none;">
                    <td style="width: 213px; text-align: right" valign="top">
                        URL
                    </td>
                    <td>
                        <input name="url" style="width: 340px" type="text" value="">
                    </td>
                </tr>
                <tr style="display: none;">
                    <td style="width: 213px; text-align: right" valign="top">
                        Telephone
                    </td>
                    <td>
                        <input name="phone" style="width: 340px" type="text" value="">
                    </td>
                </tr>
                <tr style="display: none;">
                    <td style="width: 213px; text-align: right" valign="top">
                        Company
                    </td>
                    <td>
                        <input name="company" style="width: 340px" type="text" value="">
                    </td>
                </tr>
                <tr>
                    <td style="width: 213px; text-align: right" valign="top"></td>
                </tr>
                <tr>
            <td style="text-align: left;">
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

                echo "<div style='height: 5em;' id='captcha_container_1'>\n";
                //echo Securimage::getCaptchaHtml($options);
                echo Securimage::getCaptchaHtml($options, Securimage::HTML_IMG);
//                echo Securimage::getCaptchaHtml($options, Securimage::HTML_AUDIO);
                echo Securimage::getCaptchaHtml($options, Securimage::HTML_ICON_REFRESH);
                echo "\n</div>\n";
                echo "<br>\nВведите текст на картинке:<br>\n";
                echo Securimage::getCaptchaHtml($options, Securimage::HTML_INPUT);

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
            </tr>
            </table></div>
            <br>
            <input name="Submit1" type="submit" value="Отправить сообщение"></form>
        </td>
    </tr>
</table>
<script type="text/javascript"><!--
captchareset();
//-->
</script>

</body>
</html>
