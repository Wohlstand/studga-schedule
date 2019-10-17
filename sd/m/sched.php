<?php
if(isset($_COOKIE['sched_type']))
{
switch($_COOKIE['sched_type'])
	{
	case "full":
	header("Location: /m/full");break;
	case "oneday";
	header("Location: /m/oneday");break;
	default:
	header("Location: /m/full");
	}
}
else
header("Location: /m/oneday");

