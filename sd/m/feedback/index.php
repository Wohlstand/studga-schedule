<?php
require_once "../../config.php";

$page_title = "Обратная связь - ".$SiteTitle;
$sys_inc = "../../../sys/";
require_once $sys_inc."mobile-html-header.php";
require_once $sys_inc."mobile-html-titlebar.php";
require_once "../../_menu_m.php";
$error = 0;
?>

<h1>Обратная связь</h1>

<div id="errors" style="text-align: center; width: 100%;">
<?php
if(!empty($_GET['error']))
$error = strrev(sprintf("%10b", $_GET['error']));
else
$error = "0000000000";

if($error!="0000000000") { ?>
<div style="margin: auto auto; background-color: #FFD2D2; border: 6px ridge #FF6C6C; color: #FF2222; width: 95%; text-align: left;">
<ul>
<?php

if($error[0]=="1")
{
    echo "<li>Не правильно введён код с картинки</li>\n";
}
if($error[1]=="1")
{
    echo "<li>Не указано Ваше имя</li>\n";
}
if($error[2]=="1")
{
    echo "<li>Не указан обратный адрес</li>\n";
}
if($error[3]=="1")
{
    echo "<li>e-mail введён не правильно</li>\n";
}
if($error[4]=="1")
{
    echo "<li>Пожалуйста, введите Ваше сообщение</li>\n";
}
?>
</ul>
</div>
<?php
}

if(!empty($_GET['formdata']))
    $formdata = base64_decode($_GET['formdata']);
else
    $formdata = "";

if($formdata != "")
{
    $formfields = explode("|", $formdata);
}
else
$formfields = "00000000000000000";
?>
</div>

<table style="margin: auto auto; width: 95%; border-collapse: collapse">
    <tr>
        <td style="padding: 0px; text-align: center; height: 37px">
        <form action="sendmail.php" method="post">
            <div>
                <br/>Форма связи с разработчиком:<br/><br/>
                <br/>
            <div>
            <table style="width: 100%; border-collapse: collapse">
                <tr>
                    <td>
                        Прежде, чем задавать какой-либо вопрос, просим Вас обратить внимание на <a href="/m/about/faq">часто завадаемые вопросы</a>.
                        <br/>
                        <br/>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 0px; width: 100%; text-align: left" valign="top">
                        Ваше имя:<br/>
                        <input <?php if (($error[1]=="1")) echo "class='errorfield '";?>name="sendername" style="width: 100%" type="text" value="<?=((!empty($_GET['formdata']))?htmlspecialchars(base64_decode($formfields[0])):"")?>"/>
                        <br/>
                        <br/>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 0px; width: 100%; text-align: left" valign="top">
                        Ваш электронный адрес<br/>
                        <input <?php if (($error[2]=="1")||($error[3]=="1")) echo "class='errorfield '";?>name="mailfrom" style="width: 100%" type="text" value="<?=((!empty($_GET['formdata']))?htmlspecialchars(base64_decode($formfields[1])):"")?>"/>
                        <br/>
                        <br/>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 0px; width: 100%; text-align: left" valign="top">
                        <strong>Ваше сообщение</strong>
                        <p>Просьба при сообщении об ошибках в расписании, обязательно указать группу и поток, где они были найдены.</p>
                    <textarea <?php if (($error[4]=="1")) echo "class='errorfield '";?>cols="54" rows="10" name="messg" style="width: 100%; height: 167px"><?=((!empty($_GET['formdata'])) ? htmlspecialchars(base64_decode($formfields[2])):"")?></textarea></td>
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
                <td style="padding: 0px; width: 100%; text-align: center" valign="top">
                <?php
                    // show captcha HTML using Securimage::getCaptchaHtml()
                    require_once dirname(__FILE__) . '/../../securimage/securimage.php';
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
                    echo "<br>\nВведите текст на картинке:";
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
                </tr>
            </table>
            <br/>
            <input name="Submit1" type="submit" value="Отправить сообщение"/></div></form>
        </td>
    </tr>
</table>
<script type="text/javascript"><!--
captchareset();
//-->
</script>
<?php require_once $sys_inc."mobile-html-footer.php"; ?>
