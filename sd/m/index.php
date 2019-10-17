<?php
//lsubgrp esubgrp
if((empty($_COOKIE["flow"]))&&(empty($_COOKIE["grp"]))&&(empty($_COOKIE["lsubgrp"]))&&(empty($_COOKIE["esubgrp"])))
{
	header("Location: /m/chgr");
}
else
{
	header("Location: /m/oneday");
}

