<?php
if(!isset($menu))
    $menu = "";

function activemenu($item)
{
    global $menu;
    if($menu == $item)
        echo "class=\"active\"";
}
?>
<table id="menutable" width="100%" border="0" cellpadding="0" cellspacing="0">
<tbody><tr>
<td align="left" width="100%">
<div id="nav">
<ul id="tabnav">
</ul>
</div>
</td>
</tr>
</tbody>
</table>
