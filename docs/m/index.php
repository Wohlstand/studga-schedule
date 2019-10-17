<?
$page_title = "Студенческий портал МГТУ ГА";
$menu = "mainpage";

$Inc_sys = dirname(__FILE__)."/../../sys/";
require_once($Inc_sys."mobile-html-header.php");
require_once($Inc_sys."mobile-html-titlebar.php");
require_once("../_menu_m.php");
?>
<table style="width: 70%; margin: auto auto; border-collapse: collapse; height: 60%; text-align: center;">
	<tr>
		<td style="padding: 10px;text-align: center; width: 100%;">
<img alt="MSTUCA LOGO" src="/images/mstuca_logo_mobile.png" width="250" height="250"/><span style="font-size: 12px"><br />
</span>
<span style="font-size: xx-large; color: #002257">Портал в разработке</span>

<br />Вы можете воспользоваться <br />
<a href="http://sd.mstuca.su/">расписаниями МГТУ ГА</a>
</td>
</tr>
</table>
<?php
require_once($Inc_sys."mobile-html-footer.php");
?>
