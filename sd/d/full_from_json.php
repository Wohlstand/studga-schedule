<?php

require "../config.php";
$Inc_sys = "../../sys/";

$IsRoom = 0;
$IsLector = 0;
$get_lector = "";
$get_room = "";

if(isset($_GET['lector']))
{
	$get_lector = $_GET['lector'];
	$IsLector = 1;
	if($get_lector=="") die("Lector doesn't selected!");
	if(!is_numeric($get_lector)) die ("Error Lector value!");
}
else
if(isset($_GET['room']))
{
	$get_room = $_GET['room'];
	$IsRoom = 1;
	if($get_room=="") die("Room doesn't selected!");
	if(!is_numeric($get_room)) die ("Error Room value!");
}
else
{
	if(
		!empty($_COOKIE['type']) &&
			(
	 			(!isset($_GET['grp'])) ||
				(!isset($_GET['flow']))
			)
	    )
	{
		switch($_COOKIE['type'])
		{
		case "room":
			$IsRoom = 1; break;
		case "lector":
			$IsLector = 1; break;
		case "student":
			$IsLector = 0;
			$IsRoom = 0; break;
		}
	}
}

if((!$IsLector)&&(!$IsRoom))
{
	//////////////////////////////////////////////////////////////////////////////////////
	if(
		(
			(isset($_GET['grp'])) && (isset($_GET['flow']))
		)
		||
		(
			(empty($_COOKIE["flow"])) || (empty($_COOKIE["grp"]))
		)
	)
	{

		if(isset($_GET['fac']))
		{
			$get_fac = $_GET['fac'];
			if(!is_numeric($get_fac)) die("ERROR in fac Value!!!");
			//setcookie("fac", $get_fac, time()+(31536000*5), "/");
		}
		else
		{
			header("Location: /d/chgr");
			exit;
		}

		if(isset($_GET['grp']))
		{
			$get_groups = $_GET['grp'];
			if(!is_numeric($get_groups))
				die("ERROR in GRP Value!!!");
			//setcookie("grp", $get_groups, time()+(31536000*5), "/");
		}
		else {header("Location: /d/chgr");exit;}

		if(isset($_GET['flow']))
		{
			$get_flows = $_GET['flow'];
			if(!is_numeric($get_flows))
			 	die("ERROR in flow Value!!!");
			//setcookie("flow", $get_flows, time()+(31536000*5), "/");
		}
		else {header("Location: /d/chgr");exit;}

		if(isset($_GET['lsubgrp']))
		{
			$get_lsubgroups = $_GET['lsubgrp'];
			if(!is_numeric($get_lsubgroups))
				die("ERROR in lSubGrp Value!!!");
			//setcookie("lsubgrp", $get_lsubgroups, time()+(31536000*5), "/");
		}
		else
		{
			$get_lsubgroups = "0";
			//setcookie("lsubgrp", $get_esubgroups, time()+(31536000*5), "/");
		}

		if(isset($_GET['esubgrp']))
		{
			$get_esubgroups = $_GET['esubgrp'];
			if(!is_numeric($get_esubgroups))
				die("ERROR in eSubGrp Value!!!");
			//setcookie("esubgrp", $get_esubgroups, time()+(31536000*5), "/");
		}
		else
		{
			$get_esubgroups = "0";
			//setcookie("esubgrp", $get_esubgroups, time()+(31536000*5), "/");
		}

	//setcookie("type", "student", time()+(31536000*5), "/");
	}
	//////////////////////////////////////////////////////////////////////////////////////
	else
	{
		$get_lsubgroups = intval($_COOKIE["lsubgrp"]);
		$get_esubgroups = intval($_COOKIE["esubgrp"]);
		$get_groups = intval($_COOKIE["grp"]);
		$get_flows = intval($_COOKIE["flow"]);
		$get_fac = intval($_COOKIE["fac"]);
	}
	//////////////////////////////////////////////////////////////////////////////////////
}
else
{
	$get_lsubgroups = 3;
	$get_esubgroups = 0;
	$get_groups = "";
	$get_flows = "";
	$get_fac = 0;

	if($IsLector)
	{
		$IsLector = 1;
		if( (isset($_GET['lector'])) || (empty($_COOKIE["lector"])) )
		{
			//setcookie("lector", $get_lector, time()+(31536000*5), "/");
			//setcookie("type", "lector", time()+(31536000*5), "/");
			if(
				(empty($_COOKIE["flow"])) || (empty($_COOKIE["grp"])) || (empty($_COOKIE["lsubgrp"]))
			)
			{
				//setcookie("fac", $get_fac, time()+(31536000*5), "/");
				//setcookie("grp", $get_groups, time()+(31536000*5), "/");
				//setcookie("flow", $get_flows, time()+(31536000*5), "/");
				//setcookie("esubgrp", $get_esubgroups, time()+(31536000*5), "/");
				//setcookie("lsubgrp", $get_esubgroups, time()+(31536000*5), "/");
			}
		}
		else
		{
			$get_lector = intval($_COOKIE["lector"]);
		}
	}
	else if($IsRoom)
	{
		$IsRoom = 1;
		if( (isset($_GET['room'])) || (empty($_COOKIE["room"])) ) {}
		else
		{
			$get_room = intval($_COOKIE["room"]);
		}

	}



}

