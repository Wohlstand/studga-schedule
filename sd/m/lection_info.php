<?php
if($_SERVER['HTTP_USER_AGENT']=="Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)")
{
    header("HTTP/1.1 404 Not Found");
    echo "Ничего тут нет";
    exit;
}
if(isset($_GET['lsubgrp']))
    $get_lsubgroups = intval($_GET['lsubgrp']);
else
    $get_lsubgroups = 4;

if(isset($_GET['esubgrp']))
    $get_esubgroups = intval($_GET['esubgrp']);
else
    $get_esubgroups = 2;

if(isset($_GET['grp']))
    $get_groups = intval($_GET['grp']);
else
    $get_groups = 2;

if(isset($_GET['flow']))
    $get_flows = intval($_GET['flow']);
else
    $get_flows = 1;

if(isset($_GET['lection_id']))
    $get_id = intval($_GET['lection_id']);
else
    $get_id = 0;


if(isset($_GET['lection']))
    $get_lection = intval($_GET['lection']);
else
    $get_lection = 1;

if(isset($_GET['date']))
    $get_date = $_GET['date'];
else
    $get_date = date("Y-m-d");


if(isset($_GET['day']))
    $get_day = intval($_GET['day']);
else
    $get_day = "";

if(isset($_GET['lector']))
    $get_lector = intval($_GET['lector']);
else
    $get_lector = "";

$Inc_sys = "../../sys/";

require_once($Inc_sys."db.php");
require_once($Inc_sys."common.php");
require_once($Inc_sys."sd_stat.php");

$get_date = mysqlold_real_escape_string($get_date);

if(!$get_lector)
{
    $flows_q = mysqlold_query("SELECT gr_name,`gr_year-start` FROM schedule_flows WHERE id_flow='".$get_flows."' LIMIT 1;");
    $flows_a = mysqlold_fetch_assoc($flows_q);
    $esbg_q = mysqlold_query("SELECT * FROM schedule_subgroups WHERE id_subgroup='".$get_esubgroups."' LIMIT 1;");
    $esbg_a = mysqlold_fetch_assoc($esbg_q);
    $lsbg_q = mysqlold_query("SELECT * FROM schedule_subgroups WHERE id_subgroup='".$get_lsubgroups."' LIMIT 1;");
    $lsbg_a = mysqlold_fetch_assoc($lsbg_q);
}

//Семестры///////////////////////////////////////////////////////////////////////////////////////////////
if($get_day=="")
{
	$query = mysqlold_query("SELECT * FROM schedule_daycount ORDER BY dayend DESC LIMIT 1");
	$old_schedule = 0;
}
else
{
	$query = mysqlold_query("SELECT * FROM schedule_daycount WHERE id_day=".intval($get_day)." ORDER BY dayend DESC LIMIT 1");
	$old_schedule = 1;
}

$daycounts = mysqlold_fetch_assoc($query);
if($daycounts == NULL)
    die("<h2 style=\"text-align: center;\">СЕМЕСТР НЕ НАЙДЕН!</h2>");

$old_schedule_2 = 0;

//Расписание по семестру
if($old_schedule==0)
{
    if(!$get_lector)
    {
	    if( intval(mysqlold_result(mysqlold_query("SELECT count(*) FROM schedule__maindata WHERE id_day=".$daycounts['id_day']." AND id_flow = ".intval($get_flows).";"), 0)) != 0)
	    {
		    $old_schedule = 0;
		    $old_schedule_2 = 0;
	    }
	    else
	    {
		    $query_2 = mysqlold_query("SELECT * FROM schedule_daycount WHERE id_day=".($daycounts['id_day']-1)." ORDER BY dayend DESC LIMIT 1");
		    $old_schedule = 1;
		    $old_schedule_2 = 1;
	    }
    }
    else
    {
	    if( intval(mysqlold_result(mysqlold_query("SELECT count(*) FROM schedule__maindata WHERE id_day=".$daycounts['id_day']." AND id_lector = ".intval($get_lector).";"), 0)) != 0)
	    {
		    $old_schedule = 0;
		    $old_schedule_2 = 0;
	    }
	    else
	    {
		    $query_2 = mysqlold_query("SELECT * FROM schedule_daycount WHERE id_day=".($daycounts['id_day']-1)." ORDER BY dayend DESC LIMIT 1");
		    $old_schedule = 1;
		    $old_schedule_2 = 1;
	    }
    }
}
else
    $old_schedule_2 = 0;

