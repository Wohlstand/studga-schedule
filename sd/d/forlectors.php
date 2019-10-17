<?php
require "../config.php";

$IncludeToHead = '
<META NAME="DESCRIPTION" CONTENT="Расписания занятий Московского Государственного Технического Университета Гражданской Авиации">
<META NAME="keywords" CONTENT="Расписание, МГТУ ГА, МГТУГА, преподавателей, расписания МГТУГА, расписания МГТУ ГА, расписание МГТУГА,  расписание МГТУ ГА">
';

$page_title = "Расписания преподавателей - " . $SiteTitle;
require_once("../../sys/html-header.php");
require_once("../../sys/html-titlebar.php");
require_once("../_menu.php");

require_once("../../sys/db.php");

$lec_q = mysqlold_query("SELECT * FROM schedule_lectors WHERE id_lector!=0 ORDER BY lcr_fullname");

?>

<h1>Преподавателю</h1>

<form method="get" action="/d/full">
    <table style="width: 100%; border-collapse: collapse">
        <tr>
            <td style="text-align: center; height: 17px" colspan="2">
            <span lang="ru">Пожалуйста, выберите</span>:</td>
        </tr>
        <tr>
            <td style="text-align: right; width: 50%"><span lang="ru">ФИО преподавателя</span></td>
            <td style="text-align: left"><select name="lector">
            <option value="">[выберите]</option>
            <?php
while (($lec_a = mysqlold_fetch_assoc($lec_q)) != NULL)
{
    $IsEmptyLector = 0;
    $old_schedule  = 0;
    $query_d       = mysqlold_query("SELECT * FROM schedule_daycount ORDER BY dayend DESC LIMIT 1");
    $daycounts     = mysqlold_fetch_assoc($query_d);

    if (intval(mysqlGetField("SELECT count(*) FROM schedule__maindata WHERE id_day=" . $daycounts['id_day'] . " AND id_lector = " . $lec_a['id_lector'] . ";", 0)) != 0)
    {
        $old_schedule = 0;
    }
    else
    {
        $query_2      = mysqlold_query("SELECT * FROM schedule_daycount WHERE id_day=" . ($daycounts['id_day'] - 1) . " ORDER BY dayend DESC LIMIT 1");
        //echo "<h2 style=\"text-align: center;\">Старое расписание</h2>";
        $old_schedule = 1;
    }

    if ($old_schedule == 1)
    {
        $daycounts = mysqlold_fetch_assoc($query_2);
        if (intval(mysqlGetField("SELECT count(*) FROM schedule__maindata WHERE id_day=" . $daycounts['id_day'] . " AND id_lector = " . $lec_a['id_lector'] . ";", 0)) == 0)
            $IsEmptyLector = 1;
    }
    $days = explode("-", $daycounts['daystart']);

    echo "<option " . ((isset($_COOKIE['lector'])) ? (($_COOKIE['lector'] == $lec_a['id_lector']) ? "selected " : "") : "") . "value=\"" . $lec_a['id_lector'] . "\">" . $lec_a['lcr_fullname'] . (($old_schedule == 1) ? ((!$IsEmptyLector) ? " *old*" : " *Empty*") : "") . "</option>";
}
?>
           </select></td>
        </tr>
        <tr>
            <td style="text-align: center" colspan="2">
        <input id="submit1" type="submit" value="Развёрнутое расписание" onclick="this.form.action = '/d/full';" style="width: 249px"><br>
        <input id="submit2" type="submit" value="Расписание на день" onclick="this.form.action = '/d/oneday';" style="width: 249px"></td>
        </tr>
    </table>
</form>


<?php
require_once("../../sys/html-footer.php");
?>
