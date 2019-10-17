<?php
require "../config.php";
$Inc_sys = "../../sys/";

if (isset($_GET['lector']))
{
    $get_lector = $_GET['lector'];
    $IsLector   = 1;
    if ($get_lector == "")
        die("Lector doesn't selected!");
    if (!is_numeric($get_lector))
        die("Error Lector value!");
}
else
{
    $get_lector = "";
    $IsLector   = 0;
    if (!empty($_COOKIE['type']) && ((!isset($_GET['grp'])) || (!isset($_GET['flow']))))
    {
        switch ($_COOKIE['type'])
        {
            case "lector":
                $IsLector = 1;
                break;
            case "student":
                $IsLector = 0;
                break;
        }
    }
}


if (!$IsLector)
{
    //////////////////////////////////////////////////////////////////////////////////////
    if (((isset($_GET['grp'])) && (isset($_GET['flow']))) || ((empty($_COOKIE["flow"])) || (empty($_COOKIE["grp"]))))
    {

        if (isset($_GET['fac']))
        {
            $get_fac = $_GET['fac'];
            if (!is_numeric($get_fac))
                die("ERROR in fac Value!!!");
            //setcookie("fac", $get_fac, time()+(31536000*5), "/");
        }
        else
        {
            header("Location: /d/chgr");
            exit;
        }

        if (isset($_GET['grp']))
        {
            $get_groups = $_GET['grp'];
            if (!is_numeric($get_groups))
                die("ERROR in GRP Value!!!");

            //setcookie("grp", $get_groups, time()+(31536000*5), "/");
        }
        else
        {
            header("Location: /d/chgr");
            exit;
        }

        if (isset($_GET['flow']))
        {
            $get_flows = $_GET['flow'];
            if (!is_numeric($get_flows))
                die("ERROR in flow Value!!!");
            //setcookie("flow", $get_flows, time()+(31536000*5), "/");
        }
        else
        {
            header("Location: /d/chgr");
            exit;
        }

        if (isset($_GET['lsubgrp']))
        {
            $get_lsubgroups = $_GET['lsubgrp'];
            if (!is_numeric($get_lsubgroups))
                die("ERROR in lSubGrp Value!!!");
            //setcookie("lsubgrp", $get_lsubgroups, time()+(31536000*5), "/");
        }
        else
        {
            $get_lsubgroups = "0";
            //setcookie("lsubgrp", $get_esubgroups, time()+(31536000*5), "/");
        }

        if (isset($_GET['esubgrp']))
        {
            $get_esubgroups = $_GET['esubgrp'];
            if (!is_numeric($get_esubgroups))
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
        $get_groups     = intval($_COOKIE["grp"]);
        $get_flows      = intval($_COOKIE["flow"]);
        $get_fac        = intval($_COOKIE["fac"]);
    }
    //////////////////////////////////////////////////////////////////////////////////////
}
else
{
    $get_lsubgroups = 3;
    $get_esubgroups = 0;
    $get_groups     = "";
    $get_flows      = "";
    $get_fac        = 0;

    if ((isset($_GET['lector'])) || (empty($_COOKIE["lector"])))
    {
        //setcookie("lector", $get_lector, time()+(31536000*5), "/");
        //setcookie("type", "lector", time()+(31536000*5), "/");

        if ((empty($_COOKIE["flow"])) || (empty($_COOKIE["grp"])) || (empty($_COOKIE["lsubgrp"])))
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

///////////////////////////////////////////////////////////////

if (isset($_GET['day']))
    $get_day = $_GET['day'];
else
    $get_day = "";

require_once($Inc_sys . "common.php");
require_once($Inc_sys . "db.php");
require_once($Inc_sys . "sd_stat.php");

///////////////////////////////////////////////СБОР ДАННЫХ И ПРОВЕРК НА ВШИВОСТЬ//////////////////////////////////////////////////////////

if (!$IsLector)
{
    $flows_q = mysqlold_query("SELECT gr_name,`gr_year-start`,`is_updating`,`latest_upd` FROM schedule_flows WHERE id_flow='" . $get_flows . "' LIMIT 1;");
    $flows_a = mysqlold_fetch_assoc($flows_q);

    if ($flows_a['is_updating'] == 1)
    {
        FatalErrorMessage("Извините, расписание в процессе обновления", "Пожалуйста, обновите страницу чуть позже<br>Если это сообщение долго не исчезает, " . "значит в процессе обновления произошёл сбой");

    }
}
else
{
    $lector_q = mysqlold_query("SELECT * FROM schedule_lectors WHERE id_lector='" . $get_lector . "' LIMIT 1;");
    $lector_a = mysqlold_fetch_assoc($lector_q);
}

//Семестры
//Семестры///////////////////////////////////////////////////////////////////////////////////////////////

if ($get_day == "")
{
    $query        = mysqlold_query("SELECT * FROM schedule_daycount ORDER BY dayend DESC LIMIT 1");
    $old_schedule = 0;
}
else
{
    $query        = mysqlold_query("SELECT * FROM schedule_daycount WHERE id_day=" . intval($get_day) . " ORDER BY dayend DESC LIMIT 1");
    $old_schedule = 1;
}

$daycounts = mysqlold_fetch_array($query);

if ($daycounts == NULL)
    FatalErrorMessage("Ошибка! - Семестр не найден", "Возможно, Вы указали несуществующий код семестра");

$id_day_1 = $daycounts['id_day'];

if ($old_schedule == 0)
{
    if (!$get_lector)
    {
        if (intval(mysqlold_result(mysqlold_query("SELECT count(*) FROM schedule__maindata WHERE id_day=" . $daycounts['id_day'] . " AND id_flow = " . intval($get_flows) . ";"), 0)) != 0)
        {
            $old_schedule   = 0;
            $old_schedule_2 = 0;
        }
        else
        {
            $query_2        = mysqlold_query("SELECT * FROM schedule_daycount WHERE id_day=" . ($daycounts['id_day'] - 1) . " ORDER BY dayend DESC LIMIT 1");
            $old_schedule   = 1;
            $old_schedule_2 = 1;
        }
    }
    else
    {
        if (intval(mysqlold_result(mysqlold_query("SELECT count(*) FROM schedule__maindata WHERE id_day=" . $daycounts['id_day'] . " AND id_lector = " . intval($get_lector) . ";"), 0)) != 0)
        {
            $old_schedule   = 0;
            $old_schedule_2 = 0;
        }
        else
        {
            $query_2        = mysqlold_query("SELECT * FROM schedule_daycount WHERE id_day=" . ($daycounts['id_day'] - 1) . " ORDER BY dayend DESC LIMIT 1");
            $old_schedule   = 1;
            $old_schedule_2 = 1;
        }
    }
}
else
    $old_schedule_2 = 0;

if ($old_schedule_2 == 1)
    $daycounts = mysqlold_fetch_assoc($query_2);


if ($daycounts == NULL)
    FatalErrorMessage("Ошибка! - Семестр не найден", "Возможно, Вы указали несуществующий код семестра");

$id_day_1 = $daycounts['id_day'];

//Семестры//END/////////////////////////////////////////////////////////////////////////////////////////////

if (!$get_lector)
{
    if ($flows_a == NULL)
        FatalErrorMessage("Ошибка! - Поток не найден", "Поток отсутсвует в базе данных<br>Откройте <a href=\"/d/chgr\">страницу выбора групп</a> и повторно выберите свою группу");
    //die("<h2 style=\"text-align: center;\">ПОТОК НЕ НАЙДЕН!</h2>");
}
else
{
    if ($lector_a == NULL)
        FatalErrorMessage("Ошибка! - Преподаватель не найден", "Преподаватель отсутсвует в базе данных");
    //die("<h2 style=\"text-align: center;\">ПРЕПОДАВАТЕЛЬ НЕ НАЙДЕН!</h2>");
}

$days = explode("-", $daycounts['daystart']);

if (!$get_lector)
{
    if (intval(mysqlold_result(mysqlold_query("SELECT count(*) FROM schedule__maindata WHERE id_day=" . $daycounts['id_day'] . " AND id_flow = " . intval($get_flows) . ";"), 0)) === 0)
        FatalErrorMessage("Ошибка! - Нет расписаний", "У выбранного потока нет расписаний");

    if (intval(mysqlold_result(mysqlold_query("SELECT count(*) FROM schedule__maindata WHERE id_day=" . $daycounts['id_day'] . " AND id_flow = " . intval($get_flows) . " AND id_group LIKE '%" . intval($get_groups) . "%';"), 0)) === 0)
        FatalErrorMessage("Ошибка! - Нет расписаний", "У выбранной группы нет расписаний");

}
else
{
    if (intval(mysqlold_result(mysqlold_query("SELECT count(*) FROM schedule__maindata WHERE id_day=" . $daycounts['id_day'] . " AND id_lector = " . intval($get_lector) . ";"), 0)) === 0)
        FatalErrorMessage("Ошибка! - Нет расписаний", "Отсутствуют расписания для преподавателя " . $lector_a['lcr_shtname']);
}


///////////////////////////////////////////////СБОР ДАННЫХ И ПРОВЕРКА НА ВШИВОСТЬ/END//////////////////////////////////////////////////////


///////////////////////////////////////ЗАПИСЬ КУК///////////////////////////////////////////////
if (!$IsLector)
{
    //////////////////////////////////////////////////////////////////////////////////////
    if (((isset($_GET['grp'])) && (isset($_GET['flow']))) || ((empty($_COOKIE["flow"])) || (empty($_COOKIE["grp"]))))
    {
        setcookie("fac", $get_fac, time() + (31536000 * 5), "/");
        setcookie("grp", $get_groups, time() + (31536000 * 5), "/");
        setcookie("flow", $get_flows, time() + (31536000 * 5), "/");
        setcookie("lsubgrp", $get_lsubgroups, time() + (31536000 * 5), "/");
        setcookie("esubgrp", $get_esubgroups, time() + (31536000 * 5), "/");
        setcookie("type", "student", time() + (31536000 * 5), "/");
    }
    //////////////////////////////////////////////////////////////////////////////////////
}
else
{
    if ((isset($_GET['lector'])) || (empty($_COOKIE["lector"])))
    {
        setcookie("lector", $get_lector, time() + (31536000 * 5), "/");
        setcookie("type", "lector", time() + (31536000 * 5), "/");

        if ((empty($_COOKIE["flow"])) || (empty($_COOKIE["grp"])) || (empty($_COOKIE["lsubgrp"])))
        {
            setcookie("fac", $get_fac, time() + (31536000 * 5), "/");
            setcookie("grp", $get_groups, time() + (31536000 * 5), "/");
            setcookie("flow", $get_flows, time() + (31536000 * 5), "/");
            setcookie("esubgrp", $get_esubgroups, time() + (31536000 * 5), "/");
            setcookie("lsubgrp", $get_esubgroups, time() + (31536000 * 5), "/");
        }
    }
}
///////////////////////////////////////ЗАПИСЬ КУК///END/////////////////////////////////////////



if (!$IsLector)
    $page_title = "Листочек на день " . $flows_a['gr_name'] . "-" . GrCourse($flows_a['gr_year-start'], $days[0], $days[1]) . "-" . $get_groups . (($get_lsubgroups > 2) ? ", подгруппа " . ($get_lsubgroups - 2) : "") . (($get_esubgroups != 0) ? ", ин-яз " . $get_esubgroups : "") . " - " . $SiteTitle;
else
    $page_title = "Листочек на день для преподавателя " . $lector_a['lcr_fullname'] . " - " . $SiteTitle;

if (!$IsLector)
    $SchedMenuBar = "" . $flows_a['gr_name'] . "-" . GrCourse($flows_a['gr_year-start'], $days[0], $days[1]) . "-" . $get_groups . (($get_lsubgroups > 2) ? " (" . ($get_lsubgroups - 2) . ")" : "") . (($get_esubgroups != 0) ? " (И/Я " . $get_esubgroups . ")" : "");
else
    $SchedMenuBar = $lector_a['lcr_shtname'];

@setcookie("sched_ttl", $SchedMenuBar, time() + (31536000 * 5), "/");

@setcookie("sched_type", "oneday", time() + (31536000 * 5), "/");


$fac_q  = mysqlold_query("SELECT * FROM schedule_facult ORDER BY fac_name");
$flow_q = mysqlold_query("SELECT * FROM schedule_flows");

//$page_title = "Листочек на сегодня - Расписания МГТУ ГА";

$IncludeToHead = '<link rel="stylesheet" type="text/css" href="/js/cal/tcal.css" >
<script type="text/javascript" src="/js/cal/tcal.js"></script>
';

require_once($Inc_sys . "html-fancybox_head.php");

require_once($Inc_sys . "html-header.php");
require_once($Inc_sys . "html-titlebar.php");
$menu = "full";
require_once("../_menu.php");

if (isset($_GET['ofdate']))
    $time = strtotime($_GET['ofdate']);
else
    $time = strtotime(date("Y-m-d"));
?>

<table style="float: right; margin: 0px; margin-right: 20px" cellpadding="0" cellspacing="0">
<tbody>
<tr>
<td nowrap="nowrap">
<a href="javascript://" onclick="alert('Для печати откройте пожалуйста развёрнутое расписание');">Версия для печати <img style="border-width: 0;" alt="Версия для печати" title="Версия для печати" src="/css/images/to_print.png"></a>
<?php
if (!$IsLector)
{
    if (file_exists("../excels/loaded/" . $flows_a['gr_name'] . " " . GrCourse($flows_a['gr_year-start'], $days[0], $days[1]) . "-" . $get_groups . ".xls"))
    {
?>
   <a href="<?= "/excels/loaded/" . urlencode($flows_a['gr_name']) . "%20" . GrCourse($flows_a['gr_year-start'], $days[0], $days[1]) . "-" . $get_groups . ".xls" ?>"><img style="border-width: 0;" alt="Скачать оригинальный Excel-файл" title="Скачать оригинальный Excel-файл" src="/css/images/excel.png"></a>
    <?php
    }
}
?>
</td>
</tr>
</tbody>
</table>
<?php
$weekday = 0;
$couples = 0;

$weekNumber = ((int)date("W", $time)) - 1;
$couples = (int)(($weekNumber & 1) xor $daycounts['couples']);
//$couples = (int)((((int)date("W", $time)) & 1) xor !$daycounts['couples']);

?>
<?php
//    $time += 24*60*60;    // секунд в одном дне
//    if(date("w", $time)==1)
//    $couples = !$couples;
//    }
?>
<?php
//////////////////////////ВЗЯТИЕ ДАННЫХ НА СЕГОДНЯ///////////////////////////////////////////
if (!$get_lector)
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
id_day=" . $id_day_1 . "
AND id_flow='" . $get_flows . "'
AND (((id_subgrp='" . $get_lsubgroups . "' OR id_subgrp='" . $get_esubgroups . "') AND issubgrp=1) OR issubgrp=0)
AND id_group LIKE '%" . $get_groups . "%'
AND WEEKDAY=" . date('w', $time) . "
AND (
(onlydays LIKE '%" . date('Y-m-d', $time) . "%')
OR
((STR_TO_DATE('" . date('Y-m-d', $time) . "', '%Y-%m-%d') BETWEEN `period-start` AND `period-end`)
  AND (exceptions IS NULL OR (exceptions NOT LIKE '%" . date('Y-m-d', $time) . "%')))
)
AND ((couples=0) OR ((couples=1 AND " . (int) $couples . ") OR (couples=2 AND " . (int) (!$couples) . ")))
ORDER BY lection, `change` desc, `onlydays` desc;";

else
    $DayQuery = "SELECT * FROM
schedule__maindata,
schedule_disciplyne,
schedule_lectors,
schedule_rooms,
schedule_ltype,
schedule_flows

WHERE

        schedule__maindata.id_disciplyne=schedule_disciplyne.id_disciplyne
        AND schedule__maindata.id_lector=schedule_lectors.id_lector
        AND schedule__maindata.id_flow=schedule_flows.id_flow
        AND schedule__maindata.id_room=schedule_rooms.id_room
        AND schedule__maindata.id_ltype=schedule_ltype.id_ltype

AND
id_day=" . $id_day_1 . "
AND schedule__maindata.id_lector='" . $get_lector . "'
AND WEEKDAY=" . date('w', $time) . "
AND (
(onlydays LIKE '%" . date('Y-m-d', $time) . "%')
OR
((STR_TO_DATE('" . date('Y-m-d', $time) . "', '%Y-%m-%d') BETWEEN `period-start` AND `period-end`)
  AND (exceptions IS NULL OR (exceptions NOT LIKE '%" . date('Y-m-d', $time) . "%')))
)
AND ((couples=0) OR ((couples=1 AND " . (int) $couples . ") OR (couples=2 AND " . (int) (!$couples) . ")))
ORDER BY lection,`change` desc, `onlydays` desc, gr_name, id_group;";
//////////////////////////ВЗЯТИЕ ДАННЫХ НА СЕГОДНЯ///////////////////////////////////////////


$DayOfWeek_A = array();
$DwC         = 0;
$DayOfWeek_Q = mysqlold_query($DayQuery);
if (!$DayOfWeek_Q)
    die(mysqlold_error());

if (isset($_GET['debug']))
{
    echo '<!--
' . $DayQuery . '
--->';
}

while ($DayOfWeek_A[$DwC] = mysqlold_fetch_assoc($DayOfWeek_Q))
    $DwC++;

$LectionsToday_Q = 0;
$LectionNumber   = 0;
for ($i = 0; $i < $DwC; $i++)
{
    if ($i == 0)
    {
        $LectionNumber   = $DayOfWeek_A[$i]['lection'];
        //echo $LectionsToday_Q." + ";
        $LectionsToday_Q = $LectionsToday_Q + intval($DayOfWeek_A[$i]['diration']);
        //echo intval($DayOfWeek_A[$i]['diration'])." = ".$LectionsToday_Q;
    }
    else
    {
        if ($LectionNumber != $DayOfWeek_A[$i]['lection'])
        {
            //echo " ".$LectionsToday_Q." + ";
            $LectionsToday_Q = $LectionsToday_Q + intval($DayOfWeek_A[$i]['diration']);
            $LectionNumber   = $DayOfWeek_A[$i]['lection'];
            //echo intval($DayOfWeek_A[$i]['diration'])." = ".$LectionsToday_Q;
        }
    }
}



$counter = 1;

if (!$get_lector)
    echo "<a href='/d/full?fac=" . $get_fac . "&amp;flow=" . $get_flows . "&amp;grp=" . $get_groups . "&amp;lsubgrp=" . $get_lsubgroups . "&amp;esubgrp=" . $get_esubgroups . "'>Развёрнутое расписание</a>";
else
    echo "<a href='/d/full?lector=" . $get_lector . "'>Развёрнутое расписание</a>";

if (!$IsLector)
{
    echo " • <a href='/d/chgr'>Другая группа</a>";
    echo " • <a class=\"textfile fancybox.iframe\" href=\"/d/getlinks.php?flow=" . $get_flows . "\">Скопировать ссылки</a>";
}
else
    echo " • <a href='/d/chlcr'>Другой преподаватель</a>";

echo "<br>\n";

?>
<br>
<center>
<?php
if (!$get_lector)
{
    echo "<input style=\"width: 30px; height: 30px;\" type=button onclick=\"location.href='?fac=" . $get_fac . "&amp;flow=" . $get_flows . "&amp;grp=" . $get_groups . "&amp;lsubgrp=" . $get_lsubgroups . "&amp;esubgrp=" . $get_esubgroups . "&amp;ofdate=" . date("Y-m-d", $time - 24 * 60 * 60) . "';\" value=\"<<\">";
    echo ((date("Y-m-d") != date("Y-m-d", $time)) ? "<input style=\"width: 160px; height: 30px;\" type=button onclick=\"location.href='?fac=" . $get_fac . "&amp;flow=" . $get_flows . "&amp;grp=" . $get_groups . "&amp;lsubgrp=" . $get_lsubgroups . "&amp;esubgrp=" . $get_esubgroups . "';\" value=\"Перейти к сегодня\">" : "<input style=\"width: 160px; height: 30px;\" disabled=\"disabled\" type=button value=\"Перейти к сегодня\">");
    echo "<input style=\"width: 30px; height: 30px;\" type=button onclick=\"location.href='?fac=" . $get_fac . "&amp;flow=" . $get_flows . "&amp;grp=" . $get_groups . "&amp;lsubgrp=" . $get_lsubgroups . "&amp;esubgrp=" . $get_esubgroups . "&amp;ofdate=" . date("Y-m-d", $time + 24 * 60 * 60) . "';\" value=\">>\">";
}
else
{
    echo "<input style=\"width: 30px; height: 30px;\" type=button onclick=\"location.href='?lector=" . $get_lector . "&amp;ofdate=" . date("Y-m-d", $time - 24 * 60 * 60) . "';\" value=\"<<\">";
    echo ((date("Y-m-d") != date("Y-m-d", $time)) ? "<input style=\"width: 160px; height: 30px;\" type=button onclick=\"location.href='?lector=" . $get_lector . "';\" value=\"Перейти к сегодня\">" : "<input style=\"width: 160px; height: 30px;\" disabled=\"disabled\" type=button value=\"Перейти к сегодня\">");
    echo "<input style=\"width: 30px; height: 30px;\" type=button onclick=\"location.href='?lector=" . $get_lector . "&amp;ofdate=" . date("Y-m-d", $time + 24 * 60 * 60) . "';\" value=\">>\">";
}
?>
<br><input readonly="readonly" type="text" id="ofdate" name="ofdate" class="tcal" value="<?= date("Y-m-d", $time) ?>">
<?php
if (!$get_lector)
{
?><input id="go_to_day" onclick="<?= "location.href='?fac=" . $get_fac . "&amp;flow=" . $get_flows . "&amp;grp=" . $get_groups . "&amp;lsubgrp=" . $get_lsubgroups . "&amp;esubgrp=" . $get_esubgroups . "&amp;ofdate='+document.getElementById('ofdate').value;" ?>" type=button value="Go!"><?php
}
else
{
?><input id="go_to_day" onclick="<?= "location.href='?lector=" . $get_lector . "&amp;ofdate='+document.getElementById('ofdate').value;" ?>" type=button value="Go!"><?php
}
?>
<?php
echo "<br>" . (($couples) ? "Верхяя" : "Нижняя") . " неделя";
$LectionQuantity[0] = $LectionsToday_Q;
//if($LectionQuantity[0]>0)

//$time += 24*60*60
echo "<br><span style=\"font-size: 17pt;\">" . ((date("Y-m-d") == date("Y-m-d", $time)) ? "Сегодня" : ((((strtotime(date("Y-m-d", $time)) > strtotime(date("Y-m-d"))) && (strtotime(date("Y-m-d", $time)) <= strtotime(date("Y-m-d")) + 24 * 60 * 60))) ? "Завтра" . (($LectionQuantity[0] > 0) ? " будет" : "") . "" : ((((strtotime(date("Y-m-d", $time)) < strtotime(date("Y-m-d"))) && (strtotime(date("Y-m-d", $time)) >= strtotime(date("Y-m-d")) - 24 * 60 * 60))) ? "Вчера" . (($LectionQuantity[0] > 0) ? " было" : "") . "" : date("d", $time) . " " . monthName(date("m", $time))))) . (($LectionQuantity[0] > 0) ? " <b>" . $LectionQuantity[0] . "</b> пар" . (($LectionQuantity[0] == 1) ? "а" : ((($LectionQuantity[0] > 1) && ($LectionQuantity[0] < 5)) ? "ы" : "")) : "") . "</span>";


echo "<br><b>" . weekdaynFull(date("w", $time)) . "</b>";
?>
</center>
<table class="shadow" style="width: 700px; border-collapse: collapse; border: 1px solid #000000" align="center">

    <tr>
        <th class="tr_header" style="text-align: center; border: 1px solid #000000;" colspan="2">
        <?php
if (!$get_lector)
{
?>
       <?= $flows_a['gr_name'] ?>-<?= GrCourse($flows_a['gr_year-start'], $days[0], $days[1]) ?>-<?= $get_groups ?>
       <?= (($get_lsubgroups > 2) ? " подгруппа " . ($get_lsubgroups - 2) : "") ?><?php
}
else
    echo $lector_a['lcr_fullname'];
?> на <?php
echo date("d", $time) . " " . monthName(date("m", $time)) . " " . date("Y", $time);
?> <?php
echo weekdayn(date("w", $time));
?></th>
    </tr>


<?php
//while(($DayOfWeek = mysqlold_fetch_assoc($DayOfWeek_Q)))

$LectionNumber = 0;

for ($i = 0; $i < $DwC; $i++)
{

    if ($i == 0)
    {
        $LectionNumber = $DayOfWeek_A[$i]['lection'];
    }
    else if ($LectionNumber == $DayOfWeek_A[$i]['lection'])
        continue;

    if ($IsLector)
    {
        $Groups = "";
        for ($j = 0; $j < $DwC; $j++)
        {
            if ($DayOfWeek_A[$i]['lection'] == $DayOfWeek_A[$j]['lection'])
            {
                $Groups .= $DayOfWeek_A[$j]['gr_name'] . "-" . GrCourse($DayOfWeek_A[$j]['gr_year-start'], $days[0], $days[1]) . "-" . str_replace(" ", "/", $DayOfWeek_A[$j]['id_group']) . "(" . $DayOfWeek_A[$j]['gr_year-end'] . "); ";
            }
        }
    }

    if (!$get_lector)
        $LinkParams = "flow=" . $get_flows . "&amp;grp=" . $get_groups . "&amp;lsubgrp=" . $get_lsubgroups . "&amp;esubgrp=" . $get_esubgroups . "&amp;lection=" . $DayOfWeek_A[$i]['lection'] . "&amp;lection_id=" . $DayOfWeek_A[$i]['id'] . "&amp;date=" . date("Y-m-d", $time) . "";
    else
        $LinkParams = "lector=" . $get_lector . "&amp;lection=" . $DayOfWeek_A[$i]['lection'] . "&amp;lection_id=" . $DayOfWeek_A[$i]['id'] . "&amp;date=" . date("Y-m-d", $time) . "";
?>
       <tr  style="background-color: #FFFFFF; <?php
    echo colortime($DayOfWeek_A[$i]['lection'], date('Y-m-d', $time));
?>">
            <td class="<?php
    echo (($DayOfWeek_A[$i]['id_ltype'] == 1) ? "day_lection" : (($DayOfWeek_A[$i]['id_ltype'] == 2) ? "day_prctic" : (($DayOfWeek_A[$i]['id_ltype'] == 3) ? "day_labwork" : (($DayOfWeek_A[$i]['id_ltype'] == 4) ? "day_sport" : ""))));
?>" style="width: 70px; border: 1px solid #000000; text-align: center;<?php
    if ($DayOfWeek_A[$i]['change'] == 1)
        echo "background-image: url('/css/images/edititem.gif'); background-position: right top; background-repeat: no-repeat;";
?>">
            <strong><?php
    echo $DayOfWeek_A[$i]['lection'];
?> пара</strong><br><small><?php
    echo colortime($DayOfWeek_A[$i]['lection'], date('Y-m-d', $time), $diration = $DayOfWeek_A[$i]['diration'], $out = 'range');
?></small></td>
            <td style="border: 1px solid #000000">

    <?php
    echo "<a style=\"font-color: #000000\" class=\"textfile fancybox.iframe\" href=\"lection_info.php?" . $LinkParams . "\">";
?>
   <font color=black>
    <?php
    echo "<b>" . (($DayOfWeek_A[$i]['id_ltype'] > 4) ? "<u>" . $DayOfWeek_A[$i]['exam_time'] . "</u> " : "") . $DayOfWeek_A[$i]['dysc_name'] . "</b><br>";
    if (!$IsLector)
        echo "<small>" . $DayOfWeek_A[$i]['lcr_fullname'] . "</small><br>";
    else
        echo "<small>" . $Groups . "</small><br>";
    echo "<i><u>" . $DayOfWeek_A[$i]['room_number'] . "</u></i><br>";
    if ($DayOfWeek_A[$i]['id_ltype'] == 3)
        echo "<span style=\"background-color: #FF6600\">";
    echo "<i><u>" . $DayOfWeek_A[$i]['lt_name'] . "</u></i>";
    if ($DayOfWeek_A[$i]['id_ltype'] == 3)
        echo "</span>";
?>
   </font>
    <?php
    echo "</a>";
?>
   </td>
        </tr>

    <?php
    $LectionNumber = $DayOfWeek_A[$i]['lection'];
}

if (($LectionQuantity[0] <= 0) && ($time >= strtotime($daycounts['daystart'])) && ($time <= strtotime($daycounts['dayend'])))
{
    if (date("w", $time) == 0)
    {
?>
<tr style="">
<td class="" style="background-color: #FFFFFF; color:FF0000; width: 70px; height: 150px; valign: middle; border: 1px solid #000000; text-align: center;" colspan="2">
<strong>Воскресение, выходной</strong>
</td>
</tr>
<?php
    }
    else
    {
?>
<tr style="">
<td class="" style="background-color: #FFFFFF; width: 70px; height: 150px; valign: middle; border: 1px solid #000000; text-align: center;" colspan="2">
<strong>Пар нет, отдыхаем</strong>
</td>
</tr>
<?php
    }


}
else
{
    if (($time < strtotime($daycounts['daystart'])))
    {
?>
   <tr style="">
    <td class="" style="background-color: #FFFFFF; width: 70px; height: 150px; valign: middle; border: 1px solid #000000; text-align: center;" colspan="2">
    <strong style="font-size: 14pt; color: green;">Имеется новое расписание, занятия ещё не начались</strong>
    <?php
    }
    else if (($time > strtotime($daycounts['dayend'])))
    {
?>
   <tr style="">
    <td class="" style="background-color: #FFFFFF; width: 70px; height: 150px; valign: middle; border: 1px solid #000000; text-align: center;" colspan="2">
    <strong style="font-size: 14pt; color: #999999;">Расписание просрочено, новое пока не появилось</strong>
    <?php
    }
}

?>
</table>
<?php
if (!$get_lector)
    echo "<center><small>Обновление от: " . TextDate($flows_a['latest_upd']) . "</small></center>";

require_once($Inc_sys . "html-footer.php");

SetStatistics($SchedMenuBar, "PC_oneday");
?>
