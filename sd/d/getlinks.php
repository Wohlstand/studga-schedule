<?php
header("Content-Type: text/html; charset=UTF-8");
require "../config.php";
$Inc_sys = "../../sys/";

require_once($Inc_sys."db.php");
require_once($Inc_sys."common.php");
require_once($Inc_sys."sd_stat.php");

if(isset($_GET['flow']))
    $get_flows = $_GET['flow'];
else
    $get_flows = 1;

if(isset($_GET['lector']))
    $get_lector = $_GET['lector'];
else
    $get_lector = "";

$Groups = [];
$Lsub = [];
$Lsubs = 0;
$Lsubs_g = [];
$Esub = [];
$Esubs = 0;
$Esubs_g = [];

if($get_lector == "")
{
	$query = mysqlold_query("SELECT * FROM schedule_flows WHERE id_flow='".intval($get_flows)."' LIMIT 1;");
	$flow = mysqlold_fetch_assoc($query);
	if($flow==NULL)
	die("Flow not exist");

	$query = mysqlold_query("SELECT * FROM schedule_daycount ORDER BY dayend DESC LIMIT 1");
	$daycounts = mysqlold_fetch_assoc($query);

	if( intval(mysqlold_result(mysqlold_query("SELECT count(*) FROM schedule__maindata WHERE id_day=".$daycounts['id_day']." AND id_flow = ".$flow['id_flow'].";"), 0)) != 0)
	{
		$old_schedule = 0;
	}
	else
	{
		$query_2 = mysqlold_query("SELECT * FROM schedule_daycount WHERE id_day=".($daycounts['id_day']-1)." ORDER BY dayend DESC LIMIT 1");
		$old_schedule = 1;
	}

	if($old_schedule==1)
	$daycounts = mysqlold_fetch_assoc($query_2);

	$days = explode("-", $daycounts['daystart']);

	if($flow==NULL) die("Schedule is empty");

	$counter = 1;
	for($i=1; $i<=$flow['group_q'];$i++)
	{
		if( intval(mysqlold_result(mysqlold_query("SELECT count(*) FROM schedule__maindata WHERE id_day=".$daycounts['id_day']." AND id_flow = ".$flow['id_flow']." AND id_group LIKE '%$i%';"), 0)) != 0)
		{
		$Groups[$counter-1] = $i;
			$counterS = 0;
			$Esubs_g[$counter-1] = 0;
			$Lsubs_g[$counter-1] = 0;
			for($j=1; $j<=8;$j++)
				{
				if(intval(mysqlold_result(mysqlold_query("SELECT count(*) FROM schedule__maindata WHERE id_day=".$daycounts['id_day'].
				" AND id_flow = ".$flow['id_flow']." AND id_group LIKE '%$i%' AND issubgrp=1 AND id_subgrp LIKE '%$j%';"), 0)) > 0)
				{
					if($j<3)
					{
					$Esub[$Esubs] = $j;
					$Esubs++;
					$Esubs_g[$counter-1] = $Esubs_g[$counter-1]+1;
					}
					else
					{
					$Lsub[$Lsubs] = $j;
					$Lsubs++;
					$Lsubs_g[$counter-1] = $Lsubs_g[$counter-1]+1;
					}
				$counterS++;
				}
				}
		 $counter++;
		}
	}

}


