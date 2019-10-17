<?php
require "../config.php";
require_once("../../sys/db.php");
require_once("../../sys/sd_stat.php");

if(isset($_GET['page']) && ($_GET['page'])!="")
$page = $_GET['page'];
else
$page = '';

$pagedata = mysqlold_fetch_assoc(mysqlold_query("SELECT * FROM pages WHERE book='about' ".(($page != '')?"AND page_name='".$page."'":"")." ORDER BY main DESC LIMIT 1;"));

if($pagedata==NULL)
{
    $pagedata = array('page_name'=>'error','page_title' => 'Страница не найдена!', 'page_data' => '<h1>Такой страницы нет</h1>');
    header("HTTP/1.0 404 Not Found");
}

if($page=='')
{
    $page = $pagedata['page_name'];
}

function ListPages($HeadPage, $Cnt=0)
{
global $page;
	$PageLinks_q = mysqlold_query("SELECT * FROM pages WHERE section='".$HeadPage."' ORDER BY mass");
	while(($PL = mysqlold_fetch_assoc($PageLinks_q))!=NULL)
	{
    	for($i=0; $i<$Cnt; $i++)
	        echo "&nbsp;&nbsp;&nbsp;&nbsp;";
    	switch($PL['page_name'])
		{
		case "<line>":
		    echo '<div style="margin:0px auto; height:1px; width: 98%; background-color: #000000; border-width: 1px;"></div>'."\n"; break;
		    case "<space>":
		    echo '<br>'."\n";
		    break;
		default:
		    echo '<a '.(($PL['page_name']!=$page)?'href="'.(($PL['main'])?"./":$PL['page_name']).'"':"style=\"color: green;\"").'>'.$PL['page_title'].'</a>';
		    echo "<br>\n";
		    ListPages($PL['page_name'], $Cnt+1);
		}
	}
}

$IncludeToHead = '<link rel="canonical" href="http://sd.mstuca.su/">
';

$page_title = $pagedata['page_title']." - ".$SiteTitle;
$menu = "about";
require_once("../../sys/html-header.php");
require_once("../../sys/html-titlebar.php");
require_once("../_menu.php");

?>

<br><br>

<table align="center" style="border-collapse: collapse; ">
	<tr>
		<td style="padding: 0px; margin: 0px; width: 171; white-space: nowrap; text-align: left;" valign="top">
		<?php
		ListPages("about");
		?>
		</td>
		<td style="background-position: left top; padding: 0px; margin: 0px; text-align: center; width: 10px; background-image: url('/sysimage/images/black_hline.GIF'); background-repeat: repeat-y;"></td>
		<td style="width: 710px;">
<?php
echo "<h1>".$pagedata['page_title']."</h1>";
?>
		<?php eval("?>".str_replace("/>",">",$pagedata['page_data']));?>
		</td>
	</tr>
</table>

<?php
require_once("../../sys/html-footer.php");
SetStatistics($pagedata['page_title'], "PC_info");
?>

