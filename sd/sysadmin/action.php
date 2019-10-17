<?php
if(empty($_POST['action'])&&(empty($_GET['action'])))
exit();

if(!empty($_POST['action']))
$action = $_POST['action'];
if(!empty($_GET['action']))
$action = $_GET['action'];

function CenterWindow($text, $title)
{
echo "<html><head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
<title>".$title."</title>
</head>
<body>
<table style=\"width: 100%; border-collapse: collapse; height: 100%\" cellpadding=\"0\" align=\"center\">
	<tr>
		<td style=\"text-align: center\">";
echo $text;
echo "</td>
	</tr>
</table>
</body>
</html>";
}
require "../../sys/db.php";
require "admin_ip.php";

if($action=="edit_article")
{
	$id = $_POST['id'];
	$page_title = mysqlold_real_escape_string($_POST['page_title']);
	$page_section = mysqlold_real_escape_string($_POST['page_section']);
	$page_name = mysqlold_real_escape_string($_POST['page_name']);
	$page_data = $_POST['page_data'];
	$page_data = mysqlold_real_escape_string($page_data);
	//$page_data = str_replace(" />", ">", $_POST['page_data']);
	//$page_data = str_replace("/>", ">", mysqlold_real_escape_string($page_data));

 mysqlold_query("UPDATE pages SET page_title='".$page_title."', section='".$page_section."', page_name='".$page_name."', page_data='".$page_data."' WHERE id=".$id.";");

header("Location: pages_articles.php?section=".$_POST['section']);
	exit;
}


