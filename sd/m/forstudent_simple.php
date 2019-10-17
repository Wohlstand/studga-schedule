<?
$Inc_sys = "../../sys/";
require_once($Inc_sys."db.php");

$fac_q = mysqlold_query("SELECT * FROM schedule_facult ORDER BY fac_name");
$flow_q = mysqlold_query("SELECT * FROM schedule_flows ORDER BY gr_name,`gr_year-start`");


$page_title = "Листочек на сегодня - Расписания МГТУ ГА";
require_once($Inc_sys."mobile-html-header.php");
require_once($Inc_sys."mobile-html-titlebar.php");
$menu = "chgr";
require_once("../_menu_m.php");

if(!empty($_COOKIE['fac']))
$get_fac = $_COOKIE['fac'];
else
$get_fac = NULL;

?>
<script type="text/javascript" src="/js/get_data.js"></script>

<div style="text-align: center">

<h1 style="text-aling: center;">Листочек на день</h1>
<?php echo "<div class=\"oneday_card\">";?>
<form id="getSchedule" onsubmit="return CheckForm();" method="get" action="/m/SetSchedule.php">
	<table style="width: 100%; border-collapse: collapse">
		<tr>
			<td style="text-align: center; height: 17px" colspan="2">
			Пожалуйста, выберите:</td>
		</tr>
		<tr>
			<td style="text-align: center">Факультет<br/>
			<select id="fac" name="fac" style="width: 90%; font-size: 14pt;">
			<option value="">[Выберите]</option>
			<?php
			while(($fac_a=mysqlold_fetch_assoc($fac_q))!=NULL)
			{
			echo "<option ".(($get_fac)? (($get_fac==$fac_a['id_facult'])?"selected":"") :"")." value=\"".$fac_a['id_facult']."\">".$fac_a['fac_name_s']."</option>";
			}
			?>
			</select></td>
		</tr>
		<tr id="tr_flow">
			<td style="text-align: center">
			Поток<br/>
			<select name="flow" id="flow" style="width: 90%; font-size: 14pt;">
			<option value="">[Выберите]</option>
			<?php
			while(($flow_a=mysqlold_fetch_assoc($flow_q))!=NULL)
			{
			    echo "<option value=\"".$flow_a['id_flow']."\">".$flow_a['gr_name']." ".$flow_a['gr_year-start']."-".$flow_a['gr_year-end']."</option>";
			}
			?>
			</select></td>
		</tr>

		<tr id="tr_group">
			<td style="text-align: center">
			Группа<br/>
			<select onchange="document.getElementById('gr_error').innerHTML = '';" id="groups" name="grp" style="width: 90%; font-size: 14pt;">
			<option value="0">[Выберите]</option>
			<option value="1">Первая</option>
			<option value="2">Вторая</option>
			<option value="3">Третья</option>
			<option value="4">Четвёртая</option>
			<option value="5">Пятая</option>
			</select><br/>&nbsp;<span style="color:#CC0000" id="gr_error"></span></td>
		</tr>

		<tr id="tr_lsubgrp">
			<td style="text-align: center">
			Подгруппа по лабораторным<br/>
			<select onchange="document.getElementById('ls_error').innerHTML = '';" id="lsubgrp" name="lsubgrp" style="width: 90%; font-size: 14pt;">
			<option value="0">[Выберите]</option>
			<option value="1">Первая</option>
			<option value="2">Вторая</option>
			<option value="3">Третья</option>
			<option value="4">Четвёртая</option>
			<option value="5">Пятая</option>
			</select><br/><label><input type="checkbox" name="nolsub" value="1"/>Отсутствует</label>
			<br/>&nbsp;<span style="color:#CC0000" id="ls_error"></span></td>
		</tr>
		<tr id="tr_esubgrp">
			<td style="text-align: center; height: 24px;">
			Подгруппа по
			иностранному языку<br/>
			<select onchange="document.getElementById('es_error').innerHTML = '';" id="esubgrp" name="esubgrp" style="width: 90%; font-size: 14pt;">
			<option value="0">[Выберите]</option>
			<option value="1">Первая</option>
			<option value="2">Вторая</option>
			<option value="3">Третья</option>
			<option value="4">Четвёртая</option>
			<option value="5">Пятая</option>
			</select><br/><label><input type="checkbox" name="noesub" value="1"/>Отсутствует</label>
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

