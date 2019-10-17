<?php
function httpprot()
{
    if(isset($_SERVER['HTTPS']))
        echo "https";
    else
        echo "http";
}
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php if(isset($page_title)) echo $page_title; else echo "Главная страница";?></title>
<link rel="stylesheet" href="/css/style.css" type="text/css">
<link rel="stylesheet" href="/css/nav.css" type="text/css">
<link rel="Bookmark" href="/favicon.ico">
<link rel="image_src" href="/css/images/mstuca_professor.png">
<link rel="Shortcut Icon" href="/favicon.ico" type="image/x-icon">
<?php
if(isset($IncludeToHead))
    echo $IncludeToHead;
?>
<!--[if lte IE 9]><script src="/js/oldbrowser/oldies.js" charset="utf-8"></script><![endif]-->
</head>
<body>
<div class="container">
