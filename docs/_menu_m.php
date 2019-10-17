<?php
if(!isset($menu))
$menu = "";

function activemenu($item)
{
    global $menu;
    if($menu==$item) echo "class=\"active\"";
}
?>
<table id="menutable" style="border-collapse:collapse; padding:0px; width: 100%; border: 0;">
<tr>
<td style="padding: 0px; width: 100%; text-align: left;">
<div id="nav">
<ul id="tabnav">
<li><a <?php activemenu("mainpage");?> href="/">Главная</a></li>
<li><a <?php activemenu("schedules");?> href="http://sd.studga.ru">Расписания</a></li>
</ul>
</div>
</td>
</tr>
</table>
