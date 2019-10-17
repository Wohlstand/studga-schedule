<?php
$Inc_sys = "../../sys/";
require_once($Inc_sys."db.php");

$lec_q = mysqlold_query("SELECT * FROM schedule_lectors WHERE id_lector!=0 ORDER BY lcr_fullname");


$page_title = "Листочек на сегодня - Расписания МГТУ ГА";
require_once($Inc_sys."mobile-html-header.php");
require_once($Inc_sys."mobile-html-titlebar.php");
$menu = "chgr";
require_once("../_menu_m.php");

?>
<script type="text/javascript" src="/js/get_data.js"></script>

<div style="text-align: center">

<h1 style="text-aling: center;">Листочек на день для преподавателя</h1>
<a href="/m/chgr">перейти к студенту</a><br/><br/>
<?="<div class=\"oneday_card\">"?>
<form id="getSchedule" onsubmit="return CheckForm();" method="get" action="/m/SetSchedule.php">
	<table style="width: 100%; border-collapse: collapse">
		<tr>
			<td style="text-align: center; height: 17px" colspan="2">
			Пожалуйста, выберите:</td>
		</tr>
		<tr>
			<td style="text-align: center">ФИО преподавателя<br/>
<select name="lector" style="width: 90%; font-size: 14pt;">
			<option value="">[выберите]</option>
			<?php
			while(($lec_a=mysqlold_fetch_assoc($lec_q))!=NULL)
			{
			    $IsEmptyLector = 0;
			    $old_schedule = 0;
			    $query_d = mysqlold_query("SELECT * FROM schedule_daycount ORDER BY dayend DESC LIMIT 1");
			    $daycounts = mysqlold_fetch_assoc($query_d);

			    if( intval(mysqlGetField("SELECT count(*) FROM schedule__maindata WHERE id_day=".$daycounts['id_day']." AND id_lector = ".$lec_a['id_lector'].";", 0)) != 0)
			    {
				    $old_schedule = 0;
			    }
			    else
			    {
				    $query_2 = mysqlold_query("SELECT * FROM schedule_daycount WHERE id_day=".($daycounts['id_day']-1)." ORDER BY dayend DESC LIMIT 1");
				    //echo "<h2 style=\"text-align: center;\">Старое расписание</h2>";
				    $old_schedule = 1;
			    }

			    if($old_schedule==1)
			    {
			        $daycounts = mysqlold_fetch_assoc($query_2);
			        if( intval(mysqlGetField("SELECT count(*) FROM schedule__maindata WHERE id_day=".$daycounts['id_day']." AND id_lector = ".$lec_a['id_lector'].";", 0)) == 0)
			        $IsEmptyLector = 1;
			    }
			    $days = explode("-", $daycounts['daystart']);

			    echo "<option ".((isset($_COOKIE['lector']))?(($_COOKIE['lector']==$lec_a['id_lector'])?"selected ":""):"")."value=\"".$lec_a['id_lector']."\">".$lec_a['lcr_fullname'].(($old_schedule==1)?((!$IsEmptyLector)?" *old*":" *Empty*"):"")."</option>";
			}
			?>
			</select>
			<br/>&nbsp;<span style="color:#CC0000" id="es_error"></span></td>
		</tr>
		<tr>
			<td style="text-align: center">
			<input type="submit" id="submit1" value="Вывести расписание на сегодня"/>
			<input style="display:none;" type="submit" id="submit2" name="submit2" value="Открыть расписание на сегодня"/>
			</td>
		</tr>
	</table>
</form>

</div>

<script type="text/javascript">
onLoad();
</script>
<?php
echo "</div>";
require_once($Inc_sys."mobile-html-footer.php");
?>