///////////////////////////////////////////////////////////////


if(isset($_GET['day']))
	$get_day = intval($_GET['day']);
else
	$get_day = "";

require_once($Inc_sys."db.php");
require_once($Inc_sys."common.php");
require_once($Inc_sys."sd_stat.php");


///////////////////////////////////////////////СБОР ДАННЫХ И ПРОВЕРКА НА ВШИВОСТЬ//////////////////////////////////////////////////////////

if($get_lector)
{
	$lector_q = mysqlold_query("SELECT * FROM schedule_lectors WHERE id_lector='".$get_lector."' LIMIT 1;");
	$lector_a = mysqlold_fetch_assoc($lector_q);
}
else if($IsRoom)
{
	$room_q = mysqlold_query("SELECT * FROM schedule_rooms WHERE id_room='".$get_room."' LIMIT 1;");
	$room_a = mysqlold_fetch_assoc($room_q);
}
else
{
	$flows_q = mysqlold_query("SELECT gr_name,`gr_year-start`,`is_updating`,`latest_upd` FROM schedule_flows WHERE id_flow='".$get_flows."' LIMIT 1;");
	$flows_a = mysqlold_fetch_assoc($flows_q);

	if($flows_a['is_updating']==1)
	{
		FatalErrorMessage("Извините, расписание в процессе обновления",
		"Пожалуйста, обновите страницу чуть позже<br>Если это сообщение долго не исчезает, ".
		"значит в процессе обновления произошёл сбой");
	}
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

if($daycounts==NULL)
	FatalErrorMessage("Ошибка! - Семестр не найден", "Возможно, Вы указали несуществующий код семестра");

$id_day_1 = $daycounts['id_day'];

if($old_schedule==0)
{
	if((!$get_lector) && (!$get_room))
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
	if($IsLector)
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
	else
		{
			if( intval(mysqlold_result(mysqlold_query("SELECT count(*) FROM schedule__maindata WHERE id_day=".$daycounts['id_day']." AND id_room = ".intval($get_room).";"), 0)) != 0)
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

}
else
	$old_schedule_2 = 0;

if($old_schedule_2==1)
	$daycounts = mysqlold_fetch_assoc($query_2);


if($daycounts==NULL)
		FatalErrorMessage("Ошибка! - Семестр не найден", "Возможно, Вы указали несуществующий код семестра");

$id_day_1 = $daycounts['id_day'];

//Семестры//END/////////////////////////////////////////////////////////////////////////////////////////////

if($get_lector)
{
	if($lector_a==NULL)
		FatalErrorMessage("Ошибка! - Преподаватель не найден", "Преподаватель отсутсвует в базе данных");
	//die("<h2 style=\"text-align: center;\">ПРЕПОДАВАТЕЛЬ НЕ НАЙДЕН!</h2>");
}
else
if($get_room)
{
	if($room_a==NULL)
		FatalErrorMessage("Ошибка! - Комната не найден", "Комната отсутсвует в базе данных");
	//die("<h2 style=\"text-align: center;\">ПРЕПОДАВАТЕЛЬ НЕ НАЙДЕН!</h2>");
}
else
{
	if($flows_a==NULL)
		FatalErrorMessage("Ошибка! - Поток не найден", "Поток отсутсвует в базе данных<br>Откройте страницу выбора групп и повторно выберите свою группу");
	//die("<h2 style=\"text-align: center;\">ПОТОК НЕ НАЙДЕН!</h2>");
}

$days = explode("-", $daycounts['daystart']);

if($get_lector)
{
	if( intval(mysqlold_result(mysqlold_query("SELECT count(*) FROM schedule__maindata WHERE id_day=".$daycounts['id_day']." AND id_lector = ".intval($get_lector).";"), 0)) === 0)
		FatalErrorMessage("Ошибка! - Нет расписаний", "Отсутствуют расписания для преподавателя ".$lector_a['lcr_shtname']);
}
else
if($get_room)
{
	if( intval(mysqlold_result(mysqlold_query("SELECT count(*) FROM schedule__maindata WHERE id_day=".$daycounts['id_day']." AND id_room = ".intval($get_room).";"), 0)) === 0)
		FatalErrorMessage("Ошибка! - Нет расписаний", "Отсутствуют расписания для аудитории ".$room_a['room_number']);
}
else
{
	if( intval(mysqlold_result(mysqlold_query("SELECT count(*) FROM schedule__maindata WHERE id_day=".$daycounts['id_day']." AND id_flow = ".intval($get_flows).";"), 0)) === 0)
		FatalErrorMessage("Ошибка! - Нет расписаний", "У выбранного потока нет расписаний");

	if( intval(mysqlold_result(mysqlold_query("SELECT count(*) FROM schedule__maindata WHERE id_day=".$daycounts['id_day']." AND id_flow = ".intval($get_flows)." AND id_group LIKE '%".intval($get_groups)."%';"), 0)) === 0)
		FatalErrorMessage("Ошибка! - Нет расписаний", "У выбранной группы нет расписаний");
}




//НЕ выводить столбец с шестой парой, если у потока нет занятий на седьмой паре
if($IsLector) //Преподаватель
{
	if( intval(mysqlold_result(mysqlold_query("SELECT count(*) FROM schedule__maindata WHERE id_day=".$daycounts['id_day']." AND id_lector = ".intval($get_lector)." AND lection>5;"), 0)) === 0)
	{
		$SixthLection = 0;
		$SeventhLection = 0;
	}
	else
	{
		$SixthLection = 1;
		//НЕ выводить столбец с седьмой парой, если у потока нет занятий на седьмой паре
		if( intval(mysqlold_result(mysqlold_query("SELECT count(*) FROM schedule__maindata WHERE id_day=".$daycounts['id_day']." AND id_lector = ".intval($get_lector)." AND lection>6;"), 0)) === 0)
			$SeventhLection = 0;
		else
			$SeventhLection = 1;
	}
}
else
if($IsRoom) //Комната
{
	if( intval(mysqlold_result(mysqlold_query("SELECT count(*) FROM schedule__maindata WHERE id_day=".$daycounts['id_day']." AND id_room = ".intval($get_room)." AND lection>5;"), 0)) === 0)
	{
		$SixthLection = 0;
		$SeventhLection = 0;
	}
	else
	{
		$SixthLection = 1;

		//НЕ выводить столбец с седьмой парой, если у потока нет занятий на седьмой паре
		if( intval(mysqlold_result(mysqlold_query("SELECT count(*) FROM schedule__maindata WHERE id_day=".$daycounts['id_day']." AND id_room = ".intval($get_room)." AND lection>6;"), 0)) === 0)
			$SeventhLection = 0;
		else
			$SeventhLection = 1;
	}
}
else //Поток
{
	if( intval(mysqlold_result(mysqlold_query("SELECT count(*) FROM schedule__maindata WHERE id_day=".$daycounts['id_day']." AND id_flow = ".intval($get_flows)." AND lection>5;"), 0)) === 0)
	{
		$SixthLection = 0;
		$SeventhLection = 0;
	}
	else
	{
		$SixthLection = 1;

		//НЕ выводить столбец с седьмой парой, если у потока нет занятий на седьмой паре
		if( intval(mysqlold_result(mysqlold_query("SELECT count(*) FROM schedule__maindata WHERE id_day=".$daycounts['id_day']." AND id_flow = ".intval($get_flows)." AND lection>6;"), 0)) === 0)
			$SeventhLection = 0;
		else
			$SeventhLection = 1;
	}
}

/////////////////////////////////////END///////СБОР ДАННЫХ И ПРОВЕРКА НА ВШИВОСТЬ/END//////////////////////////////////////////////////////


///////////////////////////////////////ЗАПИСЬ КУК///////////////////////////////////////////////
if($IsLector)
{
	if((isset($_GET['lector']))||(empty($_COOKIE["lector"])))
	{
		setcookie("lector", $get_lector, time()+(31536000*5), "/");
		setcookie("type", "lector", time()+(31536000*5), "/");

		if((empty($_COOKIE["flow"]))||(empty($_COOKIE["grp"]))||(empty($_COOKIE["lsubgrp"])))
		{
			setcookie("fac", $get_fac, time()+(31536000*5), "/");
			setcookie("grp", $get_groups, time()+(31536000*5), "/");
			setcookie("flow", $get_flows, time()+(31536000*5), "/");
			setcookie("esubgrp", $get_esubgroups, time()+(31536000*5), "/");
			setcookie("lsubgrp", $get_esubgroups, time()+(31536000*5), "/");
		}
	}
}
else if($IsRoom)
{
	if((isset($_GET['room']))||(empty($_COOKIE["room"])))
	{
		setcookie("room", $get_room, time()+(31536000*5), "/");
		setcookie("type", "room", time()+(31536000*5), "/");

		if((empty($_COOKIE["flow"]))||(empty($_COOKIE["grp"]))||(empty($_COOKIE["lsubgrp"])))
		{
			setcookie("fac", $get_fac, time()+(31536000*5), "/");
			setcookie("grp", $get_groups, time()+(31536000*5), "/");
			setcookie("flow", $get_flows, time()+(31536000*5), "/");
			setcookie("esubgrp", $get_esubgroups, time()+(31536000*5), "/");
			setcookie("lsubgrp", $get_esubgroups, time()+(31536000*5), "/");
		}
	}
}
else
{
	if(((isset($_GET['grp']))&&(isset($_GET['flow'])))	||	((empty($_COOKIE["flow"]))||(empty($_COOKIE["grp"]))))
	{
		setcookie("fac", $get_fac, time()+(31536000*5), "/");
		setcookie("grp", $get_groups, time()+(31536000*5), "/");
		setcookie("flow", $get_flows, time()+(31536000*5), "/");
		setcookie("lsubgrp", $get_lsubgroups, time()+(31536000*5), "/");
		setcookie("esubgrp", $get_esubgroups, time()+(31536000*5), "/");
		setcookie("type", "student", time()+(31536000*5), "/");
	}
}
///////////////////////////////END/////ЗАПИСЬ КУК///END/////////////////////////////////////////

function TableHeader()
{
	global $SeventhLection;
	global $SixthLection;
	echo '
	<table class="shadow" style="width: 100%; border-collapse: collapse; border: 1px solid #000000">
	<thead class="tr_header">
	<tr>
		<th style="width: 83px; border: 1px solid #000000; white-space: nowrap;">Дата</th>
		<th style="width: 27px; border: 1px solid #000000; white-space: nowrap;"><span title="День недели">ДН</span></th>
		<th style="width: 12px; border: 1px solid #000000; white-space: nowrap;"><span title="Чётность недели">Ч</span></th>
		<th style="border: 1px solid #000000; white-space: nowrap;">1) 8:30 - 10:00</th>
		<th style="border: 1px solid #000000; white-space: nowrap;">2) 10:10 - 11:40</th>
		<th style="border: 1px solid #000000; white-space: nowrap;">3) 12:20 - 13:50</th>
		<th style="border: 1px solid #000000; white-space: nowrap;">4) 14:00 - 15:30</th>
		<th style="border: 1px solid #000000; white-space: nowrap;">5) 15:55 - 17:25</th>';
	if($SixthLection==1) echo '
		<th style="border: 1px solid #000000; white-space: nowrap;">6) 17:35 - 19:05</th>';
	if($SeventhLection==1) echo '
		<th style="border: 1px solid #000000; white-space: nowrap;">7) 19:15 - 20:45</th>';
	echo '	</tr>
	</thead>
	<tbody>'."\n";
}

