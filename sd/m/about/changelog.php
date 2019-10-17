<?php
$ChangeLog_q = mysqlold_query("SELECT * FROM schedule_ver WHERE visible=1 ORDER BY version DESC");
?>

<table style="width: 100%" cellpadding="0" cellspacing="0">
	<tr>
		<th style="width: 142px; white-space: nowrap; height: 19px;">Версия и Описание</th>
	</tr>
﻿<?php
	while($ChangeLog = mysqlold_fetch_assoc($ChangeLog_q)) {?>
	<tr style="border-top-style: solid; border-width: 1px; border-color: #000080">
		<td style="border-top: 1px solid #000080; width: 142px; white-space: nowrap; text-align: left; " valign="top">
            <u><?=$ChangeLog['version']?><?=(($ChangeLog['type'])?" [".$ChangeLog['type']."]":"")?></u>
		</td>
		</tr>
		<tr>
		<td style="text-align: left; border-top-style: solid; border-width: 1px; border-color: #000080" valign="top">
            <b><?=date("d.m.Y", strtotime($ChangeLog['DateOfVer']))?></b>
		<div style="margin:0px auto; height:1px; width: 100%; background-color: #000000; border-width: 1px;"></div>
		<?=$ChangeLog['descr']?></td>
	</tr>
﻿<?php
}
?>
</table>

