var getData = new XMLHttpRequest();
var objSel = document.getElementById('flow');
var objGroups = document.getElementById('grp');
var objSubGroupsL = document.getElementById('lsubgrp');
var objSubGroupsE = document.getElementById('esubgrp');
var GetScrpt = "/getinfo.php";

var OnLoadFunk = 0;

function onLoad()
{
OnLoadFunk = 1;
if(document.getElementById('fac').value)
getFlows(document.getElementById('fac').value);
else
{
OnLoadFunk = 0;
}

if(document.getElementById('flow').value)
getGroups(document.getElementById('flow').value);

OnLoadFunk = 0;
//if(document.getElementById('flow').value!="")
}


function doGetGroups()
{
	document.getElementById('tr_group_noflow').style.display = "none";
	document.getElementById('tr_group').style.display = "none";
	document.getElementById('tr_lsubgrp').style.display = "none";
	document.getElementById('tr_esubgrp').style.display = "none";
	document.getElementById('tr_group_empty').style.display = "none";
	document.getElementById('tr_loading').style.display = "";

	setTimeout('getGroups(document.getElementById(\'flow\').value)', 1);
}

function doGetFlows()
{
	document.getElementById('tr_flow').style.display = "none";
	document.getElementById('tr_flow_empty').style.display = "none";
	document.getElementById('tr_group_noflow').style.display = "none";
	document.getElementById('tr_group').style.display = "none";
	document.getElementById('tr_lsubgrp').style.display = "none";
	document.getElementById('tr_esubgrp').style.display = "none";
	document.getElementById('tr_group_empty').style.display = "none";
	document.getElementById('tr_loading').style.display = "";
	document.getElementById('tr_flow_nofac').style.display = "none";

	setTimeout('getFlows(document.getElementById(\'fac\').value)',1);
}

function getFlows(id_facult)
{
	document.getElementById('tr_flow').style.display = "none";
	document.getElementById('tr_flow_empty').style.display = "none";
	document.getElementById('tr_group_noflow').style.display = "none";
	document.getElementById('tr_group').style.display = "none";
	document.getElementById('tr_lsubgrp').style.display = "none";
	document.getElementById('tr_esubgrp').style.display = "none";
	document.getElementById('tr_group_empty').style.display = "none";


	document.getElementById('tr_loading').style.display = "";

	if(id_facult=="")
	{
		document.getElementById('tr_flow').style.display = "none";
		document.getElementById('tr_flow_empty').style.display = "none";
		document.getElementById('tr_flow_nofac').style.display = "";
		document.getElementById('tr_group_noflow').style.display = "none";
		document.getElementById('tr_group_empty').style.display = "none";
		document.getElementById('tr_group').style.display = "none";
		document.getElementById('tr_lsubgrp').style.display = "none";
		document.getElementById('tr_esubgrp').style.display = "none";
		document.getElementById('submit1').disabled = "disabled";
		document.getElementById('submit2').disabled = "disabled";
		document.getElementById('tr_loading').style.display = "none";
	}
	else
	{
	document.getElementById('tr_flow_nofac').style.display = "none";
	getData.open("POST", GetScrpt, false);
	getData.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	getData.onreadystatechange = getFlow_accept;
	getData.send("act=GetFlows&fac_id="+id_facult);
	}
}

function getFlow_accept()
{
	var errormsg = "";
	var acept_id = 0;
	var scripttext = getData.responseText;
	if(scripttext)
	{
	//alert(scripttext);
		try{
		eval(scripttext);
		}
		catch(err)
		{
		//alert("Error\n:"+err);
		}
	}

	if(errormsg=='success')
	{
	//document.getElementById("tr"+acept_id).style.display = "none";
	}
	if(document.getElementById('flow').options.length<=1)
	{
	document.getElementById('tr_flow').style.display = "none";
	document.getElementById('tr_group_noflow').style.display = "none";
	document.getElementById('tr_flow_empty').style.display = "";
	document.getElementById('tr_group_empty').style.display = "none";
	document.getElementById('tr_group_noflow').style.display = "none";
	document.getElementById('tr_group').style.display = "none";
	document.getElementById('tr_lsubgrp').style.display = "none";
	document.getElementById('tr_esubgrp').style.display = "none";
	document.getElementById('submit1').disabled = "disabled";
	document.getElementById('submit2').disabled = "disabled";
	}
	else
	{
	document.getElementById('submit1').disabled = "disabled";
	document.getElementById('submit2').disabled = "disabled";
	document.getElementById('tr_flow').style.display = "";
	document.getElementById('tr_group_noflow').style.display = "";
	document.getElementById('tr_flow_empty').style.display = "none";
	document.getElementById('tr_group_empty').style.display = "none";
	document.getElementById('tr_group_noflow').style.display = "";
	document.getElementById('tr_group').style.display = "none";
	document.getElementById('tr_lsubgrp').style.display = "none";
	document.getElementById('tr_esubgrp').style.display = "none";
	}

	if(document.getElementById('flow').value)
	{
	setTimeout("getGroups(document.getElementById('flow').value)", 0);
	}
	document.getElementById('tr_loading').style.display = "none";
//	if(OnLoadFunk==1) { getGroups(document.getElementById('flow').value); OnLoadFunk=0;}
}