function TableFooter()
{
	echo '</tbody></table></div>'."\n";
}

function TableFooter2()
{
	echo '</tbody></table>'."\n";
}

function PrDivHEAD()
{
	echo "\n".'<div id="MessForPrint">'."\n";
}

function PrDivFOOT()
{
	echo '</div>'."\n";
}

if($IsLector)
	$page_title = "Расписание занятий преподавателя ".$lector_a['lcr_fullname']." - ".$SiteTitle;
else if($IsRoom)
	$page_title = "Расписание занятий в аудитории ".$room_a['room_number']." - ".$SiteTitle;
else
	$page_title = "Расписание занятий ".$flows_a['gr_name']."-".GrCourse($flows_a['gr_year-start'], $days[0], $days[1])."-".$get_groups.
	(($get_lsubgroups>2)?", подгруппа ".($get_lsubgroups-2):"").
	(($get_esubgroups!=0)?", ин-яз ".$get_esubgroups:"")." - ".$SiteTitle;


if($IsLector)
	$SchedMenuBar = $lector_a['lcr_shtname'];
else if($IsRoom)
	$SchedMenuBar = $room_a['room_number'];
else
	$SchedMenuBar = "".$flows_a['gr_name']."-".GrCourse($flows_a['gr_year-start'], $days[0], $days[1]).
	"-".$get_groups.
	(($get_lsubgroups>2)?" (".($get_lsubgroups-2).")":"").
	(($get_esubgroups!=0)?" (И/Я ".$get_esubgroups.")":"");


