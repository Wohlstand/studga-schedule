<?php
require "config.php";

require_once(dirname(__FILE__)."/../sys/ismobile.php");
if(
	(is_mobile()) &&
 	(!isset($_COOKIE['full'])) &&
	(!isset($_GET['full'])) &&
	(!isset($_GET['lite']))
	)
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
<META NAME="DESCRIPTION" CONTENT="Расписания занятий Московского Государственного Технического Университета Гражданской Авиации">
<META NAME="keywords" CONTENT="Расписание, МГТУ ГА, МГТУГА, студентов, преподавателей, расписания МГТУГА, расписания МГТУ ГА, расписание МГТУГА,  расписание МГТУ ГА">
';
$page_title = $SiteTitle;
$menu = "mainpage";
require_once("../sys/html-header.php");
require_once("../sys/html-titlebar.php");
require_once("_menu.php");
?>

<script type="text/javascript">
if(!navigator.cookieEnabled)
{
	alert('Для корректной работы сайта, необходимо включить Cookies!');
}
</script>
<h1>Расписания занятий МГТУ ГА [Aplha]*</h1>
<p style="text-align: center">* <span lang="ru">Платформа находится в стадии
разработки, большая часть задуманного функционала ещё не реализована.<br>В работе системы могут быть ошибки</span></p>
&nbsp;<table style="width: 70%; border-collapse: collapse; height: 40%;" align="center">
	<tr>
		<td style="padding: 20px 100px 30px 100px;text-align: center; width: 50%;">
		<h3><a href="/d/chgr">Студенту</a></h3>
		<a href="/d/chgr">
		<img style="border-width: 0;" alt="Студенту" src="/css/images/student.png" width="228" height="300">
		</a></td>
		<td style="padding: 20px 100px 30px 100px;text-align: center; width: 50%;">
		<h3><a href="/d/chlcr">Преподавателю</a></h3>
		<a href="/d/chlcr">
		<img style="border-width: 0;" alt="Преподавателю" src="/css/images/professor.png" width="248" height="300">
		</a></td>
	</tr>
	</table>

<?php
if(strstr($_SERVER['REMOTE_ADDR'], "172.16.16.152"))
{
?>
<h1>Университет</h1>
<p style="text-align: center">[Скоро будет]</p>&nbsp;
	<table style="width: 70%; border-collapse: collapse; height: 40%;" align="center">
	<tr>
		<td style="padding: 20px 100px 30px 100px;text-align: center; width: 50%;">
		<h3><a href="/d/chroom">Аудитории</a></h3>
		<a href="/d/chroom">
		<img style="border-width: 0;" alt="Аудитории" src="/css/images/door.png" width="228" height="300">
		</a></td>
		<td style="padding: 20px 100px 30px 100px;text-align: center; width: 50%;">
		<h3><a href="javascript://">Корпуса университета</a></h3>
		<a href="javascript://">
		<img style="border-width: 0;" alt="Университет" src="/css/images/univer_color_m.png" width="248" height="300">
		</a></td>
	</tr>
	</table>
<?php
}

require_once("../sys/html-footer.php");