if($old_schedule_2==1)
$daycounts = mysqlold_fetch_assoc($query_2);

if($daycounts == NULL)
    die("<h2 style=\"text-align: center;\">СЕМЕСТР НЕ НАЙДЕН!</h2>");

$id_day_1 = $daycounts['id_day'];

$days = explode("-", $daycounts['daystart']);
//Семестры//END/////////////////////////////////////////////////////////////////////////////////////////////



$couples = $couples = (int)((int)date("W", strtotime($get_date)) & 1 xor !$daycounts['couples']);

if(!$get_lector)

$DataQuery = "SELECT *
  FROM  schedule__maindata,
	schedule_disciplyne,
	schedule_lectors,
	schedule_rooms,
	schedule_houses,
	schedule_ltype

WHERE
		schedule__maindata.id_disciplyne=schedule_disciplyne.id_disciplyne
		AND schedule__maindata.id_lector=schedule_lectors.id_lector
		AND schedule__maindata.id_room=schedule_rooms.id_room
		AND schedule__maindata.id_ltype=schedule_ltype.id_ltype
		AND schedule_rooms.id_house=schedule_houses.id_house

AND
id_day=".$daycounts['id_day']."
AND id_flow='".$get_flows."'
AND lection=".$get_lection."
AND (((id_subgrp='".$get_lsubgroups."' OR id_subgrp='".$get_esubgroups."') AND issubgrp=1) OR issubgrp=0)
AND id_group LIKE '%".$get_groups."%'
AND `weekday`=DAYOFWEEK('".$get_date."')-1
AND (
(onlydays LIKE '%".$get_date."%')
OR
((STR_TO_DATE('".$get_date."', '%Y-%m-%d') BETWEEN `period-start` AND `period-end`)
  AND (exceptions IS NULL OR (exceptions NOT LIKE '%".$get_date."%')))
)
AND ((couples=0) OR ((couples=1 AND ".(int)$couples.") OR (couples=2 AND ".(int)(!$couples).")))".(($get_id)?" AND id=".intval($get_id):"")."
ORDER BY lection LIMIT 1;
";

else

$DataQuery = "SELECT *
  FROM  schedule__maindata,
	schedule_disciplyne,
	schedule_lectors,
	schedule_flows,
	schedule_facult,
	schedule_rooms,
	schedule_houses,
	schedule_ltype

WHERE
		schedule__maindata.id_disciplyne=schedule_disciplyne.id_disciplyne
		AND schedule__maindata.id_lector=schedule_lectors.id_lector
		AND schedule__maindata.id_flow=schedule_flows.id_flow
		AND schedule_flows.id_facult=schedule_facult.id_facult
		AND schedule__maindata.id_room=schedule_rooms.id_room
		AND schedule__maindata.id_ltype=schedule_ltype.id_ltype
		AND schedule_rooms.id_house=schedule_houses.id_house

AND
id_day=".$daycounts['id_day']."
AND schedule__maindata.id_lector=".intval($get_lector)."
AND lection=".intval($get_lection)."
AND `weekday`=DAYOFWEEK('".$get_date."')-1
AND (
(onlydays LIKE '%".$get_date."%')
OR
((STR_TO_DATE('".$get_date."', '%Y-%m-%d') BETWEEN `period-start` AND `period-end`)
  AND (exceptions IS NULL OR (exceptions NOT LIKE '%".$get_date."%')))
)
AND ((couples=0) OR ((couples=1 AND ".(int)$couples.") OR (couples=2 AND ".(int)(!$couples).")))".(($get_id)?" AND id=".intval($get_id):"")."
ORDER BY lection LIMIT 1;
";