@setcookie("sched_ttl", $SchedMenuBar, time()+(31536000*5), "/");
@setcookie("sched_type", "full", time()+(31536000*5), "/");


$IncludeToHead = '<script type="text/javascript" language="javascript" src="/js/atoprint.js"></script>
<link rel="stylesheet" type="text/css" href="/css/example_mini.css" media="screen">
';


require_once($Inc_sys."html-fancybox_head.php");

$menu = "full";
require_once($Inc_sys."html-header.php");
require_once($Inc_sys."html-titlebar.php");
require_once("../_menu.php");

?>
<table style="float: right; margin: 0px; margin-right: 20px" cellpadding="0" cellspacing="0">
<tbody>
<tr>
<td nowrap="nowrap">
<?php
echo '<a href="javascript://" onclick="atoprint(\'MessForPrint\');">Версия для печати <img style="border-width: 0;" alt="Версия для печати" title="Версия для печати" src="/css/images/to_print.png"></a>';


if((!$IsLector)&&(!$IsRoom))
{
	if(file_exists("../excels/loaded/".$flows_a['gr_name']." ".GrCourse($flows_a['gr_year-start'], $days[0], $days[1])."-".$get_groups.".xls"))
	{
	?>
	<a href="<?="/excels/loaded/".urlencode($flows_a['gr_name'])."%20".GrCourse($flows_a['gr_year-start'], $days[0], $days[1])."-".$get_groups.".xls"?>"><img style="border-width: 0;" alt="Скачать оригинальный Excel-файл" title="Скачать оригинальный Excel-файл" src="/css/images/excel.png"></a>
	<?php
	}
}
?>
</td>
</tr>
</tbody>
</table>
<?php
if($IsLector)
echo "<a href='/d/oneday?lector=".$get_lector."'>Листочек на день</a>";
else if($IsRoom)
echo "<a href='/d/oneday?room=".$get_room."'>Листочек на день</a>";
else
echo "<a href='/d/oneday?fac=".$get_fac."&amp;flow=".$get_flows."&amp;grp=".$get_groups."&amp;lsubgrp=".$get_lsubgroups."&amp;esubgrp=".$get_esubgroups."'>Листочек на день</a>";


