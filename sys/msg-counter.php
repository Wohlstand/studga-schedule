<?php

if(isset($_GET['p']) && ($_GET['p'])!="")
	$pagecount = intval($_GET['p']);
else
	$pagecount = 1;

if($pagecount <= 0)
    $pagecount = 1;
$totalmsgs = 0;

function messageCounter($countofMsgs, $pages, $cur)
{
  if( ($countofMsgs > 0) && ($pages>0))
  {
	echo "<table style=\"margin-left: auto;margin-right:auto;\"><tr>";

	if($cur > 1)
	        echo "<td style=\"width: 13px; height: 13px; font-size: 8pt;\" align=center><a href=\"?&p=".($cur-1)."\">&lt;</font></td>";
	else
        	echo "<td style=\"width: 13px; height: 13px; font-size: 8pt;\" align=center>&nbsp;</td>";


        for ($i = 1; $i <= $pages; $i++)
        {
            if ($pages < 15)
            {
                if ($i == $cur)
                {
                        echo "<td style=\"background-color: #c0c0c0; width: 13px; height: 13px; font-size: 8pt; color: #FFFFFF\" align=center>".$i."</td>";
                }
                else
                {
                        echo "<td style=\"width: 13px; height: 13px; font-size: 8pt;\" align=center><a href=\"?&p=".$i."\">$i</font></td>";
                }
            }
            else
            {
                	if ($i == $cur)
                	{
                        	echo "<td style=\"background-color: #c0c0c0; width: 13px;\" align=center><span style=\"color: #ffffff; font-size: 1;\">".$i."</span></td>";
                	}
                	else
                	{
	                        echo "<td style=\"width: 13px; height: 13px; text-align: center\"><span style=\"font-size: 1;\"><a href=\"?&p=".$i."\">$i</a></span></td>";
                	}

                	if (($cur > 4)&&($i == 2))
                	{
			    echo "<td style=\"width: 13px; height: 13px; text-align: center\"><span style=\"font-size: 1;\">...</span></td>";
                	$i=$cur-2;}

                	if (($cur+1 == $i)&&($cur+1 < $pages-2))
                	{ echo "<td style=\"width: 13px; height: 13px; text-align: center\"><span style=\"font-size: 1;\">...</span></td>";
                	$i=$pages-2;
                	}
            }
        }

	if($cur < $pages)
	        echo "<td style=\"width: 13px; height: 13px; font-size: 8pt;\" align=center><a href=\"?&p=".($cur+1)."\">&gt;</font></td>";
	else
	        echo "<td style=\"width: 13px; height: 13px; font-size: 8pt;\" align=center>&nbsp;</td>";

 	echo "<td style=\"padding-left:15px;\" align=center><font size=1>Страница ".$cur." из ".$pages."</font></td>";

	echo "</tr></table>";
  }
}


