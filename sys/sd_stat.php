<?php

function SetStatistics($GrName, $verOfSite)
{
    /*
    //$GrName
    //$verOfSite
    //$_SERVER['USER_AGENT']
    //$_SERVER['REMOTE_ADDR']
    if(!strstr($_SERVER['REMOTE_ADDR'],"172.16."))
    {
	    if(mysqlold_result(mysqlold_query("SELECT count(*) FROM statistic WHERE `IP`='".$_SERVER['REMOTE_ADDR']."' AND `AGENT`='".mysqlold_real_escape_string($_SERVER['HTTP_USER_AGENT'])."' AND `gr_name`='".$GrName."' AND `ver`='".$verOfSite."' AND DATE(`time`) = CURDATE();"),0) <= 0)
	    {
		    mysqlold_query("INSERT INTO statistic (`gr_name`, `IP`, `AGENT`, `ver`) values('".$GrName."','".$_SERVER['REMOTE_ADDR']."','".mysqlold_real_escape_string($_SERVER['HTTP_USER_AGENT'])."','".$verOfSite."');");
	    }
	    else
	    {
		    mysqlold_query("UPDATE statistic SET counts=counts+1,`time`=CURRENT_TIMESTAMP WHERE `IP`='".$_SERVER['REMOTE_ADDR']."' AND `AGENT`='".mysqlold_real_escape_string($_SERVER['HTTP_USER_AGENT'])."' AND `gr_name`='".$GrName."' AND `ver`='".$verOfSite."' AND DATE(`time`) = CURDATE();");
	    }
    //echo mysqlold_error();
    }*/
}

?>
