<?php
if(isset($_GET['lector']))
{
	$get_lector = $_GET['lector'];
	$IsLector = 1;
	if($get_lector=="") die("Lector doesn't selected!");
	if(!is_numeric($get_lector)) die ("Error Lector value!");
}
else
{
	$get_lector = "";
	$IsLector = 0;
	if(!empty($_COOKIE['type']) && 	(
	 (!isset($_GET['grp']))||(!isset($_GET['flow']))
	))
	{
		switch($_COOKIE['type'])
		{
		case "lector":
		$IsLector = 1; break;
		case "student":
		$IsLector = 0; break;
		}
	}
}


if(!$IsLector)
{
	//////////////////////////////////////////////////////////////////////////////////////
	if((isset($_GET['grp']) && isset($_GET['flow'])) || (empty($_COOKIE["flow"]) || empty($_COOKIE["grp"])))
	{
		if(isset($_GET['fac']))
		{
		    $get_fac = $_GET['fac'];
		    if(!is_numeric($get_fac)) die("ERROR in fac Value!!!");
		    //setcookie("fac", $get_fac, time()+(31536000*5), "/");
		}
		else {header("Location: /m/chgr");exit;}

		if(isset($_GET['grp']))
		{
    		$get_groups = $_GET['grp'];
		    if(!is_numeric($get_groups)) die("ERROR in GRP Value!!!");

		    //setcookie("grp", $get_groups, time()+(31536000*5), "/");
		}
		else {header("Location: /m/chgr");exit;}

		if(isset($_GET['flow']))
		{
		    $get_flows = $_GET['flow'];
		    if(!is_numeric($get_flows)) die("ERROR in flow Value!!!");
		    //setcookie("flow", $get_flows, time()+(31536000*5), "/");
		}
		else {header("Location: /m/chgr");exit;}

		if(isset($_GET['lsubgrp']))
		{
		    $get_lsubgroups = $_GET['lsubgrp'];
		    if(!is_numeric($get_lsubgroups)) die("ERROR in lSubGrp Value!!!");
		    //setcookie("lsubgrp", $get_lsubgroups, time()+(31536000*5), "/");
		}
		else
		{
		    $get_lsubgroups = "0";
		    //setcookie("lsubgrp", $get_esubgroups, time()+(31536000*5), "/");
		}

		if(isset($_GET['esubgrp']))
		{
		    $get_esubgroups = $_GET['esubgrp'];
		    if(!is_numeric($get_esubgroups)) die("ERROR in eSubGrp Value!!!");
		    //setcookie("esubgrp", $get_esubgroups, time()+(31536000*5), "/");
		}
		else
		{
		$get_esubgroups = "0";
		//setcookie("esubgrp", $get_esubgroups, time()+(31536000*5), "/");
		}

	//setcookie("type", "student", time()+(31536000*5), "/");
	}
	//////////////////////////////////////////////////////////////////////////////////////
	else
	{
		$get_lsubgroups = intval($_COOKIE["lsubgrp"]);
		$get_esubgroups = intval($_COOKIE["esubgrp"]);
		$get_groups = intval($_COOKIE["grp"]);
		$get_flows = intval($_COOKIE["flow"]);
		$get_fac = intval($_COOKIE["fac"]);
	}
	//////////////////////////////////////////////////////////////////////////////////////
}
else
{
	$get_lsubgroups = 3;
	$get_esubgroups = 0;
	$get_groups = "";
	$get_flows = "";
	$get_fac = 0;

	if(
	(isset($_GET['lector']))
	||
	(empty($_COOKIE["lector"]))
	)
	{
	//setcookie("lector", $get_lector, time()+(31536000*5), "/");
	//setcookie("type", "lector", time()+(31536000*5), "/");

	if(
	(empty($_COOKIE["flow"]))||(empty($_COOKIE["grp"]))||(empty($_COOKIE["lsubgrp"]))
	)
	{
	//setcookie("fac", $get_fac, time()+(31536000*5), "/");
	//setcookie("grp", $get_groups, time()+(31536000*5), "/");
	//setcookie("flow", $get_flows, time()+(31536000*5), "/");
	//setcookie("esubgrp", $get_esubgroups, time()+(31536000*5), "/");
	//setcookie("lsubgrp", $get_esubgroups, time()+(31536000*5), "/");
	}
	}
	else
	{
	$get_lector = intval($_COOKIE["lector"]);
	}
}

///////////////////////////////////////////////////////////////

///////////////////////////////////////ЗАПИСЬ КУК///////////////////////////////////////////////
if(!$IsLector)
	{
	//////////////////////////////////////////////////////////////////////////////////////
	if(((isset($_GET['grp']))&&(isset($_GET['flow'])))	||	((empty($_COOKIE["flow"]))||(empty($_COOKIE["grp"]))))
	{
		setcookie("fac", $get_fac, time()+(31536000*5), "/");
		setcookie("grp", $get_groups, time()+(31536000*5), "/");
		setcookie("flow", $get_flows, time()+(31536000*5), "/");
		setcookie("lsubgrp", $get_lsubgroups, time()+(31536000*5), "/");
		setcookie("esubgrp", $get_esubgroups, time()+(31536000*5), "/");
		setcookie("type", "student", time()+(31536000*5), "/");
	}
	//////////////////////////////////////////////////////////////////////////////////////
}
else
{
	if((isset($_GET['lector']))||(empty($_COOKIE["lector"])))
	{
		setcookie("lector", $get_lector, time()+(31536000*5), "/");
		setcookie("type", "lector", time()+(31536000*5), "/");

		if((empty($_COOKIE["flow"]))||(empty($_COOKIE["grp"]))||(empty($_COOKIE["lsubgrp"])))
		{
			setcookie("fac", $get_fac, time()+(31536000*5), "/");
			setcookie("grp", $get_groups, time()+(31536000*5), "/");
			setcookie("flow", $get_flows, time()+(31536000*5), "/");
			setcookie("esubgrp", $get_esubgroups, time()+(31536000*5), "/");
			setcookie("lsubgrp", $get_esubgroups, time()+(31536000*5), "/");
		}
	}
}
///////////////////////////////////////ЗАПИСЬ КУК///END/////////////////////////////////////////


header("Location: /m/oneday");

