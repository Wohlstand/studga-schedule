<?php
//Общие функции

//Вывод названия дня недели по номеру
function weekdayn($nmb)
{
	switch($nmb)
	{
	case 0:	return "Вс";
	case 1:	return "Пн";
	case 2:	return "Вт";
	case 3:	return "Ср";
	case 4:	return "Чт";
	case 5:	return "Пт";
	case 6:	return "Сб";
	}
}

function weekdaynFull($nmb)
{
	switch($nmb)
	{
	case 0:	return "Воскресенье";
	case 1:	return "Понедельник";
	case 2:	return "Вторник";
	case 3:	return "Среда";
	case 4:	return "Четверг";
	case 5:	return "Пятница";
	case 6:	return "Суббота";
	}
}

function monthName($nmb)
{
	switch($nmb)
	{
	case 1:	return "Января";
	case 2:	return "Февраля";
	case 3:	return "Марта";
	case 4:	return "Апреля";
	case 5:	return "Мая";
	case 6:	return "Июня";
	case 7:	return "Июля";
	case 8:	return "Августа";
	case 9:	return "Сентября";
	case 10: return "Октября";
	case 11: return "Ноября";
	case 12: return "Декабря";
	}
}

function monthName_s($nmb)
{
	switch($nmb)
	{
	case 1:	return "Янв";
	case 2:	return "Фев";
	case 3:	return "Мар";
	case 4:	return "Апр";
	case 5:	return "Мая";
	case 6:	return "Июн";
	case 7:	return "Июл";
	case 8:	return "Авг";
	case 9:	return "Сен";
	case 10: return "Окт";
	case 11: return "Ноя";
	case 12: return "Дек";
	}
}

function RuCounter($cn)
{
	switch($cn)
	{
	case 1:
		return "Первая";
	case 2:
		return "Вторая";
	case 3:
		return "Третья";
	case 4:
		return "Четвёртая";
	case 5:
		return "Пятая";
	default:
		return $cn;
	}
}

function RuCounter_m($cn)
{
	switch($cn)
	{
	case 1:
		return "Первый";
	case 2:
		return "Второй";
	case 3:
		return "Третий";
	case 4:
		return "Четвёртый";
	case 5:
		return "Пятый";
	case 6:
		return "Шестой";
	case 7:
		return "Седьмой";
	case 8:
		return "Восмьой";
	case 9:
		return "Девятый";
	default:
		return $cn;
	}
}

function TextDate_s($dt)
{
	return 	date("j", strtotime($dt))." ".
			monthName_s(date("m", strtotime($dt)))." ".
			date("Y", strtotime($dt));
}

function TextDateZ_s($dt)
{
	return 	date("d", strtotime($dt))." ".
			monthName_s(date("m", strtotime($dt)))." ".
			date("Y", strtotime($dt));
}

function TextDate($dt)
{
	return 	date("j", strtotime($dt))." ".
			monthName(date("m", strtotime($dt)))." ".
			date("Y", strtotime($dt));
}

function TextDateList_s($dt1)
{
	$dt2 = explode(" ", $dt1);
	$dt = "";
	for($i=0; $i<count($dt2); $i++)
	{
	    $dt.= TextDate_s($dt2[$i]);
	    if($i != (count($dt2)-1))
			$dt.= ", ";
	}
	return $dt;
}

//Красим текущую пару в розовый, прошедшую в синий, будущую не красим

function colortime($lection, $dtm, $diration=1, $out = 'style')
{
	if($out == 'style')
	if($dtm!=date('Y-m-d'))
	return "";

	$TimeArray = array
	(
		array("", ""),
		array("8:30", "10:00"),
		array("10:10", "11:40"),
		array("12:20", "13:50"),
		array("14:00", "15:30"),
		array("15:55", "17:25"),
		array("17:35", "19:05"),
		array("19:15", "20:45")
	);

	if($out == 'style')
	{
		//function SortTime($a, $b)
		//{ a - начало пары     b - конец пары
		$x = (int)str_replace(':', '', $TimeArray[$lection][0]);
		$y = (int)str_replace(':', '', $TimeArray[$lection+$diration-1][1]);

		//if($diration>1)
		//$y+=10+90;

		if($x > (int)date("Gi"))
			return "";
		else
			if( ($x <= (int)date("Gi")) && ($y >= (int)date("Gi")) )
				return "border: 3px solid #FF0000;";
		else
			if( ($y < (int)date("Gi")) )
				return "background-color: #66FFFF;";
		else
			return "background-color: #0000FF;";
	//}
	}

	if($out == 'range')
	{
		return $TimeArray[$lection][0]."-".$TimeArray[$lection+$diration-1][1];
	}
}

function GrCourse($StYear, $crYear="", $crMonth="")
{
	if($crYear=="")
		$crYear = date("Y");
	if($crMonth=="")
		$crMonth = date("m");

	return ((intval($crMonth)<8)?(intval($crYear)-$StYear):(intval($crYear)+1-$StYear));
}


function grFlowNumber($StYear, $EnYear, $crYear="", $crMonth="")
{
	if($crYear=="")
		$crYear = date("Y");
	if($crMonth=="")
		$crMonth = date("m");

	$course = ((intval($crMonth)<8)?(intval($crYear)-$StYear):(intval($crYear)+1-$StYear));

	if( (($crYear==$EnYear) && (intval($crMonth)>8)) || ($crYear>$EnYear))
		return " [выпущенный]";
	else
		return "-".$course;
}

function httpprot_c()
{
	if(isset($_SERVER['HTTPS']))
	return "https";
	else
	return "http";
}


function FatalErrorMessage($MsgHeader="Ошибка", $MsgContent="Ошибка", $ver='desktop')
{
	global $SiteTitle;
		$page_title = $MsgHeader." - ".$SiteTitle;
	if($ver=='mobile')
	{
		require_once(dirname(__FILE__)."/mobile-html-header.php");
		require_once(dirname(__FILE__)."/mobile-html-titlebar.php");
		require_once(dirname(__FILE__)."/../sd/_menu_m.php");
	}
	else
	{
		require_once(dirname(__FILE__)."/html-header.php");
		require_once(dirname(__FILE__)."/html-titlebar.php");
		require_once(dirname(__FILE__)."/../sd/_menu.php");
	}

	echo "<h2 style=\"text-align: center; font-size: 17pt;\">$MsgHeader</h2>";
	echo "<center><span style=\"font-size: 17pt;\">$MsgContent</span></center>";
	if($ver=='mobile')
	{
		require_once(dirname(__FILE__)."/mobile-html-footer.php");
	}
	else
	{
		require_once(dirname(__FILE__)."/html-footer.php");
	}

	exit;
}
