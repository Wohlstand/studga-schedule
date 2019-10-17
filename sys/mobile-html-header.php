<?php
function httpprot()
{
	if(isset($_SERVER['HTTPS']))
    	echo "https";
	else
	    echo "http";
}
echo "<"."?xml version=\"1.0\" encoding=\"UTF-8\"?".">";
?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.2//EN" "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php if(isset($page_title)) echo $page_title; else echo "Главная страница"; ?></title>
<link rel="stylesheet" href="/css/style_mobile.css" type="text/css" />
<link rel="shortcut icon" href="/css/images/mstuca_professor.png" type="image/png" />
<link rel="stylesheet" href="/css/nav.css" type="text/css" />

<link rel="Bookmark" href="http://studga.ru/favicon.ico" />
<link rel="Shortcut Icon" href="http://studga.ru/favicon.ico" type="image/x-icon" />
<?
if(isset($IncludeToHead))
    echo $IncludeToHead;
?>
</head>
<body>
