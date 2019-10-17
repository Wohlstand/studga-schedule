<?php
if(!isset($menu))
$menu = "";

function activemenu($item)
{
    global $menu;
    if($menu==$item) echo "class=\"active\"";
}

?>
<table id="menutable" width="100%" border="0" cellpadding="0" cellspacing="0">
<tbody><tr>
<td align="left" width="100%">
<div id="nav">
<ul id="tabnav">
<li><a <?php activemenu("mainpage"); ?> href="/">Главная</a></li>
<?php
if((isset($_COOKIE["flow"]))&&(isset($_COOKIE["grp"]))||(isset($_COOKIE["lector"]))||(isset($_COOKIE["room"]))||(isset($SchedMenuBar)))
{
    ?>
    <li><a <?php activemenu("full");?> href="/d/sched"><?=((isset($SchedMenuBar)) ? $SchedMenuBar : ((isset($_COOKIE['sched_ttl'])) ? $_COOKIE['sched_ttl'] : "Расписание")) ?></a></li>
    <?php
}
?>
<li><a <?php activemenu("about");?> href="/about/">О проекте</a></li>
<li><select style="margin-top: 5px;">
<option>[Быстро перейти]</option>
<option><в разработке></option>
</select></li>
</ul>
</div>
</td>
</tr>
</tbody>
</table>
