<?php
if(isset($_COOKIE['sched_type']))
{
    switch($_COOKIE['sched_type'])
	{
	case "full":
	    header("Location: /d/full"); break;
	case "oneday";
	    header("Location: /d/oneday"); break;
	default:
	    header("Location: /d/full");
	}
}
else
header("Location: /d/full");
?>
