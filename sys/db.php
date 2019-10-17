<?php

require_once(dirname(__FILE__) . "/dblogin.php");
require_once(dirname(__FILE__) . "/mysqlold.php");

function mysqlGetField($query, $field)
{
    $q = mysqlold_query($query);
    if(!$q)
    {
        echo "!!!getField: Query has failed: [$query]:\n\n" . mysqlold_error();
        return NULL;
    }
    $arr = mysqlold_fetch_array($q);
    if(!$arr)
    {
        echo "!!!getField: Query results no fields: [$query]\n";
        return NULL;
    }
    return $arr[$field];
}


$config  = array( 'hostname' => $dbhost, 'username' => $dbuser, 'password' => $dbpass, 'dbname' => $dbname);
$connect = @mysqlold_connect($config['hostname'], $config['username'], $config['password']);
if( !$connect )
{
	echo "Ошибка соединения с сервером базы данных!" . mysqlold_error();
	exit();
}

if(!@mysqlold_select_db($config['dbname'], $connect))
{
    echo "Ошибка подключения базы данных!";
    exit();
}

mysqlold_query("SET NAMES 'utf8'");

