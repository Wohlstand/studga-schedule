<?php
require "config.php";

$IncludeToHead = '
<META NAME="DESCRIPTION" CONTENT="Расписания занятий Московского Государственного Технического Университета Гражданской Авиации">
<META NAME="keywords" CONTENT="Расписание, МГТУ ГА, МГТУГА, студентов, расписания МГТУГА, расписания МГТУ ГА, расписание МГТУГА,  расписание МГТУ ГА">
';

$page_title = "Расписания студентов - ".$SiteTitle;
$Inc_sys = "../sys/";
require_once($Inc_sys."html-fancybox_head.php");
require_once($Inc_sys."html-header.php");
require_once($Inc_sys."html-titlebar.php");
require_once("_menu.php");

require_once("../sys/db.php");

$fac_q = mysqlold_query("SELECT * FROM schedule_facult ORDER BY fac_name");
//$flow_q = mysqlold_query("SELECT * FROM schedule_flows ORDER BY gr_name,`gr_year-start`");


if(!empty($_COOKIE['fac']))
$get_fac = $_COOKIE['fac'];
else
$get_fac = NULL;

?>
<script type="text/javascript" src="/js/get_data.js"></script>

<h1>Студенту</h1>

<form method="get" onsubmit="return CheckForm();" name="getSchedule" action="test.php">
<table style="width: 100%; border-collapse: collapse; margin-left: auto; margin-right: auto;">
<caption><span lang="ru"><b>Пожалуйста, выберите</b></span>:</caption>
		<tr>
			<tr>
				<td style="text-align: center" colspan="2">&nbsp;</td>
			</tr>
			<td style="text-align: right; width: 50%"><span lang="ru">Факультет</span></td>
			<td style="text-align: left">
			<select onchange="getFlows(this.value);" id="fac" name="fac" style=" width: 233px;">
			<option value="">[Выберите]</option>
			<?php
			while(($fac_a=mysqlold_fetch_assoc($fac_q)) != NULL)
			{
				echo "<option ". (
									($get_fac) ?
									 		( ($get_fac == $fac_a['id_facult'] ) ? "selected":"")
											 	:"")
												." value=\"".$fac_a['id_facult']."\">" . $fac_a['fac_name'] . " (".$fac_a['fac_name_s'].
												")</option>";
			}
			?>
			</select></td>
		</tr>
		<tr style="display: none;" id="tr_flow">
			<td style="text-align: right; width: 50%"><span lang="ru">Поток</span></td>
			<td style="text-align: left">
			<select onchange="getGroups(this.value);"  name="flow" id="flow" style="width: 233px;">
			<option value="">[Выберите]</option>
			<?php
			/*
			while(($flow_a=mysqlold_fetch_array($flow_q))!=NULL)
			{
			echo "<option value=\"".$flow_a['id_group']."\">".$flow_a['gr_name']." ".$flow_a['gr_year-start']."-".$flow_a['gr_year-end']."</option>";
			}
			*/
			?>
			</select></td>
		</tr>
		<tr style="display: none;" id="tr_flow_empty">
			<td style="text-align: right"></td>
			<td style="text-align: left">
			[Расписаний нет для выбранного факультета]
			</td>
		</tr>
		<tr id="tr_flow_nofac">
			<td style="text-align: right; height: 21px;"></td>
			<td style="text-align: left; height: 21px;">
			[Для начала, выберите факультет]
			</td>
		</tr>

		<tr style="display: none;" id="tr_group_noflow">
			<td style="text-align: right">&nbsp;</td>
			<td style="text-align: left">
			[Теперь выберите поток]</td>
		</tr>

		<tr style="display: none;" id="tr_group">
			<td style="text-align: right; width: 50%"><span lang="ru">Группа</span></td>
			<td style="text-align: left">
			<select onchange="document.getElementById('gr_error').innerHTML = '';" id="groups" name="grp" style=" width: 233px;">
			<option value="0">[Выберите]</option>
			<option value="1">Первая</option>
			<option value="2">Вторая</option>
			<option value="3">Третья</option>
			<option value="4">Четвёртая</option>
			<option value="5">Пятая</option>
			</select>
			<span style="color:#CC0000" id="gr_error"></span></td>
		</tr>

		<tr style="display: none;" id="tr_group_empty">
			<td style="text-align: right; height: 21px;"></td>
			<td style="text-align: left; height: 21px;">
			[Выбранный поток не имеет расписаний]</td>
		</tr>
		<tr style="display: none;" id="tr_lsubgrp">
			<td style="text-align: right; width: 50%"><span lang="ru">Подгруппа по
			лабораторным</span></td>
			<td style="text-align: left">
			<select onchange="document.getElementById('ls_error').innerHTML = '';" id="lsubgrp" name="lsubgrp" style="width: 233px;">
			<option value="0">[Выберите]</option>
			</select>
			<span style="color:#CC0000" id="ls_error"></span></td>
		</tr>
		<tr style="display: none;" id="tr_esubgrp">
			<td style="text-align: right; width: 50%"><span lang="ru">Подгруппа по
			иностранному языку</span></td>
			<td style="text-align: left; height: 24px;">
			<select onchange="document.getElementById('es_error').innerHTML = '';" id="esubgrp" name="esubgrp" style="width: 233px;">
			<option value="0">[Выберите]</option>
			</select>
			<span style="color:#CC0000" id="es_error"></span></td>
		</tr>
		<tr style="display: none;" id="tr_loading">
			<td style="text-align: right; height: 21px;"></td>
			<td style="text-align: left; height: 21px; color: green;">
			[Подождите, идёт загрузка...]</td>
		</tr>
		<tr>
			<td style="text-align: center" colspan="2">
			<br>
			<a class="textfile fancybox.iframe" href="/d/chgr_help.html"><img src="/sysimage/icons/help.gif" style="border: 0px;" alt="[help]">Помощь по выбору группы (в новом окне)</a><br><br>
			</td>
		</tr>
		<tr>
			<td style="text-align: center" colspan="2"></td>
		</tr>
	</table>
<div style="text-align:center;">
	<br>
		<input disabled="disabled" id="submit1" type="submit" value="Развёрнутое расписание" onclick="this.form.action = '/d/full';" style="width: 249px"><br>
		<input disabled="disabled" id="submit2" type="submit" value="Расписание на день" onclick="this.form.action = '/d/oneday';" style="width: 249px">
</div>
</form>
<div style="text-align: center"><span style="text-decoration: underline; font-size: 10pt;">Примечание:</span><br><span style="font-size: 10pt;">&nbsp;&nbsp; * развёрнутое расписание может открываться с небольшой задержкой</span></div>
<script type="text/javascript">
onLoad();
</script>

<?php
require_once($Inc_sys."html-footer.php");
?>
