<?php
require_once "../config.php";
$page_title = "Обратная связь - ".$SiteTitle;

$sys_inc = "../../sys/";
require $sys_inc."html-header.php";
require $sys_inc."html-titlebar.php";
require "../_menu.php";
?>
<script type="text/javascript">
function onLoad()
{
    captchareset();
}

var imgscr = "/sys/capcha/?<?php echo session_name()?>=<?php echo session_id()?>";
function captchareset()
{
    document.getElementById('captcha').src = imgscr + "&" + Math.random();
    return false;
}
</script>

<h1>Сообщение отправлено!</h1>
<center>Ваше сообщение успешно отправлено,<br>Благодармим Вас за обращение!</center>


<?php
require $sys_inc."html-footer.php";
?>
