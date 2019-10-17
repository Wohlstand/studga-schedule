<?
require "../../sys/db.php";
// require "admin_ip.php";

if(!empty($_GET['sortby']))
$sortby = $_GET['sortby'];
else
$sortby = "book_title";
$menu = "stat";
$page_title = "Статистика посещаемости - Расписания МГТУ ГА";
$sys_inc = "../../sys/";

$IncludeToHead =  '<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="/js/flot/excanvas.min.js"></script><![endif]-->
    <script language="javascript" type="text/javascript" src="/js/flot/jquery.js"></script>
    <script language="javascript" type="text/javascript" src="/js/flot/jquery.flot.js"></script>
    <script language="javascript" type="text/javascript" src="/js/flot/jquery.flot.navigate.js"></script>';

require $sys_inc."html-header.php";
require $sys_inc."html-titlebar.php";
require "_menu_admin.php";

$stat_max = mysqlold_result(mysqlold_query("SELECT COUNT(distinct IP) AS clients, DATE(`time`) AS `date` FROM statistic
GROUP BY `date` ORDER BY `clients` DESC LIMIT 1;") ,0);

$stat_max2 = mysqlold_result(mysqlold_query("SELECT SUM(`counts`) AS clicks, DATE(`time`) AS `date` FROM statistic
GROUP BY `date` ORDER BY `clicks` DESC LIMIT 1;") ,0);

$statics_q = mysqlold_query("SELECT SUM(`counts`) AS clicks, COUNT(distinct IP) AS clients, DATE(`time`) AS `date`
FROM statistic
GROUP BY `date`
  ORDER BY `date` desc;");

$statics_q2 = mysqlold_query("SELECT SUM(`counts`) AS clicks, COUNT(distinct IP) AS clients, DATE(`time`) AS `date`
FROM statistic
GROUP BY `date`
  ORDER BY `date` desc;");
?>
<div style="text-align: center;">Посетители</div>
<div id="placeholder" style="margin:auto;width:600px;height:300px;"></div>
<br/>
<div style="text-align: center;">Клики</div>
<div id="clicksstat" style="margin:auto;width:600px;height:300px;"></div>
<div style="text-align: center;">
<br/>
<b>Рекорд посещаемости:</b> человек: <?=$stat_max;?> и кликов <?=$stat_max2?>
</div>
<br/>
<table align="center" style="width: 600px; border-collapse: collapse; border: 1px solid #000000">
<caption>Статистика просмотров категорий за всё время</caption>
	<tr>
		<th style="text-align: center; width: 179px; border: 1px solid #000000">
		Категория</th>
		<th style="text-align: center; border: 1px solid #000000">Запросы</th>
	</tr>
	<tr>
		<td style="width: 179px; border: 1px solid #000000">
		PC_full</td>
		<td style="border: 1px solid #000000">
		&nbsp;</td>
	</tr>
	<tr>
		<td style="width: 179px; border: 1px solid #000000">
		PC_oneday</td>
		<td style="border: 1px solid #000000">
		&nbsp;</td>
	</tr>
	<tr>
		<td style="width: 179px; border: 1px solid #000000">
		Mobile_oneday</td>
		<td style="border: 1px solid #000000">
		&nbsp;</td>
	</tr>
	<tr>
		<td style="width: 179px; border: 1px solid #000000">
		PC_info</td>
		<td style="border: 1px solid #000000">
		&nbsp;</td>
	</tr>
	<tr>
		<td style="width: 179px; border: 1px solid #000000">
		Mobile_info</td>
		<td style="border: 1px solid #000000">
		&nbsp;</td>
	</tr>
	<tr>
		<td style="width: 179px; border: 1px solid #000000">
		Mobile_lnInfo</td>
		<td style="border: 1px solid #000000">
		</td>
	</tr>
	<tr>
		<td style="width: 179px; border: 1px solid #000000">
		PC_lnInfo</td>
		<td style="border: 1px solid #000000">
		&nbsp;</td>
	</tr>
	<tr>
		<td style="width: 179px; border: 1px solid #000000">
		PC_fastlinks</td>
		<td style="border: 1px solid #000000">
		&nbsp;</td>
	</tr>
</table>
<br/>
<script type="text/javascript">
var all_data = [];
var clicks = [];
</script>

<table align="center" style="width: 600px; border-collapse: collapse; border: 1px solid #000000">
<caption>Статистика просмотров расписаний</caption>
	<tr>
		<th style="text-align: center; width: 179px; border: 1px solid #000000">
		Дата</th>
		<th style="text-align: center; width: 210px; border: 1px solid #000000">
		Уникальные посетители</th>
		<th style="text-align: center; border: 1px solid #000000">Запросы</th>
	</tr>
	<?while($st = mysqlold_fetch_array($statics_q)) {?>
	<tr>
		<td style="width: 179px; border: 1px solid #000000"><?=$st['date']?></td>
		<td style="width: 210px; border: 1px solid #000000"><?=$st['clients']?><?=($stat_max==$st['clients'])?"<font color=red><b>!</b></font>":""?></td>
		<td style="border: 1px solid #000000"><?=$st['clicks']?><?=($stat_max2==$st['clicks'])?"<font color=red><b>!</b></font>":""?></td>
	</tr>
<?if($st['date']!=date('Y-m-d')) {?>
<script type="text/javascript">
all_data.push([<?=strtotime($st['date'])."000"?>,<?=$st['clients']?>]);
clicks.push([<?=strtotime($st['date'])."000"?>,<?=$st['clicks']?>]);
</script>
<?}?>

	<?}?>
</table>

<script type="text/javascript">
$(function () {
	/*
	var all_data = [[1120168800000, 0], [1130799600000, 1],
	           [1149112800000, 7], [1151704800000, 8] ];

	for(var j = 0; j < all_data.length; ++j) {
	    all_data[j][0] = Date.parse(all_data[j][0]);
	}
	*/

	//alert(all_data);
	    // a null signifies separate line segments

	$.plot($("#placeholder"), [ {
            data: all_data,
	    color: 2,
            lines: {
                show: true
            },
            label: "Посетители"
	    } ], {
	   points: { show: true },
           xaxis: { mode: "time",timeformat: "%d-%m-%y",panRange: [null, null], TickSize: [7, "day"],
	        min: (new Date(<?=date("Y, m, d", intval(strtotime(date("Y-m-d"))-2*2592000))?>)).getTime(),
                max: (new Date(<?=date("Y, m, d", strtotime(date("Y-m-d")))?>)).getTime()
		},
	   yaxis: { panRange: false, zoomRange: false},
	   pan: { interactive: true },
	   zoom: { interactive: true },
	});

	$.plot($("#clicksstat"), [ {
            data: clicks,
	    color: 1,
            lines: {
                show: true,
            },
            label: "Клики"
	    } ], {
	   points: { show: true },
           xaxis: { mode: "time",timeformat: "%d-%m-%y",panRange: [null, null], TickSize: [7, "day"],
	        min: (new Date(<?=date("Y, m, d", intval(strtotime(date("Y-m-d"))-2*2592000))?>)).getTime(),
                max: (new Date(<?=date("Y, m, d", strtotime(date("Y-m-d")))?>)).getTime()
		},
	   yaxis: { panRange: false, zoomRange: false},
	   pan: { interactive: true },
	   zoom: { interactive: true },
	});

});

</script>

<? require $sys_inc."html-footer.php"; ?>
