<?
require "../../sys/db.php";
require "admin_ip.php";

if(!empty($_GET['sortby']))
    $sortby = $_GET['sortby'];
else
    $sortby = "section_title";
$page_title = "Управление статьями - Расписания МГТУ ГА";
$sys_inc = "../../sys/";
$menu = "pages";
require $sys_inc."html-header.php";
require $sys_inc."html-titlebar.php";
require "_menu_admin.php";

if(isset($_GET['id']))
    $page = $_GET['id'];
else
    $page = "<empty>";


if($page != "<empty>")
	$query = mysqlold_query("SELECT * FROM pages WHERE id=".$page." LIMIT 1");
else
	$NULLPAGE = 1;


$paged = mysqlold_fetch_array($query);

if($paged==NULL) $NULLPAGE = 1;

?>

<script type="text/javascript" src="/scripts/tiny_mce/tinymce.min.js"></script>
<script type="text/javascript" src="/scripts/tiny_mce_cnf_blog.js"></script>

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
<p class="style1"><span lang="ru"><a href="pages_articles.php?section=<?=((isset($paged['book'])) ? $paged['book'] : "")?>">Назад</a>&nbsp;&nbsp;&nbsp;


<p>&nbsp;</p>
<p style="text-align: center"><strong>Редактировать статью</strong></p>

<?
if(isset($NULLPAGE))
{
    echo "<h1>Страница не найдена</h1>";
    require $sys_inc."html-footer.php"; die();
}
?>

<form method="post" action="action.php">
<input name="id" type="hidden" value="<?=$paged['id']?>">
<input name="section" type="hidden" value="<?=$paged['book']?>">
<input name="action" type="hidden" value="edit_article">

<table align="center" style="border-collapse: collapse; width: 691px">
	<tr>
		<td style="text-align: right; width: 194px">Папка</td>
		<td>
		<input name="page_section" style="width: 354px" type="text" value="<?=$paged['section']?>"></td>
	</tr>
	<tr>
		<td style="text-align: right; width: 194px">Имя статьи</td>
		<td>
		<input name="page_name" style="width: 354px" type="text" value="<?=$paged['page_name']?>"></td>
	</tr>
	<tr>
		<td style="text-align: right; width: 194px">Заголовок статьи</td>
		<td>
		<input name="page_title" style="width: 354px" type="text" value="<?=$paged['page_title']?>"></td>
	</tr>
	<tr>
		<td style="text-align: right; width: 194px">&nbsp;</td>
		<td>
		&nbsp;</td>
	</tr>
	<tr>
		<td style="text-align: left; height: 367px;" colspan="2">
		<textarea id="page_data" class="page_data" name="page_data" style="width: 100%; height: 481px;"><?=htmlspecialchars($paged['page_data'])?></textarea></td>
	</tr>
	<tr>
		<td style="text-align: center; " colspan="2">
		<input name="Submit1" type="submit" value="Сохранить"></td>
	</tr>
</table>

</form>



<?require $sys_inc."html-footer.php";?>

