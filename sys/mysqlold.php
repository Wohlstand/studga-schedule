<?php
#通过mysqli扩展实现mysql扩展的API

function mysqlold_affected_rows($conn = null)
{
	if ($conn === null) {
		$conn = mysqlold_connect();
	}

	return mysqli_affected_rows($conn);
}


function mysqlold_client_encoding($conn = null)
{
	if ($conn === null) {
		$conn = mysqlold_connect();
	}

	return mysqli_character_set_name($conn);
}

function mysqlold_close($conn = null)
{
	if ($conn === null) {
		$conn = mysqlold_connect();
	}

	return mysqli_close($conn);
}

function mysqlold_connect($server = null, $user = null, $pass = null)
{
	static $conn = null;

	if ($server === null) {
		if ($conn !== null) {
			return $conn;
		} else {
			return mysqli_connect(DB_HOST, DB_USER, DB_PASSWD);
		}
	} else {
		$conn = mysqli_connect ($server, $user, $pass);
		return $conn;
	}
}

#mysqlold_create_db
#废弃

function mysqlold_data_seek($rs, $offset)
{
	return mysqli_data_seek($rs, $offset);
}

#mysqlold_db_name
#废弃

#mysqlold_db_query
#废弃

#mysqlold_drop_db
#废弃

function mysqlold_errno($conn = null)
{
	if ($conn === null) {
		$conn = mysqlold_connect();
	}

	return mysqli_errno($conn);
}

function mysqlold_error($conn = null)
{
	if ($conn === null) {
		$conn = mysqlold_connect();
	}

	return mysqli_error($conn);
}

function mysqlold_escape_string($str, $conn = null)
{
	if ($conn === null) {
		$conn = mysqlold_connect();
	}

	return mysqli_real_escape_string($conn, $str);
}

function mysqlold_fetch_array($rs, $type = MYSQLI_BOTH)
{
	return mysqli_fetch_array($rs, $type);
}

function mysqlold_fetch_assoc($rs)
{
	return mysqli_fetch_assoc($rs);
}

function mysqlold_fetch_field($rs, $offset = 0)
{
	return mysqli_fetch_field_direct($rs, $offset);
}

function mysqlold_fetch_lengths($rs)
{
	return mysqli_fetch_lengths($rs);
}

function mysqlold_fetch_object($rs)
{
	return mysqli_fetch_object($rs);
}

function mysqlold_fetch_row($rs) {
	return mysqli_fetch_row($rs);
}

function mysqlold_field_flags($rs, $offset)
{
	$field = mysqli_fetch_field_direct($rs, $offset);
	return $field['flags'];
}

function mysqlold_field_len($rs, $offset)
{
	$field = mysqli_fetch_field_direct($rs, $offset);
	return $field['length'];
}

function mysqlold_field_name($rs, $offset)
{
	$field = mysqli_fetch_field_direct($rs, $offset);
	return $field['name'];
}

function mysqlold_field_seek($rs, $offset)
{
	return mysqli_field_seek($rs, $offset);
}

function mysqlold_field_table($rs, $offset)
{
	$field = mysqli_fetch_field_direct($rs, $offset);
	return $field['table'];
}

function mysqlold_field_type($rs, $offset)
{
	$field = mysqli_fetch_field_direct($rs, $offset);
	return $field['type'];
}

function mysqlold_free_result($rs)
{
	return mysqli_free_result($rs);
}

function mysqlold_get_client_info()
{
	$conn = mysqlold_connect();
	return mysqli_get_client_info($conn);
}

function mysqlold_get_host_info($conn = null)
{
	if ($conn === null) {
		$conn = mysqlold_connect();
	}

	return mysqli_get_host_info($conn);
}

function mysqlold_get_proto_info($conn = null)
{
	if ($conn === null) {
		$conn = mysqlold_connect();
	}

	return mysqli_get_proto_info($conn);
}

function mysqlold_get_server_info($conn = null)
{
	if ($conn === null)
    {
		$conn = mysqlold_connect();
	}

	return mysqli_get_server_info($conn);
}

function mysqlold_info($conn = null)
{
	if ($conn === null) {
		$conn = mysqlold_connect();
	}

	return mysqli_info($conn);
}

function mysqlold_insert_id($conn = null)
{
	if ($conn === null) {
		$conn = mysqlold_connect();
	}

	return mysqli_insert_id($conn);
}

#mysqlold_list_dbs
#废弃

#mysqlold_list_fields
#废弃

#mysqlold_list_processes
#废弃

#mysqlold_list_tables
#废弃

function mysqlold_num_fields($rs)
{
	return mysqli_num_fields($rs);
}

function mysqlold_num_rows($rs)
{
	return mysqli_num_rows($rs);
}

function mysqlold_pconnect($server = null, $user = null, $pass = null)
{
	if ($server === null)
    {
		return mysqli_connect('p:' . DB_HOST, DB_USER, DB_PASSWD);
	}
    else
    {
		return mysqli_connect ('p:' . $server, $user, $pass);
	}
}

function mysqlold_ping($conn = null)
{
	if ($conn === null) {
		$conn = mysqlold_connect();
	}

	return mysqli_ping($conn);
}

function mysqlold_query($query, $conn = null)
{
	if ($conn === null) {
		$conn = mysqlold_connect();
	}

	return mysqli_query($conn, $query);
}

function mysqlold_real_escape_string($str, $conn = null)
{
	if ($conn === null) {
		$conn = mysqlold_connect();
	}

	return mysqli_real_escape_string($conn, $str);
}

function mysqlold_result($query, $field = 0, $conn = null)
{
    #if ($conn === null) {
	#	$conn = mysqlold_connect();
	#}
	$reply = $query;#mysqli_query($conn, $query);
	if($reply)
	   $arr = mysqlold_fetch_array($reply);
	else
	   $arr = array();
    return $arr[$field];
}

function mysqlold_select_db($dbname, $conn = null)
{
	if ($conn === null) {
		$conn = mysqlold_connect();
	}

	return mysqli_select_db($conn, $dbname);
}

function mysqlold_set_charset($charset, $conn = null)
{
	if ($conn === null) {
		$conn = mysqlold_connect();
	}

	return mysqli_set_charset($conn, $charset);
}

function mysqlold_stat($conn = null)
{
	if ($conn === null) {
		$conn = mysqlold_connect();
	}

	return mysqli_stat($conn);
}

#mysqlold_tablename
#废弃

function mysqlold_thread_id($conn = null)
{
	if ($conn === null) {
		$conn = mysqlold_connect();
	}

	return mysqli_thread_id($conn);
}

#mysqlold_unbuffered_query
#废弃

