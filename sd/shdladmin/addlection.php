<?php
require_once("../../sys/db.php");

$day_q = mysqlold_query("SELECT * from schedule_daycount ORDER BY `desc` DESC");
$disciplyne_q = mysqlold_query("SELECT * from schedule_disciplyne ORDER BY dysc_name");
$lectors_q = mysqlold_query("SELECT * from schedule_lectors ORDER BY lcr_fullname");
$ltype_q = mysqlold_query("SELECT * from schedule_ltype");
$rooms_q = mysqlold_query("SELECT * from schedule_rooms ORDER BY id_house,room_number");
$groups_q = mysqlold_query("SELECT * from schedule_flows ORDER BY gr_name, `gr_year-start`");
$subgroups_q = mysqlold_query("SELECT * from schedule_subgroups");
?>

<form name="maindata" action="action.php" method="post">

<table style="width: 701px; border-collapse: collapse" align="center">
	<tr>
		<td>
		<strong>Семестр</strong><br>
<select name="day" style="height: 21px">
<?php
while(($day=mysqlold_fetch_array($day_q))!=NULL)
{
    echo "<option value=\"".$day['id_day']."\">".$day['desc']."</oprion>\n";
}
?>
</select></td>
		<td>
		<strong>Номер пары</strong><br>
<select name="lection">
<option>1</option>
<option>2</option>
<option>3</option>
<option>4</option>
<option>5</option>
<option>6</option>
<option>7</option>
</select></td>
		<td>
		<strong>День недели</strong><span lang="en-us">:<br>
</span><select name="weekday">
<option value="1">Понедельник</option>
<option value="2">Вторник</option>
<option value="3">Среда</option>
<option value="4">Четверг</option>
<option value="5">Пятница</option>
<option value="6">Суббота</option>
<option value="0">Воскресенье</option>
</select></td>
		<td style="width: 349px">&nbsp;</td>
	</tr>
	<tr>
		<td valign="top" colspan="3">
<p><strong>Дисциплина</strong><br>
	<select name="disciplyne">
	<?php
	while(($disciplyne=mysqlold_fetch_array($disciplyne_q))!=NULL)
	{
    	echo "<option value=\"".$disciplyne['id_disciplyne']."\">".$disciplyne['dysc_name']."</oprion>\n";
	}
	?>
	</select>
</p>
<p><span lang="ru"><strong>Преподаватель</strong><br>
</span><select name="lector">
	<?php
	while(($lector=mysqlold_fetch_array($lectors_q))!=NULL)
	{
	    echo "<option value=\"".$lector['id_lector']."\">".$lector['lcr_fullname']."</oprion>\n";
	}
	?>
</select></p>
<p><strong>Номер аудитории</strong><br>
<select name="room">
	<?php
	while(($room=mysqlold_fetch_array($rooms_q))!=NULL)
	{
	    echo "<option value=\"".$room['id_room']."\">".$room['room_number']."</oprion>\n";
	}
	?>
</select></p>
<p><strong>Тип занятия</strong><br>
<select name="ltype">
	<?php
	while(($ltype=mysqlold_fetch_array($ltype_q))!=NULL)
	{
	    echo "<option value=\"".$ltype['id_ltype']."\">".$ltype['lt_name']."</oprion>\n";
	}
	?>
</select></p>
<p>Вермя зачёта/экзамена<br>
<input id="examtime" name="examtime" type="text" style="width: 55px"></p>
</td>
		<td valign="top" style="width: 349px">
<p><span lang="ru"><strong>Группы</strong></span>:<br>
Поток
<select name="flow">
	<?php
	while(($groups=mysqlold_fetch_array($groups_q))!=NULL)
	{
	    echo "<option value=\"".$groups['id_flow']."\">".$groups['gr_name']." ".$groups['gr_year-start']."-".$groups['gr_year-end']."</oprion>\n";
	}
	?>
</select><br>
<input name="groups" type="radio" value="1 2">Обе группы<br>
<input name="groups" type="radio" value="1">Только первая<br>
<input name="groups" type="radio" value="2">Только вторая
</p>
<p><input onclick="if(this.checked==checked) document.getElementById('subgrp').disabled=''; else document.getElementById('subgrp').disabled='disabled';" name="issubgrp" type="checkbox" style="height: 20px" value="1">Подгруппы
<select disabled="disabled" id="subgrp" name="subgrp">
<option></option>
	<?php
	while(($subgroups=mysqlold_fetch_array($subgroups_q))!=NULL)
	{
	    echo "<option value=\"".$subgroups['id_subgroup']."\">".(($subgroups['sgr_type']=="L")?"Лабораторная ".$subgroups['sgr_number']:"Английская ".(($subgroups['sgr_number']==1)?"продолжающая":"начинающая"))."</oprion>\n";
	}
	?>
</select></p>
		</td>
	</tr>
	<tr>
		<td valign="top" colspan="3">
<p><strong>Повторять</strong><span lang="en-us">:</span></p>
<p>
<input onclick="document.getElementById('onlydate').disabled='disabled';document.getElementById('period1').disabled='';document.getElementById('period2').disabled='';document.getElementById('period3').disabled='';" name="dates" type="radio" style="width: 20px; height: 20px" value="period" id="period" checked=""><label for="period"><strong>Периодически</strong></label><br>
Дата начала<input id="period1" name="periodstart" type="text"><br>
Дата окончания<input id="period2" name="periodend" type="text"></p>
<p>Кроме дат<span lang="en-us">:</span><input id="period3" name="exceptions" type="text" style="width: 491px"></p>
</td>
		<td valign="top" style="width: 349px" rowspan="2">
<p><strong>Длительность занятия</strong><br>
<select name="diration" style="height: 21px">
<option>1</option>
<option>2</option>
<option>3</option>
<option>4</option>
<option>5</option>
<option>6</option>
<option>7</option>
</select></p>
<p><strong>Чётность</strong><span lang="en-us">:<br>
</span><select name="couples">
<option value="0">Любая</option>
<option value="1">Только верхняя</option>
<option value="2">Только нижняя</option>
</select></p>
		</td>
	</tr>
	<tr>
		<td valign="top" colspan="3">
<input  onclick="document.getElementById('onlydate').disabled='';document.getElementById('period1').disabled='disabled';document.getElementById('period2').disabled='disabled';document.getElementById('period3').disabled='disabled';" name="dates" type="radio" value="onlydays" id="onlydays"><label for="onlydays"><strong>Только в определённые дни</strong></label><span lang="en-us">:<br>
</span>
<input disabled="disabled" id="onlydate" name="only_dates" type="text" style="width: 490px"></td>
	</tr>
	<tr>
		<td valign="top" colspan="3"><strong>Причина внесения поправки:</strong><br>
		<input name="change_reason" style="width: 511px" type="text"></td>
		<td valign="top" style="width: 349px">&nbsp;</td>
	</tr>
	<tr>
		<td style="text-align: center" colspan="3">&nbsp;</td>
		<td style="width: 349px">&nbsp;</td>
	</tr>
	<tr>
		<td style="text-align: center" colspan="3"><input name="Submit1" type="submit" value="Сохранить"></td>
		<td style="width: 349px">&nbsp;</td>
	</tr>
</table>
</form>


