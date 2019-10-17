<?
require "../../sys/db.php";
require "admin_ip.php";

if(!empty($_GET['sortby']))
$sortby = $_GET['sortby'];
else
$sortby = "book_title";
$page_title = "Управление статьями - Расписания МГТУ ГА";
$sys_inc = "../../sys/";
$menu = "pages";
require $sys_inc."html-header.php";
require $sys_inc."html-titlebar.php";
require "_menu_admin.php";
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
<p class="style1"><span lang="ru"><a href="index.php">Назад</a>&nbsp;&nbsp;&nbsp;
<a href="/login/exit.php">Выход</a></span></p>


<p>&nbsp;</p>
<p style="text-align: center"><strong>Список разделов</strong></p>

<?
$query = mysqlold_query("SELECT * FROM pages_books ORDER BY ".$sortby);
?>

<table align="center" class="style2" cellspacing="1" cellpadding="3" style="width: 478px; border-style: solid">
				<tr>
								<th style="width: 32px; background-color: #C0C0C0;" class="style4"><strong>
								<a href="?sortby=id<?if($sortby=="id") echo "%20desc";?>">ID</a></strong></th>
								<th style="width: 116px; background-color: #C0C0C0;" class="style4"><span lang="ru">
								<strong><a href="?sortby=book_name<?if($sortby=="book_name") echo "%20desc";?>">Имя раздела</a></strong></span></th>
								<th style="width: 208px; background-color: #C0C0C0;" class="style4"><strong>
								<a href="?sortby=book_title<?if($sortby=="book_title") echo "%20desc";?>">Заголовок</a></strong></th>
								<th class="style4" style="width: 140px; background-color: #C0C0C0;"><span lang="ru">
								<strong>Действия</strong></span></th>

				</tr>

<?
$counter=0;
while(($users = mysqlold_fetch_array($query)))
{
?>
				<tr>
								<td style="width: 32px;" class="style6"><?=$users['id']?></td>
								<td style="width: 116px; white-space: nowrap;" class="style3"><b><?=$users['book_name']?></b></td>
								<td style="width: 208px;" class="style3">
								<?=$users['book_title']?></td>
								<td style="width: 140px;<? if(!$users['checked']) echo " color: red;"; ?>" class="style3">
								<a href="pages_articles.php?section=<?=$users['book_name']?>">
								<img alt="Статьи" title="Статус" src="/sysimage/icons/cat.gif" width="16" height="16" /></a>
								<a href="userprop.php?user=<?=$users['id']?>">
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