if($IsLector)
echo " • <a href='/d/chlcr'>Другой преподаватель</a>";
else if($IsRoom)
echo " • <a href='/d/chroom'>Другая комната</a>";
else
{
echo " • <a href='/d/chgr'>Другая группа</a>";
echo " • <a class=\"textfile fancybox.iframe\" href=\"/d/getlinks.php?flow=".$get_flows."\">Скопировать ссылки</a>";
}


echo "<br>\n";
if(isset($_GET['showtime'])) echo date("Y-m-d H:i:s");

if($old_schedule)
{
	echo "<br><h2 style=\"text-align: center;\">Старое расписание</h2>";
}
else echo "<br>";


echo "<h1>";
if($IsLector)
{
	echo "".$lector_a['lcr_fullname']." (".$daycounts['desc'].")";;
	//echo "<br>\n<span style=\"color: red;\">[Из-за некомплектации актуальных расписаний, занятий может не хватать]</span>";
}
else if($IsRoom)
{
	echo "".$room_a['room_number']." (".$daycounts['desc'].")";;
	//echo "<br>\n<span style=\"color: red;\">[Из-за некомплектации актуальных расписаний, занятий может не хватать]</span>";
}
else
	echo "".$flows_a['gr_name']."-".GrCourse($flows_a['gr_year-start'], $days[0], $days[1])."-".$get_groups.
	(($get_lsubgroups>2)?", подгруппа ".($get_lsubgroups-2):"").
	(($get_esubgroups!=0)?", подгруппа ин-яз ".$get_esubgroups:"")." (".$daycounts['desc'].")";


echo "</h1>\n\n";

if((!$IsLector)&&(!$IsRoom))
{
	echo "<small>Обновление от: ".TextDate($flows_a['latest_upd'])."</small>";
}

$OldCounter = 0;
$NewCounter = 0;
$IsNew = 0;

if(!$old_schedule)
{
//-------------------------------------------ЕСЛИ СВЕЖЕЕ-------------------------------------------------------------------
echo '<div style="padding: 0px 10px 0px 10px;" class="hideWrap">';
echo '<a class="hideBtn" href="javascript://" onclick="$(\'#hideCont1\').slideToggle(\'normal\');return false;">Показать прошедшее</a>';

	PrDivHEAD();echo "<!-- Курица номер 2 -->\n";

	echo "<div style=\"display:none;\" id=\"hideCont1\" class=\"hideCont\">\n";
	echo "\n<!-- Первая тыква НЕстарых-->\n";
	TableHeader(); //Первая тыква (НЕстарые расписания)
//-------------------------------------------ЕСЛИ СВЕЖЕЕ-------------------------------------------------------------------
}

$weekday = 0;
$couples = 0;


$counter = 1;
$time = null; //strtotime($daycounts['daystart']);
$timeStart = null;
$timeEnd = null;

$schedule_dump = json_decode(file_get_contents(dirname(__FILE__) . "/kek.json"), true);
foreach($schedule_dump as $key => $val)
{
    if(!$time)
    {
        $time = strtotime($key);
        $timeStart = strtotime($key);
    }
    $timeEnd = strtotime($key);
}

