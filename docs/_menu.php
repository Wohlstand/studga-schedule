<?php
if(!isset($menu))
$menu = "";

function activemenu($item)
{
global $menu;
if($menu==$item) echo "class=active";
}
?>
<table id="menutable" width="100%" border="0" cellpadding="0" cellspacing="0">
<tbody><tr>
<td align="left" width="100%">
<div id="nav">
<ul id="tabnav">
<li><a <?activemenu("mainpage");?> href="/">Главная</a></li>
<li><a <?activemenu("schedules");?> href="http://sd.studga.ru">Расписания</a></li>
</ul>
</div>
</td>
</tr>
</tbody>
</table>
