<?php

if(!isset($_POST['act']))
{
	die("Error!!!");
}

$sys_inc = "../sys/";
require $sys_inc."db.php";
require $sys_inc."common.php";

Header("Cache-Control: no-cache, must-revalidate"); // говорим браузеру что-бы он не кешировал эту страницу
Header("Pragma: no-cache");
Header("Content-Type: text/javascript; charset=utf-8"); // говорим браузеру что это javascript в кодировке UTF-8

$act = $_POST['act'];

if($act=="GetFlows")
{
	$query = mysqlold_query("SELECT * FROM `schedule_flows` WHERE id_facult='" . intval($_POST['fac_id']) . "' ORDER BY gr_name,`gr_year-start`");
	$i = 1;
	echo "\ndocument.getElementById('flow').options.length = 1;\n";
	while(($flow_a = mysqlold_fetch_array($query)))
	{
		$IsEmtyFlow = 0;
		$query_d = mysqlold_query("SELECT * FROM `schedule_daycount` ORDER BY dayend DESC LIMIT 1");
		$daycounts = mysqlold_fetch_array($query_d);

		echo "/* ";
		echo $daycounts['id_day'];
		echo " */\n";

		if(intval(mysqlGetField("SELECT count(*) FROM `schedule__maindata` WHERE id_day=" . $daycounts['id_day'] . " AND id_flow = ".$flow_a['id_flow'].";", 0)) != 0)
		{
			$old_schedule = 0;
		}
		else
		{
			$query_2 = mysqlold_query("SELECT * FROM schedule_daycount WHERE id_day=" . ($daycounts['id_day'] - 1) . " ORDER BY dayend DESC LIMIT 1");
			//echo "<h2 style=\"text-align: center;\">Старое расписание</h2>";
			$old_schedule = ($query_2) ? 1 : 0;
		}

		if($old_schedule==1)
		{
			$daycounts_old = mysqlold_fetch_array($query_2);
			if(($daycounts_old == NULL) ||
				intval(mysqlGetField("SELECT count(*) FROM schedule__maindata WHERE id_day=" . $daycounts_old['id_day'] . " AND id_flow = " . $flow_a['id_flow'] . ";", 0)) == 0)
				$IsEmtyFlow = 1;
		}
		$days = explode("-", $daycounts['daystart']);

		echo "document.getElementById('flow').options[".$i."] = new Option(\"".
		$flow_a['gr_name'].grFlowNumber($flow_a['gr_year-start'], $flow_a['gr_year-end'], $days[0], $days[1] ).
		" ".$flow_a['gr_year-start']."-".$flow_a['gr_year-end'].
		(($old_schedule==1)?((!$IsEmtyFlow)?" *old*":" *Empty*"):"")."\", \"".$flow_a['id_flow']."\");\n";

		if(!empty($_COOKIE["flow"]))
		{
			if(intval($_COOKIE['flow'])==intval($flow_a['id_flow']))
			echo "document.getElementById('flow').selectedIndex = ".$i.";\n";
		}

		$i++;
	}
	echo "errormsg = 'success';";
}
else
if($act == "GetGroups")
{
	$query = mysqlold_query("SELECT * FROM `schedule_flows` WHERE id_flow='".intval($_POST['flow_id'])."' LIMIT 1;");
	$flow = mysqlold_fetch_array($query);

	$query = mysqlold_query("SELECT * FROM schedule_daycount ORDER BY dayend DESC LIMIT 1");
	$daycounts = mysqlold_fetch_array($query);

	if( intval(mysqlGetField("SELECT count(*) FROM schedule__maindata WHERE id_day=".$daycounts['id_day']." AND id_flow = ".$flow['id_flow'].";", 0)) != 0)
	{
		$old_schedule = 0;
	}
	else
	{
		$query_2 = mysqlold_query("SELECT * FROM schedule_daycount WHERE id_day=".($daycounts['id_day']-1)." ORDER BY dayend DESC LIMIT 1");
		//echo "<h2 style=\"text-align: center;\">Старое расписание</h2>";
		$old_schedule = 1;
	}

	if($old_schedule == 1)
		$daycounts = mysqlold_fetch_array($query_2);

	if($flow==NULL)
		die("//empty");

	echo "document.getElementById('groups').options.length = 1;\n";
	$counter = 1;
	for($i=1; $i<=$flow['group_q']; $i++)
	{
		if( intval(mysqlGetField("SELECT count(*) FROM schedule__maindata WHERE id_day=".$daycounts['id_day']." AND id_flow = ".$flow['id_flow']." AND id_group LIKE '%$i%';", 0)) != 0)
		{
			echo "document.getElementById('groups').options[".$counter."] = new Option(\"".RuCounter($i)."\", \"".$i."\");\n";
			if(!empty($_COOKIE["grp"]))
			{
				if(intval($_COOKIE['grp'])==$i)
				echo "document.getElementById('groups').selectedIndex = ".intval($counter).";\n";
			}
		 $counter++;
		}
	}

	echo "\ndocument.getElementById('lsubgrp').options.length = 1;\n";
	echo "\ndocument.getElementById('esubgrp').options.length = 1;\n";
	for($i=1; $i<=6; $i++)
	{
		if(intval(mysqlGetField("SELECT count(*) FROM schedule__maindata WHERE id_day=".$daycounts['id_day'] .
			" AND id_flow = ".$flow['id_flow']." AND issubgrp=1 AND id_subgrp LIKE '%$i%';", 0)) != 0)
		if($i < 3)
		{
			echo "document.getElementById('esubgrp').options[".($i)."] = new Option(\"".RuCounter($i)."\", \"".($i)."\");\n";
			if(!empty($_COOKIE["esubgrp"]))
			{
				if(intval($_COOKIE['esubgrp'])==$i)
					echo "document.getElementById('esubgrp').selectedIndex = ".intval($i).";\n";
			}
		}
		else
		{
			echo "document.getElementById('lsubgrp').options[".($i-2)."] = new Option(\"".RuCounter($i-2)."\", \"".($i)."\");\n";
			if(!empty($_COOKIE["lsubgrp"]))
			{
				if(intval($_COOKIE['lsubgrp'])==$i)
					echo "document.getElementById('lsubgrp').selectedIndex = ".intval(($i-2)).";\n";
			}
		}
	}

	echo "errormsg = 'success';";
}
else
if($act=="GetSubGroups")
{
	$query 	= mysqlold_query("SELECT * FROM `schedule_flows` WHERE id_flow='".intval($_POST['flow_id'])."' LIMIT 1;");
	$flow 	= mysqlold_fetch_array($query);

	$query 	= mysqlold_query("SELECT * FROM `schedule_daycount` ORDER BY dayend DESC LIMIT 1");
	$daycounts = mysqlold_fetch_array($query);

	if( intval(mysqlGetField("SELECT count(*) FROM schedule__maindata WHERE id_day=".$daycounts['id_day']." AND id_flow = ".$flow['id_flow'].";", 0)) != 0)
	{
		$old_schedule = 0;
	}
	else
	{
		$query_2 = mysqlold_query("SELECT * FROM schedule_daycount WHERE id_day=".($daycounts['id_day']-1)." ORDER BY dayend DESC LIMIT 1");
		//echo "<h2 style=\"text-align: center;\">Старое расписание</h2>";
		$old_schedule = 1;
	}

	if($old_schedule == 1)
		$daycounts = mysqlold_fetch_array($query_2);

	if($flow == NULL)
		die("//empty");
	echo "document.getElementById('groups').options.length = 1;\n";
	$counter = 1;
	for($i=1; $i<=$flow['group_q']; $i++)
	{
		if( intval(mysqlGetField("SELECT count(*) FROM schedule__maindata WHERE id_day= ".$daycounts['id_day']." AND id_flow = ".$flow['id_flow']." AND id_group LIKE '%$i%';", 0)) != 0)
		{
			echo "document.getElementById('groups').options[".$counter."] = new Option(\"".RuCounter($i)."\", \"".$i."\");\n";
			if(!empty($_COOKIE["grp"]))
			{
				if(intval($_COOKIE['grp']) == $i)
					echo "document.getElementById('groups').selectedIndex = ".intval($counter).";\n";
			}
		 	$counter++;
		}
	}

	echo "\ndocument.getElementById('lsubgrp').options.length = 1;\n";
	echo "\ndocument.getElementById('esubgrp').options.length = 1;\n";
	for($i=1; $i<=4; $i++)
	{
		if( intval(mysqlGetField("SELECT count(*) FROM schedule__maindata WHERE id_day=".$daycounts['id_day'].
		" AND id_flow = ".$flow['id_flow']." AND issubgrp=1 AND id_subgrp LIKE '%$i%';", 0)) != 0)
		if($i<3)
		{
			echo "document.getElementById('esubgrp').options[".($i)."] = new Option(\"".RuCounter($i)."\", \"".($i)."\");\n";
			if(!empty($_COOKIE["esubgrp"]))
			{
				if(intval($_COOKIE['esubgrp'])==$i)
				echo "document.getElementById('esubgrp').selectedIndex = ".intval($i).";\n";
			}
		}
		else
		{
			echo "document.getElementById('lsubgrp').options[".($i-2)."] = new Option(\"".RuCounter($i-2)."\", \"".($i)."\");\n";
			if(!empty($_COOKIE["lsubgrp"]))
			{
				if(intval($_COOKIE['lsubgrp']) == $i)
					echo "document.getElementById('lsubgrp').selectedIndex = ".intval(($i-2)).";\n";
			}
		}
	}

	echo "errormsg = 'success';";
}