function GetLinks($LinkStyle = "http://sd.studga.ru/d/full", $WIKI = 0)
{
global $Groups;
global $flow;
global $Esubs;
global $Lsubs;
global $Esubs_g;
global $days;
global $Lsubs_g;
$LinkCount = count($Groups) * (($Esubs)?$Esubs:1) * (($Lsubs)?$Lsubs:1);

$LC = 0;
$Groups1 = 0;
$lSub1 = 0;
$eSub1 = 0;
while($LC<$LinkCount)
{

switch($WIKI)
{
case 1:
	echo "[".$LinkStyle."?fac=".$flow['id_facult']."&flow=".$flow['id_flow']."&grp=".$Groups[$Groups1].
	"&lsubgrp=".(($Lsubs_g[$Groups1])?$lSub1+3:0)."&esubgrp=".(($Esubs_g[$Groups1])?$eSub1+1:0)."|".
	$flow['gr_name'].grFlowNumber($flow['gr_year-start'], $flow['gr_year-end'], $days[0], $days[1] )."-".$Groups[$Groups1].
	(($Lsubs_g[$Groups1])?"(".(($Lsubs_g[$Groups1])?$lSub1+1:0).")":"").
	(($Esubs_g[$Groups1])?"(И/Я ".(($Esubs_g[$Groups1])?$eSub1+1:0).")":"")."]"."\n";
	break;
case 2:
	echo "<a href=\"".$LinkStyle."?fac=".$flow['id_facult']."&flow=".$flow['id_flow']."&grp=".$Groups[$Groups1].
	"&lsubgrp=".(($Lsubs_g[$Groups1])?$lSub1+3:0)."&esubgrp=".(($Esubs_g[$Groups1])?$eSub1+1:0)."\">".

	$flow['gr_name'].grFlowNumber($flow['gr_year-start'], $flow['gr_year-end'], $days[0], $days[1] )."-".$Groups[$Groups1].
	(($Lsubs_g[$Groups1])?"(".(($Lsubs_g[$Groups1])?$lSub1+1:0).")":"").
	(($Esubs_g[$Groups1])?"(И/Я ".(($Esubs_g[$Groups1])?$eSub1+1:0).")":"")."</a>"."<br>\n";
	break;
default:
	echo $flow['gr_name'].grFlowNumber($flow['gr_year-start'], $flow['gr_year-end'], $days[0], $days[1] )."-".$Groups[$Groups1].
	(($Lsubs_g[$Groups1])?"(".(($Lsubs_g[$Groups1])?$lSub1+1:0).")":"").
	(($Esubs_g[$Groups1])?"(И/Я ".(($Esubs_g[$Groups1])?$eSub1+1:0).")":"")."\n".

	$LinkStyle."?fac=".$flow['id_facult']."&flow=".$flow['id_flow']."&grp=".$Groups[$Groups1].
	"&lsubgrp=".(($Lsubs_g[$Groups1])?$lSub1+3:0)."&esubgrp=".(($Esubs_g[$Groups1])?$eSub1+1:0)."\n";
}
	$eSub1++;
	if($eSub1>=$Esubs_g[$Groups1])
	{$eSub1 = 0; $lSub1++;}

	if($lSub1>=$Lsubs_g[$Groups1])
	{$eSub1 = 0; $lSub1 = 0; $Groups1++;

switch($WIKI)
{
	case 2: echo "<br>\n"; break;
	default:
	echo "\n";
}

}
	if($Groups1==count($Groups)) break;
	$LC++;
}
}


?>
<script type="text/javascript">
function SelectAll(id)
{
    document.getElementById(id).focus();
    document.getElementById(id).select();
}
</script>
<h3 style="text-align: center">Скопировать ссылки на расписание потока</h3>
<center>Вы можете скопировать ссылки на расписание и поставить их на свой сайт,<br>блог, форум или в социальных сетях, текст выделится по щелчку</center>
<p style="text-align: center"><strong>Обычный текст (для публикации на "стену" в социальных сетях или на форуме)</strong><br>
<textarea onclick="SelectAll('links1');" id="links1" readonly="readonly" name="links1" style="width: 100%; height: 90px" cols="20" rows="15">----------Расписания занятий----------
---Развёрнутые расписания---
<?=GetLinks("http://sd.studga.ru/d/full");?>
---Листочек на день---
<?=GetLinks("http://sd.studga.ru/d/oneday");?>
---Мобильный листочек на день---
<?=GetLinks("http://sd.studga.ru/m/oneday");?>
</textarea>
</p>

<p style="text-align: center"><strong>Вики-код (для интеграции в меню группы "Вконтакте")</strong><br>
<textarea onclick="SelectAll('links3');" id="links3" readonly="readonly"  ame="links3" style="width: 100%; height: 90px" cols="20" rows="1">==Расписания занятий==
'''Развёрнутые расписания'''
<?=GetLinks("http://sd.studga.ru/d/full", 1);?>
'''Листочек на день'''
<?=GetLinks("http://sd.studga.ru/d/oneday", 1);?>
'''Мобильный листочек на день'''
<?=GetLinks("http://sd.studga.ru/m/oneday", 1);?>
</textarea></p>

<p style="text-align: center"><strong>HTML-код (для использования на своём сайте/блоге)</strong><br>
<textarea onclick="SelectAll('links4');" id="links4" readonly="readonly" name="links4" style="width: 100%; height: 90px" cols="20" rows="1"><h2>Расписания занятий</h2>
<h3>Развёрнутые расписания</h3>
<?=GetLinks("http://sd.studga.ru/d/full", 2);?>
<h3>Листочек на день</h3>
<?=GetLinks("http://sd.studga.ru/d/oneday", 2);?>
<h3>Мобильный листочек на день</h3>
<?=GetLinks("http://sd.studga.ru/m/oneday", 2);?>
</textarea></p>
<?php
SetStatistics($flow['gr_name'].grFlowNumber($flow['gr_year-start'], $flow['gr_year-end'], $days[0], $days[1] ), "PC_fastlinks");
?>