function getGroups(id_flow)
{
	if(id_flow=="")
	{
		document.getElementById('tr_group_noflow').style.display = "";
		document.getElementById('tr_group').style.display = "none";
		document.getElementById('tr_lsubgrp').style.display = "none";
		document.getElementById('tr_esubgrp').style.display = "none";
		document.getElementById('tr_group_empty').style.display = "none";
		document.getElementById('submit1').disabled = "disabled";
		document.getElementById('submit2').disabled = "disabled";
		document.getElementById('tr_loading').style.display = "none";
	}
	else
	{
	getData.open("POST", GetScrpt, false);
	getData.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	getData.onreadystatechange = getGroups_accept;
	getData.send("act=GetGroups&flow_id="+id_flow);
	}
}

function getGroups_accept()
{
	var errormsg = "";
	var acept_id = 0;
	var scripttext = getData.responseText;
	//alert(scripttext);
	if(scripttext)
	{
	//alert(scripttext);
		try{
		eval(scripttext);
		}
		catch(err)
		{
		//alert("Error: \n"+err);
		}
	}


	if(errormsg=='success')
	{
	//document.getElementById("tr"+acept_id).style.display = "none";
	}

	document.getElementById('tr_group_noflow').style.display = "none";
	document.getElementById('tr_group').style.display = "";
	document.getElementById('tr_lsubgrp').style.display = "";
	document.getElementById('tr_esubgrp').style.display = "";

	if(document.getElementById('groups').options.length<=1)
	{
	document.getElementById('tr_group_empty').style.display = "";
	document.getElementById('tr_group').style.display = "none";
	document.getElementById('submit1').disabled = "disabled";
	document.getElementById('submit2').disabled = "disabled";
	}
	else
	{
	document.getElementById('tr_group').style.display = "";
	document.getElementById('tr_group_empty').style.display = "none";
	document.getElementById('submit1').disabled = "";
	document.getElementById('submit2').disabled = "";
	}

	if(document.getElementById('esubgrp').options.length<=1)
	{
	document.getElementById('tr_esubgrp').style.display = "none";
	}
	else
	{
	document.getElementById('tr_esubgrp').style.display = "";
	}


	if(document.getElementById('lsubgrp').options.length<=1)
	{
	document.getElementById('tr_lsubgrp').style.display = "none";
	}
	else
	{
	document.getElementById('tr_lsubgrp').style.display = "";
	}

	document.getElementById('tr_loading').style.display = "none";
}

function CheckForm()
{
var err = 0;
var ern1=0;
var ern2=0;
var ern3=0;

/*
alert( document.getElementById('groups').options.length + " "+document.getElementById('groups').value+"\n"
     + document.getElementById('lsubgrp').options.length + " "+document.getElementById('lsubgrp').value+"\n"
     + document.getElementById('esubgrp').options.length + " "+document.getElementById('esubgrp').value+"\n");
*/

if((document.getElementById('groups').options.length>1) && (document.getElementById('groups').value==0))
	{err++; ern1 = 1;}

if((document.getElementById('lsubgrp').options.length>1) && (document.getElementById('lsubgrp').value==0))
	{err++; ern2 = 1;}

if((document.getElementById('esubgrp').options.length>1) && (document.getElementById('esubgrp').value==0))
	{err++; ern3 = 1;}

if(err>0)
{

if(ern1==1)document.getElementById('gr_error').innerHTML = "Выберите группу!";
else document.getElementById('gr_error').innerHTML = "";
if(ern2==1)document.getElementById('ls_error').innerHTML = "Выберите подгруппу!";
else document.getElementById('ls_error').innerHTML = "";
if(ern3==1)document.getElementById('es_error').innerHTML = "Выберите подгруппу!";
else document.getElementById('es_error').innerHTML = "";

return false;
}

return true;
}