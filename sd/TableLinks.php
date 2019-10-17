<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Список ссылок</title>
</head>
<?php

require_once("../sys/db.php");

$readonly = false;

$isLocalHost = false;
//$isLocalHost = strstr($_SERVER['REMOTE_ADDR'], "127.0.0.1");

if(!$isLocalHost &&
   !strstr($_SERVER['REMOTE_ADDR'], "172.16.") &&
   !strstr($_SERVER['REMOTE_ADDR'], "2001:470:1f15:942:") &&
   !strstr($_SERVER['REMOTE_ADDR'], "87.229.194.178"))
{
	$readonly = true;
	//echo "<body>Ты ошибся страницей, курица!</body></html>";
	//exit;
}

if(!$readonly)
{
	if(isset($_POST['link']))
	{
		echo "Вставляем ссыль";
		if(isset($_POST['doCode']))
			$Values1 = str_replace("%28", "(", str_replace("%29", ")", str_replace("+", "%20", str_replace("%3A", ":", str_replace("%2F", "/", urlencode($_POST['link']))))));
		else
			$Values1 = $_POST['link'];

		$Values2 = $_POST['synonym'];

		mysqlold_query("INSERT INTO schedule_links (`link`,`synonym`) values('".$Values1."', '".$Values2."');");
	};

	if(isset($_GET['DelLink']))
	{
		echo "Удаляем ссыль";
		mysqlold_query("DELETE FROM schedule_links WHERE id=".$_GET['DelLink'].";");
	}
}

?>


<body>
<div>
<?php
if(!$readonly)
{
?>
<form method="post" action="TableLinks.php">
	<input name="link" style="width: 100%" type="text" value="<?=((isset($_POST['link']))? $_POST['link'] : "")?>" /><br/>
	Синоним: <input name="synonym" style="width: 150px" type="text" value="<?=((isset($_POST['synonym'])) ? $_POST['synonym']:"") ?>" />
	<input <?=( (isset($_POST['doCode'])) ? "checked " : "") ?>type="checkbox" value="1" name="doCode">Кодируем<br />
	<input name="send" style="width: 130px" type="submit" value="Добавить ссыль" />
</form>
<?php
}
else
{
    echo "<small>Ваш IP-адрес " . $_SERVER['REMOTE_ADDR'] . "</small>";
}
?>
</div>

<div>
<table style="width: 682px">
<?php
	$files_q = mysqlold_query("SELECT `link`,id,synonym FROM schedule_links ORDER by `link`;");

	while(($files = mysqlold_fetch_array($files_q))!=NULL)
	{
	//mysqlold_query("UPDATE schedule_links SET `link`='".str_replace("%28", "(", str_replace("%29", ")", str_replace("+", "%20", $files['link'])))."' WHERE `link`='".$files['link']."';");
	?>
	<tr>
		<td><?=urldecode($files['id'])?></td>
		<td style="width: 536px; white-space: nowrap"><a href="<?=$files['link']?>"><?=urldecode($files['link'])?></a><?=(($files['synonym'])?" <b>[".$files['synonym']."]</b>":"")?><?php
		if(!$readonly)
		{
			?> <a href="?DelLink=<?=$files['id']?>">[x]</a> <?php } ?></td>
		</tr>
		<?php
	} ?>
</table>
</div>

</body>

</html>
