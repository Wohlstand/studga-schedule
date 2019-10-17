<?php
function GetGrpName($gr_id, $type=0)
{
    $grpname = mysqlold_query("SELECT * FROM groups WHERE id=".$gr_id."");
    $grpname = mysqlold_fetch_array($grpname);
    if ($type==0)
    {
        if(($grpname['title']!="")&&($grpname['title']!=NULL))
            return $grpname['title'];
        else
            return $grpname['name'];
    }
    else
        return $grpname['name'];
}
