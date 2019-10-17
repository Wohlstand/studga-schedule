<?
require "../../sys/db.php";
require "admin_ip.php";

if(!empty($_GET['sortby']))
$sortby = $_GET['sortby'];
else
$sortby = "mass";
$page_title = "Управление статьями - Расписания МГТУ ГА";
$sys_inc = "../../sys/";
$menu = "pages";
require $sys_inc."html-header.php";
require $sys_inc."html-titlebar.php";
require "_menu_admin.php";

if(isset($_GET['section'])) $section = $_GET['section'];
else
$section = "<empty>";


function ArticType($pg_name)
{
	switch($pg_name)
	{
	case "<line>":
	return "---ЛИНИЯ---";
	case "<space>":
	return "---ПРОБЕЛ---";
	default:
	return $pg_name;
	}
}
?>


<style type="text/css">
.style1 {
				text-align: center;
}
.style2 {
				border-collapse: collapse;
				border: 1px solid #000000;
}
.style3 {
				border: 1px solid #000000;
}
.style4 {
				border: 1px solid #000000;
				text-align: center;
}
.style6 {
				border: 1px solid #000000;
				text-align: right;
}
</style>

<script>
function ServiceWindow(href)
{
newDomainWindow = window.open(href,"Сервис","toolbar=no,menubar=no,status=no,directories=no,resizable=no,scrollbars=no,top=200,left=200,width=510,height=300");
return false;
}
</script>

<h1 class="style1">Управление статьями</h1>
<p class="style1"><span lang="ru"><a href="pages.php">Назад</a>&nbsp;&nbsp;&nbsp;


<p>&nbsp;</p>
<p style="text-align: center"><strong>Список статей</strong></p>

<?php
$query = mysqlold_query("SELECT * FROM pages WHERE book='".$section."' ORDER BY ".$sortby);
?>

<table align="center" class="style2" cellspacing="1" cellpadding="3" style="width: 478px; border-style: solid">
				<tr>
								<th style="width: 32px; background-color: #C0C0C0; height: 27px;" class="style4"><strong>
								<a href="?sortby=id<? if($sortby=="id") echo "%20desc";?>&section=<?=$section?>">ID</a></strong></th>
								<th style="width: 32px; background-color: #C0C0C0; height: 27px;" class="style4"><strong>
								<a href="?sortby=mass<? if($sortby=="mass") echo "%20desc";?>&section=<?=$section?>">Вес</a></strong></th>
								<th style="width: 116px; background-color: #C0C0C0; height: 27px;" class="style4"><span lang="ru">
								<strong><a href="?sortby=page_name<? if($sortby=="page_name") echo "%20desc";?>&section=<?=$section?>">Имя статьи</a></strong></span></th>
								<th style="width: 208px; background-color: #C0C0C0; height: 27px;" class="style4"><strong>
								<a href="?sortby=page_title<? if($sortby=="page_title") echo "%20desc";?>&section=<?=$section?>">Заголовок</a></strong></th>
								<th class="style4" style="width: 140px; background-color: #C0C0C0; height: 27px;"><span lang="ru">
								<strong>Действия</strong></span></th>

				</tr>

<?
$counter=0;
while(($users = mysqlold_fetch_array($query)))
{
?>
				<tr>
								<td style="width: 32px;" class="style6"><?=$users['id']?></td>
								<td style="width: 32px;" class="style6"><?=$users['mass']?></td>
								<td style="width: 116px; white-space: nowrap;" class="style3"><b><?=ArticType($users['page_name'])?></b></td>
								<td style="width: 208px;" class="style3"><?=$users['page_title']?></td>
								<td style="width: 140px;<?if(!$users['checked'])echo " color: red;";?>" class="style3">

								<a href="pages_edit.php?id=<?=$users['id']?>&section=<?=$users['section']?>">
								<img alt="Правка" title="Изменить данные" src="/sysimage/icons/wps.gif" width="16" height="16" /></a>

								</td>

				</tr>
<?
$counter++;}
if(!$counter){?>
				<tr>
								<td style="color: red; text-align: center;" class="style6" colspan="4">
								<span lang="ru">В этом списке нет разделов</span></td>

				</tr>

<?}?>
</table>

<? require $sys_inc."html-footer.php"; ?>
