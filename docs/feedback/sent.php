<?php
$title = "Контакты - Сеть WohlNET";
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

<script src='../bird.js' type='text/javascript'>
</script>
<script type='text/javascript'>
var twitterAccount = "nvd5517";
var tweetThisText = "Система сетей Wohlhabenden.NET: http://wohlnet.ru";
tripleflapInit();
</script>


<h1>Сообщение отправлено!</h1>
<center>Ваше сообщение администратору отправлено,<br>Благодармим за обращение!</center>


<? require $sys_inc."html-footer.php"; ?>
