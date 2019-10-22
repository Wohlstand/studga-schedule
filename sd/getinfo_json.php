<?php

function postError($errString)
{
    $reply = [];
    $reply["state"] = "error";
    $reply["errMsg"] = $errString;
    printf("%s", json_encode($reply));
    exit();
}

Header("Cache-Control: no-cache, must-revalidate"); // говорим браузеру что-бы он не кешировал эту страницу
Header("Pragma: no-cache");
Header("Content-Type: application/json; charset=utf-8"); // говорим браузеру что это javascript в кодировке UTF-8

if(!isset($_GET['act']))
    postError("Missing 'act' field!");

$sys_inc = "../sys/";
require $sys_inc."db.php";
require $sys_inc."common.php";

$act = isset($_GET['act']) ? $_GET['act'] : "unk";

if($act == "GetFlows")
{
    if(!isset($_GET['fac_id']))
        postError("Missing 'fac_id' field!");

    $in_fac_id = intval($_GET['fac_id']);

    $query = mysqlold_query("SELECT * FROM `schedule_flows` WHERE" .
        " id_facult='" . $in_fac_id . "'" .
        " ORDER BY gr_name,`gr_year-start`");
    $i = 1;
    $flows = [];

    while(($flow_a = mysqlold_fetch_assoc($query)))
    {
        $IsEmptyFlow = false;
        $query_d = mysqlold_query("SELECT * FROM `schedule_daycount` ORDER BY dayend DESC LIMIT 1");
        $dayCounts = mysqlold_fetch_assoc($query_d);

        $dayIdCur = $dayCounts['id_day'];
        $dayIdPrev = $dayCounts['id_day'] - 1;

        $flowEntry = $flow_a;

        if(intval(mysqlGetField("SELECT count(*) FROM `schedule__maindata` WHERE" .
                " id_day=" . $dayIdCur .
                " AND id_flow = " . $flow_a['id_flow'] . ";", 0)) != 0)
        {
            $isOldSchedule = false;
        }
        else
        {
            $query_2 = mysqlold_query("SELECT * FROM schedule_daycount WHERE" .
                " id_day=" . $dayIdPrev .
                " ORDER BY dayend DESC LIMIT 1");
            $isOldSchedule = ($query_2 != null);
        }

        if($isOldSchedule)
        {
            $dayCounts_old = mysqlold_fetch_array($query_2);
            if(($dayCounts_old == NULL) ||
                intval(mysqlGetField("SELECT count(*) FROM schedule__maindata WHERE" .
                    " id_day=" . $dayCounts_old['id_day'] .
                    " AND id_flow = " . $flow_a['id_flow'] . ";", 0)) == 0)
                $IsEmptyFlow = true;
        }

        $days = explode("-", $dayCounts['daystart']);

        $flowEntry["selected"] = false;
        $flowEntry["title"] =
            $flow_a['gr_name'].grFlowNumber($flow_a['gr_year-start'], $flow_a['gr_year-end'], $days[0], $days[1]). " " .
            $flow_a['gr_year-start'] . "-".$flow_a['gr_year-end'] .
            ($isOldSchedule ? (!$IsEmptyFlow ? " *old*" : " *Empty*") : "");

        if(!empty($_COOKIE["flow"]))
        {
            if(intval($_COOKIE['flow']) == intval($flow_a['id_flow']))
                $flowEntry["selected"] = true;
        }

        array_push($flows, $flowEntry);
        $i++;
    }
    $out = [];
    $out["state"] = "ok";
    $out["data"] = $flows;

    printf("%s", json_encode($out));
    exit();
}
else if($act == "GetGroups")
{
    if(!isset($_GET['flow_id']))
        postError("Missing 'flow_id' field!");

    $in_flow_id = intval($_GET['flow_id']);

    $query = mysqlold_query("SELECT * FROM `schedule_flows` WHERE" .
        " id_flow='" . $in_flow_id . "' LIMIT 1;");
    $flow = mysqlold_fetch_array($query);

    $query = mysqlold_query("SELECT * FROM schedule_daycount ORDER BY dayend DESC LIMIT 1");
    $dayCounts = mysqlold_fetch_array($query);
    $dayIdCur = $dayCounts['id_day'];
    $dayIdPrev = $dayCounts['id_day'] - 1;

    if(intval(mysqlGetField("SELECT count(*) FROM schedule__maindata WHERE" .
            " id_day=" . $dayIdCur .
            " AND id_flow = " . $in_flow_id . ";", 0)) != 0)
    {
        $isOldSchedule = false;
    }
    else
    {
        $query_2 = mysqlold_query("SELECT * FROM schedule_daycount WHERE" .
            " id_day=" . $dayIdPrev .
            " ORDER BY dayend DESC LIMIT 1");
        $dayCounts = mysqlold_fetch_array($query_2);
        $isOldSchedule = true;
    }

    $groups = [];
    for($i = 1; $flow && $i <= $flow['group_q']; $i++)
    {
        $group = [];
        if(intval(mysqlGetField("SELECT count(*) FROM schedule__maindata WHERE" .
                " id_day=" . $dayIdCur .
                " AND id_flow = " . $in_flow_id .
                " AND id_group LIKE '%$i%';", 0)) != 0)
        {
            $group["id"] = $i;
            $group["title"] = RuCounter($i);
            $group["selected"] = false;
            if(!empty($_COOKIE["grp"]))
            {
                if(intval($_COOKIE['grp']) == $i)
                    $group["selected"] = true;
            }
        }
        array_push($groups, $group);
    }

    $out = [];
    $out["state"] = "ok";
    $out["data"] = $groups;

    printf("%s", json_encode($out));
    exit();
}
else if($act == "GetSubGroups")
{
    if(!isset($_GET['flow_id']))
        postError("Missing 'flow_id' field!");
    if(!isset($_GET['group_id']))
        postError("Missing 'group_id' field!");

    $in_flow_id = intval($_GET['flow_id']);
    $in_group_id = intval($_GET['group_id']);

    $query = mysqlold_query("SELECT * FROM `schedule_flows` WHERE id_flow='" . $in_flow_id . "' LIMIT 1;");
    $flow = mysqlold_fetch_array($query);

    $query = mysqlold_query("SELECT * FROM schedule_daycount ORDER BY dayend DESC LIMIT 1");
    $dayCounts = mysqlold_fetch_array($query);

    if(intval(mysqlGetField("SELECT count(*) FROM schedule__maindata WHERE id_day=".$dayCounts['id_day']." AND id_flow = " . $in_flow_id . ";", 0)) != 0)
    {
        $isOldSchedule = false;
    }
    else
    {
        $query_2 = mysqlold_query("SELECT * FROM schedule_daycount WHERE id_day=".($dayCounts['id_day']-1)." ORDER BY dayend DESC LIMIT 1");
        $dayCounts = mysqlold_fetch_array($query_2);
        $isOldSchedule = true;
    }

    $eSubGroups = [];
    $lSubGroups = [];

    for($i = 1; $i <= 6; $i++)
    {
        if(intval(mysqlGetField("SELECT count(*) FROM schedule__maindata WHERE" .
                " id_day=" . $dayCounts['id_day'] .
                " AND id_flow = " . $in_flow_id .
                " AND id_group = " . $in_group_id .
                " AND issubgrp=1 AND id_subgrp LIKE '%$i%';", 0)) != 0)
        {
            if($i < 3)
            {
                $subGroup = [];
                $subGroup["title"] = RuCounter($i);
                $subGroup["id"] = $i;
                $subGroup["selected"] = false;
                if(!empty($_COOKIE["esubgrp"]))
                {
                    if (intval($_COOKIE['esubgrp']) == $i)
                        $subGroup["selected"] = true;
                }
                array_push($eSubGroups, $subGroup);
            }
            else
            {
                $subGroup = [];
                $subGroup["title"] = RuCounter($i - 2);
                $subGroup["id"] = $i;
                $subGroup["selected"] = false;
                if(!empty($_COOKIE["lsubgrp"]))
                {
                    if(intval($_COOKIE['lsubgrp']) == $i)
                        $subGroup["selected"] = true;
                }
                array_push($lSubGroups, $subGroup);
            }
        }
    }

    $out = [];
    $out["state"] = "ok";
    $out["data"] = [];
    $out["data"]["eSubGroups"] = $eSubGroups;
    $out["data"]["lSubGroups"] = $lSubGroups;

    printf("%s", json_encode($out));
    exit();
}

postError("Unknown command!");