<h2 style="text-align: center"><strong><em>Помощь по выбору группы:</em></strong></h2>
<table style="width: 100%; border-collapse: collapse; border: 1px solid #000000">
<caption>Факультеты</caption>
	<tr>
		<td style="padding: 0px; border: 1px solid #000000"><strong>Назв.ф.</strong></td>
		<td style="padding: 0px; border: 1px solid #000000; width: 206px;"><strong>Спец.</strong></td>
	</tr>
	<tr>
		<td style="padding: 0px; text-align: left; border: 1px solid #000000">
		М</td>
		<td style="padding: 0px; border: 1px solid #000000; width: 206px;">АБ, БТП, М, МГ, МБ, МАГ</td>
	</tr>
	<tr>
		<td style="padding: 0px; text-align: left; border: 1px solid #000000">
		ФАСК</td>
		<td style="padding: 0px; border: 1px solid #000000; width: 206px;">АК, РС, РТ, УВД</td>
	</tr>
	<tr>
		<td style="padding: 0px; text-align: left; border: 1px solid #000000">
		ФПМВТ</td>
		<td style="padding: 0px; border: 1px solid #000000; width: 206px;">БИ, ПМ, ЭВМ</td>
	</tr>
	<tr>
		<td style="padding: 0px; text-align: left; border: 1px solid #000000">
		ФУВТ</td>
		<td style="padding: 0px; border: 1px solid #000000; width: 206px;">ОП, СО, ЭК</td>
	</tr>
</table>

<p style="text-align: center">
<strong>Описание номера группы:</strong>
<a href="/css/images/chgr_help.png"><img style="border: 0px;" alt="Как выборать группу" src="/css/images/chgr_help_m.png" /><br/><small>увеличить</small></a></p>
<p style="text-align: left"><span style="color: #808000; font-size: large"><strong>Поток</strong></span> - группа студентов,
зачисленных в один и тот же год на одну и ту же специальность, потоки могут
делится на разные группы.</p>
<p style="text-align: left">В списке потоки указаны как:</p>
<p style="text-align: center">[<span style="color: #808000"><strong>ПОТОК </strong>
</span>-<span style="color: #008000"> <strong>КУРС&nbsp; </strong></span>&nbsp;<span style="color: #800080"><strong>ГОД_ЗАЧИСЛЕНИЯ
</strong></span>-<span style="color: #0000FF"><strong> ГОД_ВЫПУСКА</strong></span>]</p>
<p style="text-align: left">например "<strong>ЭВМ-3 2010-2015</strong>" - поток ЭВМ третьего курса,
зачисленные в 2010-м году, будут выпущены в 2015-м году.</p>
<p style="text-align: left"><em>В списке потоков используются специальные
пометки:</em><br />
<span style="font-family: 'Courier New', Courier, monospace"><strong>
<span style="font-size: small">*old*</span></strong><span style="font-size: small">&nbsp;&nbsp;&nbsp;&nbsp;
- просроченное расписание, чаще всего, на прошедший семестр</span></span><br style="font-family: 'Courier New', Courier, monospace; font-size: small;" />
<span style="font-family: 'Courier New', Courier, monospace"><strong>
<span style="font-size: small">*Empty*</span></strong><span style="font-size: small">&nbsp;&nbsp;
- расписание у потока отсутствует<br />
<br />
</span></span></p>
<p style="text-align: left"><strong>
<span style="font-size: large; color: #0000FF">Номер группы</span></strong> - Пример: Группа
ЭВМ-3-1 - это Первая группа потока ЭВМ-3, и ЭВМ-3-2 - Вторая.<br />
В какой конкретно группе будет учиться каждый студент потока - определяется
непосредственно на собрании первокурсников. Возможен перевод в другую группу в
пределах потока. Подробности об этом в деканате Вашего факультета.<br />
<br />
</p>
<p style="text-align: left"><strong>
<span style="font-size: large; color: #C3C305">Подгруппы</span></strong> - Для проведения
лабораторных работ группы делят на подгруппы.<br />
Так же, на занятиях по иностранному языку группу делят на "начинающих" и
"продолжающих" изучение иностранного языка.<br />
- В какой конкретно Вы будете подгруппе, определяется непосредственно перед
проведением первых лабораторных работ или на первом занятии по иностранному
языку. (обычно "первая" - это "начинающие", а "вторая" - "продолжающие", но
может быть и наоборот).<br />
- Если Вы не определены по подгруппам, то можете выбрать в списке любую
подгруппу и по определению Вас в подгруппу, вы выберетие именно свою подгруппу.<br />
- Или если не знаете, в какой конкретно подгруппе, уточните
номер Вашей подгруппы у старосты Вашей
группы.</p>

<?php
/*
<script type="text/javascript">
onLoad();
</script>
*/
echo "</div>";
require_once($Inc_sys."mobile-html-footer.php");
?>
