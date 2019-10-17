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
<td style="padding:0px; width: 100%; text-align: left;">
<div id="nav">
<ul id="tabnav">
<li><a <?php activemenu("chgr");?> href="/m/chgr"><img alt="Выбрать группу" title="Выбрать группу" src="/css/images/edititem.gif" style="border:0; height: 12px; width: 12px;"/></a></li>
<?php
//lsubgrp esubgrp
if((empty($_COOKIE["flow"]))&&(empty($_COOKIE["grp"]))&&(empty($_COOKIE["lsubgrp"]))&&(empty($_COOKIE["esubgrp"])))
{}
else
{
?>
<li><a <?php activemenu("OneDay");?> href="/m/oneday"><?=((isset($SchedMenuBar))?$SchedMenuBar:((isset($_COOKIE['sched_ttl']))?$_COOKIE['sched_ttl'] : "Расписание"))?></a></li>
<?php
}
?>
</ul>
</div>
</td>
</tr>
</table>
