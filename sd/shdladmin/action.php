<?php
require_once("../../sys/db.php");
if(isset($_POST['only_dates']))
{
    $onlydates = $_POST['only_dates'];
    if(strstr($onlydates, ";"))
    {
        $onlydates_arr = explode(";", $onlydates);
        $onlydates = "";
        for($i=0;$i<count($onlydates_arr);$i++)
        {
	        $onlydates_arr2 = explode(".",$onlydates_arr[$i]);
	        $onlydates .="2013-".$onlydates_arr2[1]."-".$onlydates_arr2[0].(($i!=(count($onlydates_arr)-1))?" ":"");
        }
    }
}

if(isset($_POST['issubgrp']))
{
    $issubgrp = $_POST['issubgrp'];
}
else
    $issubgrp = 0;

$Q = "INSERT INTO schedule__maindata (".
"id_disciplyne".", ".
"id_lector".", ".
"id_flow".", ".
"id_group".", ".
"id_subgrp".", ".
"id_day".", ".
"id_ltype".", ".
"issubgrp".", ".
"id_room".", ".
"diration".", ".
"lection".", ".
"`period-start`".", ".
"`period-end`".", ".
"exceptions".", ".
"weekday".", ".
"onlydays".", ".
"exam_time".", ".
"`change`".", ".
"`change_reason`".", ".
"`couples`".
") values(".
$_POST['disciplyne'].", ".//"id_disciplyne"
$_POST['lector'].", ".//"id_lector".
$_POST['flow'].", '".//"id_flow".", ".
$_POST['groups']."', ".//"id_group"
(($issubgrp=="1")?"'".$_POST['subgrp']."', '":"NULL,'").//"id_subgrp"
$_POST['day']."', ".//"id_day"
$_POST['ltype'].", ".//"id_ltype"
$issubgrp.", ".//"issubgrp"
$_POST['room'].", ".//"id_room"
$_POST['diration'].", ".//"diration"
$_POST['lection'].", ".//"lection"
(($_POST['dates']=="period")?"'".$_POST['periodstart']."', ":"NULL,").//"`period-start`"
(($_POST['dates']=="period")?"'".$_POST['periodend']."', ":"NULL,").//"`period-end`"
(($_POST['dates']=="period")?"'".$_POST['exceptions']."', ":"NULL, ").//"exceptions"
$_POST['weekday'].", ".//"weekday"
(($_POST['dates']=="onlydays")?"'".$onlydates."', '":"'', '").//"onlydays"
$_POST['examtime']."', ".//"id_day"
"1, ".  //"change"
"'".$_POST['change_reason']."', ".  //"change_reason"
$_POST['couples'].//"couples".
");";

$query = mysqlold_query($Q);

echo $Q."<br><br>";

if($query)
    echo "Добавлено!";
else
    echo "Ошибка<br>".mysqlold_error();