while($time < $timeEnd)
{
////////////////////////////////////////////////////////////////////////БОЛЬШОЙ ЦИКЛ///////////////////////////////////////////////////////////

	if(!$old_schedule)
	{
	//-------------------------------------------ЕСЛИ СВЕЖЕЕ-------------------------------------------------------------------
		////////////////////////////////////////////////////Разделитель старого и нового////////////////////////////////////////////////////////////
		if((date('Y-m-d', $time)==date('Y-m-d'))||( (strtotime(date('Y-m-d')) < $timeStart) && ($counter == 1) ))
		{
			if($OldCounter==0)
			{
			    echo "<tr><td style=\"background-color: #FFFFFF; border: 1px solid #000000; text-align: center; padding: 25px; font-size: 25px;\" colspan=\"10\">Занятия ещё не начались</td></tr>\n";
			}
			$IsNew = 1;
			$NewCounter++;
			TableFooter();
			echo "<!-- Куриные лапы -->\n";//Первые лапы (НЕстарые расписания)
			echo "\n<!-- Вторая тыква НЕ старых -->\n";
			TableHeader(); //Вторая тыква (НЕстарые расписания)
		}
		else
		{
    		if($IsNew==0)
    		    $OldCounter++;
		    else
		        $NewCounter++;
		}
		////////////////////////////////////////////////////Разделитель старого и нового////////////////////////////////////////////////////////////
	//-------------------------------------------ЕСЛИ СВЕЖЕЕ End---------------------------------------------------------------
	}
	else
	{
	//-------------------------------------------ЕСЛИ ПРОСРОЧЕННОЕ-------------------------------------------------------------------
		if($counter == 1)
		{
		    echo '<div style="padding: 0px 10px 0px 10px;">';

		    PrDivHEAD();echo "<!-- Курица номер 1 -->\n";

		    echo "\n<!-- Первая тыква прошлых-->\n";
		    TableHeader();
		}
	//-------------------------------------------ЕСЛИ ПРОСРОЧЕННОЕ End---------------------------------------------------------------
	}

    $weekNumber = ((int)date("W", $time)) - 1;
	$couples = (int)(($weekNumber & 1) xor $daycounts['couples']);
	//$couples = (int)((((int)date("W", $time)) & 1) xor !$daycounts['couples']);
/////////////////////////////////////////СТРОКА НАЧАЛО//////////////////////////////////////////////////////////////////////////////////////////////
	?>
    <tr style="height: 60px;" class="<?php if(!date("w", $time)) echo "tr_holyday"; else if(strtotime(date('Y-m-d'))>$time) echo "tr_old"; else if(date('Y-m-d', $time)==date('Y-m-d')) echo "tr_today"; else if(date('Y-m-d', $time-86400)==date('Y-m-d')) echo "tr_tomorrow"; else echo "tr_new"; ?>">

	<?php
	///////////////Даты-таймы/////////////////////////////////////////////////////////////////////////////////?>
	<td nowrap="nowrap" style="width: 83px; border: 1px solid #000000; <?php if(date('Y-m-d', $time)==date('Y-m-d')) echo "border: 3px solid #FF0000;background-color: #00FFFF;"?>">
	<?php if($get_lector){?>
	<a href="/d/oneday?lector=<?=$get_lector?>&amp;ofdate=<?=date('Y-m-d', $time)?>"><?=TextDateZ_s(date('Y-m-d', $time))?></a>
	<?php } else if($get_room){?>
	<a href="/d/oneday?room=<?=$get_room?>&amp;ofdate=<?=date('Y-m-d', $time)?>"><?=TextDateZ_s(date('Y-m-d', $time))?></a>
	<?php } else { ?>
	<a href="/d/oneday?fac=<?=$get_fac?>&amp;flow=<?=$get_flows?>&amp;grp=<?=$get_groups?>&amp;lsubgrp=<?=$get_lsubgroups?>&amp;esubgrp=<?=$get_esubgroups?>&amp;ofdate=<?=date('Y-m-d', $time)?>"><span style="color: #000000;"><?=TextDateZ_s(date('Y-m-d', $time))?></span></a>
	<?php } ?>

	</td>
			<td nowrap="nowrap" style="width: 27px; border: 1px solid #000000; <?php if(date('Y-m-d', $time)==date('Y-m-d')) echo "background-color: #00FFFF;"?>"><?=weekdayn(date("w", $time));?></td>
			<td nowrap="nowrap" style="width: 12px; border: 1px solid #000000; <?php if(date('Y-m-d', $time)==date('Y-m-d')) echo "background-color: #00FFFF;"?>"><?php echo (($couples)?"<span title=\"'Верхняя' или нечётная неделя\">В</span>":"<span title=\"'Нижняя' или чётная неделя\">Н</span>");/*echo " ".(int)date("W", $time); echo " ".$couples;*/?></td>
	<?php
	 ///////////////Даты-таймы End/////////////////////////////////////////////////////////////////////////////


	/////////////////Сами элементы расписания/////////////////////////////////////////////////////////////////

	/*
			global $get_lsubgroups;
			global $get_groups;
			global $get_flows;
	*/


/////////////////////////////////////////БОЛЬШОЙ ЗАПРОС К БАЗЕ///////////////////////////////////////////////////////////////
	if($get_lector)
	{
	    $DayQuery = "SELECT * FROM
	    schedule__maindata,
	    schedule_disciplyne,
	    schedule_lectors,
	    schedule_flows,
	    schedule_rooms,
	    schedule_ltype

	    WHERE

			    schedule__maindata.id_disciplyne=schedule_disciplyne.id_disciplyne
			    AND schedule__maindata.id_lector=schedule_lectors.id_lector
			    AND schedule__maindata.id_room=schedule_rooms.id_room
			    AND schedule__maindata.id_flow=schedule_flows.id_flow
			    AND schedule__maindata.id_ltype=schedule_ltype.id_ltype

	    AND
	    id_day=".$id_day_1."
	    AND schedule__maindata.id_lector=".$get_lector."
	    AND `weekday`=".date('w', $time)."
	    AND (
	    (onlydays LIKE '%".date('Y-m-d', $time)."%')
	    OR
	    ((STR_TO_DATE('".date('Y-m-d', $time)."', '%Y-%m-%d') BETWEEN `period-start` AND `period-end`)
	      AND (exceptions IS NULL OR (exceptions NOT LIKE '%".date('Y-m-d', $time)."%')))
	    )
	    AND ((couples=0) OR ((couples=1 AND ".(int)$couples.") OR (couples=2 AND ".(int)(!$couples).")))
	    ORDER BY lection, `change` desc, `onlydays` desc;";
    }
	else if($get_room)
	{
	    $DayQuery = "SELECT * FROM
	    schedule__maindata,
	    schedule_disciplyne,
	    schedule_lectors,
	    schedule_flows,
	    schedule_rooms,
	    schedule_ltype

	    WHERE

			    schedule__maindata.id_disciplyne=schedule_disciplyne.id_disciplyne
			    AND schedule__maindata.id_lector=schedule_lectors.id_lector
			    AND schedule__maindata.id_room=schedule_rooms.id_room
			    AND schedule__maindata.id_flow=schedule_flows.id_flow
			    AND schedule__maindata.id_ltype=schedule_ltype.id_ltype

	    AND
	    id_day=".$id_day_1."
	    AND schedule__maindata.id_room=".$get_room."
	    AND `weekday`=".date('w', $time)."
	    AND (
	    (onlydays LIKE '%".date('Y-m-d', $time)."%')
	    OR
	    ((STR_TO_DATE('".date('Y-m-d', $time)."', '%Y-%m-%d') BETWEEN `period-start` AND `period-end`)
	      AND (exceptions IS NULL OR (exceptions NOT LIKE '%".date('Y-m-d', $time)."%')))
	    )
	    AND ((couples=0) OR ((couples=1 AND ".(int)$couples.") OR (couples=2 AND ".(int)(!$couples).")))
	    ORDER BY lection, `change` desc, `onlydays` desc;";
    }
	else
    {
	    $DayQuery = "SELECT * FROM
	    schedule__maindata,
	    schedule_disciplyne,
	    schedule_lectors,
	    schedule_rooms,
	    schedule_ltype

	    WHERE

			    schedule__maindata.id_disciplyne=schedule_disciplyne.id_disciplyne
			    AND schedule__maindata.id_lector=schedule_lectors.id_lector
			    AND schedule__maindata.id_room=schedule_rooms.id_room
			    AND schedule__maindata.id_ltype=schedule_ltype.id_ltype

	    AND
	    id_day=".$id_day_1."
	    AND id_flow='".$get_flows."'
	    AND (((id_subgrp='".$get_lsubgroups."' OR id_subgrp='".$get_esubgroups."') AND issubgrp=1) OR issubgrp=0)
	    AND id_group LIKE '%".$get_groups."%'
	    AND `weekday`=".date('w', $time)."
	    AND (
		    (onlydays LIKE '%".date('Y-m-d', $time)."%')
	    OR
		    ((STR_TO_DATE('".date('Y-m-d', $time)."', '%Y-%m-%d') BETWEEN `period-start` AND `period-end`)
		      AND (exceptions IS NULL OR (exceptions NOT LIKE '%".date('Y-m-d', $time)."%')))
	    )
	    AND ((couples=0) OR ((couples=1 AND ".(int)$couples.") OR (couples=2 AND ".(int)(!$couples).")))
	    ORDER BY lection, `change` desc, `onlydays` desc;";
	}
/////////////////////////////END/////////БОЛЬШОЙ ЗАПРОС К БАЗЕ///////END/////////////////////////////////////////////////////

	//echo "<!--- ".$DayQuery."--->";

	/* $DayOfWeek_Q = mysqlold_query($DayQuery);
	if(!$DayOfWeek_Q)
		die(mysqlold_error());
	*/

	$counter = 1;

    // $schedule_dump_day = [];

	$LectionCount = 0;
	// while(($DayOfWeek = mysqlold_fetch_assoc($DayOfWeek_Q)))
	$curDate = (string)date('Y-m-d', $time);
	$DayDump = array_key_exists($curDate, $schedule_dump) ? $schedule_dump[$curDate] : [];
	$DayOfWeek = [];
	$DayOfWeek['diration'] = 1;
	foreach($DayDump as $lectionNumber => $DayOfWeekQ)
	{
    	$DayOfWeek = $DayOfWeekQ;
		while($counter < $DayOfWeek['lection'])
		{
		    ?>
		    <td style="border: 1px solid #000000; <?=colortime($counter, date('Y-m-d', $time), $DayOfWeek['diration']);?>" colspan="1">

		    </td>
		    <?php
		    $counter++;
		}

	    if($LectionCount < $DayOfWeek['lection'])
	    {//Невозможность выводить одну и ту же пару подряд
	        $schedule_dump_day[$LectionCount] = $DayOfWeek;
		    ?>
		    <td class="<?=
							    (($DayOfWeek['id_ltype']==1) ?
									    "day_lection":
									    (($DayOfWeek['id_ltype']==2) ?
												    "day_prctic":
												    (($DayOfWeek['id_ltype']==3) ?
															    "day_labwork":
															    (($DayOfWeek['id_ltype']==4) ?
																			    "day_sport":""))))
																			    ?>" style=" border: 1px solid #000000; <?php echo colortime($counter,date('Y-m-d', $time),$DayOfWeek['diration']); if($DayOfWeek['change']==1) echo "background-image: url('/css/images/edititem.gif'); background-position: right top; background-repeat: no-repeat;";?>" colspan="<?=$DayOfWeek['diration'];?>">

		    <?php
		    if($get_lector)
			    echo "<a style=\"color: #000000\" class=\"textfile fancybox.iframe\" href=\"lection_info.php?lector=".$get_lector.
			    "&amp;lection=".$counter."&amp;lection_id=".$DayOfWeek['id']."&amp;date=". date("Y-m-d", $time).(($old_schedule)?"&amp;day=".$id_day_1."":"")."\">";
		    else if($get_room)
			    echo "<a style=\"color: #000000\" class=\"textfile fancybox.iframe\" href=\"lection_info.php?room=".$get_room.
			    "&amp;lection=".$counter."&amp;lection_id=".$DayOfWeek['id']."&amp;date=". date("Y-m-d", $time).(($old_schedule)?"&amp;day=".$id_day_1."":"")."\">";
		    else
			    echo "<a style=\"color: #000000\" class=\"textfile fancybox.iframe\" href=\"lection_info.php?flow=".$get_flows."&amp;grp=".$get_groups."&amp;lsubgrp=".$get_lsubgroups.
			    "&amp;esubgrp=".$get_esubgroups."&amp;lection=".$counter."&amp;lection_id=".$DayOfWeek['id']."&amp;date=".date("Y-m-d", $time).(($old_schedule)?"&amp;day=".$id_day_1."":"")."\">";

		    ?>
		    <font color=black>
		    <?php
				    echo "<b>".(($DayOfWeek['id_ltype']>4)?"<u>".$DayOfWeek['exam_time']."</u> ":"").$DayOfWeek['dysc_name']."</b><br>";

		    if(!$get_lector)
				    echo "<small>".$DayOfWeek['lcr_fullname']."</small><br>";

		    if(($IsLector) || ($IsRoom))
				    echo "<small>".$DayOfWeek['gr_name']."-".GrCourse($DayOfWeek['gr_year-start'], $days[0], $days[1])."-".str_replace(" ", "/",$DayOfWeek['id_group'])." (".$DayOfWeek['gr_year-end'].")</small><br>";


		    echo "<i><u>".$DayOfWeek['room_number']."</u></i><br>";
		    if($DayOfWeek['id_ltype']==3)
		     		echo "<span style=\"background-color: #FF6600\">";
		    echo "<i><u>".$DayOfWeek['lt_name']."</u></i>";
		    if($DayOfWeek['id_ltype']==3)
				    echo "</span>";
		    ?>
		    </font>
		    <?="</a>"?>
		    </td>
		    <?php
		    $counter+=$DayOfWeek['diration'];
		    $LectionCount = $DayOfWeek['lection']+$DayOfWeek['diration']-1;
	    }//Невозможность выводить одну и ту же пару подряд
	}

	while($counter < 8-(($SeventhLection==1)?0:1)-(($SixthLection==1)?0:1))
	{
	    ?>
	    <td style=" <?php echo colortime($counter, date('Y-m-d', $time), $DayOfWeek['diration']); ?> border: 1px solid #000000;" colspan="1">

	    </td>
	    <?php
	    $counter++;
	}
	?>

	<?php
	/////////////////Сами элементы расписания/////////////////////////////////////////////////////////////////
	?>

</tr>
		<?php
/////////////////////////////////////////СТРОКА КОНЕЦ//////////////////////////////////////////////////////////////////////////////////////////////
    //if(!empty($schedule_dump_day))
    //    $schedule_dump[date('Y-m-d', $time)] = $schedule_dump_day;

	$time += 24*60*60;    // секунд в одном дне
	//	if(date("w", $time)==1)
	//	$couples = !$couples;

///////////////////////////////////////////////////////////////END//////БОЛЬШОЙ ЦИКЛ///END/////////////////////////////////////////////////////
}

//file_put_contents(dirname(__FILE__) . "/kek.json", json_encode($schedule_dump, JSON_PRETTY_PRINT));

if(!$old_schedule)
{
	if($NewCounter==0)
	{
		echo "\n<!-- Нижние лапы -->\n";
		TableFooter();
		echo "\n<!-- Нижняя тыква -->\n";
		TableHeader();

		echo "<tr><td style=\"background-color: #FFFFFF; border: 1px solid #000000; text-align:".
		     "center; padding: 25px; font-size: 25px;\" colspan=\"10\">Расписание просрочено</td></tr>";
	}
}

echo "\n<!-- Последняя тыква -->\n";
TableFooter2();

PrDivFOOT();

echo "</div>";
echo "\n<!-- Поздравляю Вас, уважаемый читатель исдных кодов, ты нашёл пасхальное яйцо! =) -->\n";

//echo "Counter ".$NewCounter." OldCounter".$OldCounter;
require_once($Inc_sys."html-footer.php");

SetStatistics($SchedMenuBar, "PC_full");