$GetDataQ = mysqlold_query($DataQuery);
if(!$GetDataQ)
    die(mysqlold_error()."<br><br>\n\n".$DataQuery);

$DataOfDay = mysqlold_fetch_assoc($GetDataQ);
echo '<?xml version="1.0" encoding="UTF-8"?>
';
?><!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.2//EN" "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="ru" http-equiv="Content-Language" />
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<link rel="stylesheet" href="/css/style_mobile.css" type="text/css" />
<title>Информация о занятии</title>
</head>
<body class="oneday_card">
<div style="text-align:center;">
<a href="javascript:hostory.back()" onclick="history.back()">
<img style="" alt="info" src="/sysimage/icons/back.gif"/>Назад</a>
</div>

<h1 style="text-align: center">Информация о занятии</h1>
<table style="width: 100%">
<?php
if($DataOfDay['change']!=0)
{?>
	<tr>
		<td style="width: 307px"><span style="color: #BE1B1B"><strong>В занятие внесена поправка</strong></span>:<br/>
		<?php if($DataOfDay['change_user']==NULL) { ?>
		Поправку внёс администратор сервера
		<?php } else { echo'
		Поправку внёс '.$DataOfDay['change_user'].'
		';}?>
		</td>
	</tr>
<?php if($DataOfDay['change_reason']) { ?>
	<tr>
		<td style="width: 307px"><strong>Причина поправки</strong>:<br/>
		<?php echo $DataOfDay['change_reason'];?></td>
	</tr>
	<tr>
		<td style="width: 307px">&nbsp;</td>
	</tr>
<?php } ?>
<?php } ?>
	<tr>
		<td style="width: 307px"><strong>Номер пары</strong><strong>:</strong>
		<br/><?php echo $DataOfDay['lection'];?>
		</td></tr>
	<tr>
		<td style="width: 307px"><strong>Название предмета</strong>
		<br/><span style="font-size: 20px"><?php echo $DataOfDay['dysc_name'];?></span><br/></td>
	</tr>
	<tr>
		<td style="width: 307px"><strong>Тип занятия</strong>
		<br/><span style="font-size: 18px"><?php echo $DataOfDay['lt_name'];?></span>
		</td>
	</tr>
	<?php if(intval($DataOfDay['diration'])>1){?>
	<tr>
		<td style="width: 307px"><strong>Длительность пар на одно занятие</strong><br/>
		<<?php echo $DataOfDay['diration'];?></td>
	</tr>
<?php }?>
	<tr>
		<td style="width: 307px">&nbsp;
		<br/>&nbsp;</td>
	</tr>

<?php if(!$get_lector){?>
	<tr>
		<td style="text-align: center; font-size: large;"><strong>
		Преподаватель</strong></td>
	</tr>
	<tr>
		<td style="width: 307px"><strong>ФИО преподавателя</strong>
		<br/><span style="font-size: 20px"><?php echo $DataOfDay['lcr_fullname'];?></span></td>
	</tr>
	<tr>
		<td style="width: 307px"><strong>Должность преподавателя</strong>
		<br/><?php echo $DataOfDay['lcr_rank-l'];?></td>
	</tr>
<?php
if(($DataOfDay['lcr_rank-l']!="Преподаватель")&&($DataOfDay['lcr_rank-l']!="Старший преподаватель"))
{
?>
	<tr>
		<td style="width: 307px"><strong>Учёная степень преподавателя</strong>
		<br/><?php echo $DataOfDay['lcr_rank-sc'];?></td>
	</tr>
<?php }?>
<?php
if(($DataOfDay['lcr_offsite']!="")&&($DataOfDay['lcr_offsite']!=NULL))
{
?>
	<tr>
		<td style="width: 307px"><span style="color: #009910;"><strong>Личная страничка преподавателя</strong></span>
		<br/><a href="<?=$DataOfDay['lcr_offsite']?>"><?=$DataOfDay['lcr_offsite']?></a></td>
	</tr>
<?php } ?>
	<tr>
		<td style="width: 307px">&nbsp;
		<br/>&nbsp;</td>
	</tr>
<?php }else { ?>

	<tr>
		<td style="text-align: center; font-size: large;"><strong>
		Группа</strong></td>
	</tr>
	<tr>
		<td style="width: 307px"><strong>Факультет</strong>
		<br/><?php echo $DataOfDay['fac_name'];?></td>
	</tr>
	<tr>
		<td style="width: 307px"><strong>Номер группы:</strong>
		<br/><?php echo $DataOfDay['gr_name']."-".GrCourse($DataOfDay['gr_year-start'], $days[0], $days[1])."-".str_replace(" ", "/",$DataOfDay['id_group']);?>
		</td>
	</tr>
	<tr>
		<td style="width: 307px"><strong>Год зачисления</strong>
		<br/><?php echo $DataOfDay['gr_year-start'];?></td>
	</tr>
	<tr>
		<td style="width: 307px"><strong>Год выпуска</strong>
		<br/><?php echo $DataOfDay['gr_year-end'];?></td>
	</tr>
	<tr>
		<td style="width: 307px">&nbsp;
		<br/>&nbsp;</td>
	</tr>
<?php } ?>

	<tr>
		<td style="text-align: center; font-size: large;" colspan="2"><strong>
		Аудитория</strong></td>
	</tr>
	<tr>
		<td style="width: 307px"><strong>Кабинет</strong><br/>
		<span style="font-size: 24px"><?php echo $DataOfDay['room_number'];?></span></td>
	</tr>
	<tr>
		<td style="width: 307px"><strong>Розетки 220</strong><strong>V</strong>
		<br/><?php echo $DataOfDay['room_220v']; if(!$DataOfDay['room_220v']) echo "&lt;данные отсутствуют&gt;";?></td>
	</tr>
	<tr>
		<td style="width: 307px"><strong>Описание комнаты</strong>
		<br/><?php echo $DataOfDay['room_desc']; if(!$DataOfDay['room_desc']) echo "&lt;описание отсутствует&gt;";?></td>
	</tr>
	<tr>
		<td style="width: 307px">&nbsp;
		<br/>&nbsp;</td>
	</tr>
	<tr>
		<td style="text-align: center; font-size: large;" colspan="2"><strong>
		Корпус</strong></td>
	</tr>
	<tr>
		<td style="width: 307px"><strong>Корпус</strong>
		<br/><?php echo $DataOfDay['house_name'];?></td>
	</tr>
	<tr>
		<td style="width: 307px"><?php if($DataOfDay['room_stage']) echo RuCounter_m($DataOfDay['room_stage'])." этаж";?></td>
	</tr>
	<tr>
		<td style="width: 307px">&nbsp;
		<br/>&nbsp;</td>
	</tr>
	<tr>
		<td style="text-align: center; font-size: large;" colspan="2"><strong>
		Даты</strong></td>
	</tr>
<?php
if($DataOfDay['period-start']!="")
{ ?>

	<tr>
		<td style="width: 307px"><strong>День Недели</strong>
		<br/><?php echo weekdaynFull(date("w", strtotime($get_date)));?></td>
	</tr>

	<tr>
		<td style="width: 307px"><span style="font-size: medium">
		<strong>Период</strong></span>
		<br/>c <?=TextDate_s($DataOfDay['period-start'])?> по <?=TextDate_s($DataOfDay['period-end'])?><?php if($DataOfDay['exceptions']!="") { ?>,<br>
кроме <?php echo TextDateList_s($DataOfDay['exceptions']);}?></td>
	</tr>
<?php } if($DataOfDay['onlydays']!="") { ?>
	<tr>
		<td style="width: 307px"><strong>Дни занятия</strong>
		<br/>Только <?php echo TextDateList_s($DataOfDay['onlydays']);?></td>
	</tr>
<?php } ?>
</table>

<div style="text-align:center;">
<a href="javascript:hostory.back()" onclick="history.back()">
<img style="" alt="info" src="/sysimage/icons/back.gif"/>Назад</a>
</div>

<?php
SetStatistics("ID-".$DataOfDay['id']." ".$get_date." L-".$get_lection, "Mobile_lnInfo");
?>
</body>
</html>
