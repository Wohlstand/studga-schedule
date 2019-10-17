<?php

require_once(dirname(__FILE__)."/../sys/ismobile.php");
if((is_mobile())&&(!isset($_COOKIE['full']))&&(!isset($_GET['full']))&&(!isset($_GET['lite'])))
{
	setcookie("mobile", "1", time()+(31536000*5), "/");
	setcookie("full", "0", time()-(31536000*5), "/");
	header("Location: /m");
	exit;
}
else
{
	if(isset($_GET['lite']))
	{
		setcookie("mobile", "1", time()+(31536000*5), "/");
		setcookie("full", "0", time()-(31536000*5), "/");
		header("Location: /m");
		exit;
	}
	setcookie("mobile", "0", time()-(31536000*5), "/");
	setcookie("full", "1", time()+(31536000*5), "/");
}

$IncludeToHead = '
<META NAME="DESCRIPTION" CONTENT="Студенческое объединение Московского Государственного Технического Университета Гражданской Авиации">
<META NAME="keywords" CONTENT="Студенческий портал, МГТУ ГА, объединение студентов">
';

$page_title = "Студенческий портал МГТУ ГА";
$menu = "mainpage";
require_once("../sys/html-header.php");
require_once("../sys/html-titlebar.php");
require_once("_menu.php");
?>
&nbsp;<table style="width: 70%; border-collapse: collapse; height: 60%;" align="center">
	<tr>
		<td style="padding: 10px;text-align: center; width: 100%;">
<img alt="MSTUCA LOGO" src="/images/mstuca_logo_big.png" width="452" height="428"><font size=12><br>
</font>
<span style="font-size: xx-large; color: #002257">Портал в разработке</span>

<br>Вы можете воспользоваться разделом<br>
<a href="http://sd.studga.ru/">расписаний МГТУ ГА</a></td>
</table>
<?php
require_once("../sys/html-footer.php");
?>
