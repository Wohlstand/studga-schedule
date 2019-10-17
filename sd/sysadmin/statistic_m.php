<?php
require "../../sys/db.php";
//require "admin_ip.php";

if(!empty($_GET['sortby']))
$sortby = $_GET['sortby'];
else
$sortby = "book_title";
$menu = "stat";
$page_title = "Статистика посещаемости - Расписания МГТУ ГА";
$sys_inc = "../../sys/";

require $sys_inc."mobile-html-header.php";
require $sys_inc."mobile-html-titlebar.php";
require "_menu_admin.php";

$stat_max = mysqlold_result(mysqlold_query("SELECT COUNT(distinct IP) AS clients, DATE(`time`) AS `date` FROM statistic
GROUP BY `date` ORDER BY `clients` DESC LIMIT 1;") ,0);

$stat_max2 = mysqlold_result(mysqlold_query("SELECT SUM(`counts`) AS clicks, DATE(`time`) AS `date` FROM statistic
GROUP BY `date` ORDER BY `clicks` DESC LIMIT 1;") ,0);

$statics_q = mysqlold_query("SELECT SUM(`counts`) AS clicks, COUNT(distinct IP) AS clients, DATE(`time`) AS `date`
FROM statistic
GROUP BY `date`
  ORDER BY `date` desc;");
?>



<table align="center" style="width: 100%; border-collapse: collapse; border: 1px solid #000000">
<caption>Статистика просмотров расписаний</caption>
	<tr>
		<th style="text-align: center; border: 1px solid #000000">
		Дата</th>
		<th style="text-align: center; border: 1px solid #000000">
		Уникальные посетители</th>
		<th style="text-align: center; border: 1px solid #000000">Запросы</th>
	</tr>
	<?while($st = mysqlold_fetch_array($statics_q)) {?>
	<tr>
		<td style="border: 1px solid #000000"><?=$st['date']?></td>
		<td style="border: 1px solid #000000"><?=$st['clients']?><?=($stat_max==$st['clients'])?"<font color=red><b>!</b></font>":""?></td>
		<td style="border: 1px solid #000000"><?=$st['clicks']?><?=($stat_max2==$st['clicks'])?"<font color=red><b>!</b></font>":""?></td>
	</tr>
	<?}?>
</table>


<? require $sys_inc."mobile-html-footer.php"; ?>
