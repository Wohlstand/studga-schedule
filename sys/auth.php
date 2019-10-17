<?php

session_start();

if(empty($_SESSION['login']))
{
	header("Location: /login/?url=".$_SERVER['REQUEST_URI']."&unauth");
}

if(!empty($_SESSION['login']))
{
	//Считывание данных пользователя
	$query = mysqlold_query("SELECT * FROM users WHERE username='" . $_SESSION['login'] . "' LIMIT 1");
	$userdata = mysqlold_fetch_array($query);

	if(!$userdata)
	{
		session_destroy();
		header("Location: /login/?relogin=1");
	}

	//Проверка шифрования пароля
	if($userdata['crypto']=='SHA1')
		$pass_fm = sha1($_SESSION['passw']);

	else	if($userdata['crypto']=='MD5')
		$pass_fm = md5($_SESSION['passw']);

	else	if($userdata['crypto']=='B64')
		$pass_fm = base64_encode($_SESSION['passw']);

	else	$pass_fm = $_SESSION['passw'];

	//Чтение пароля из базы данных
	if(($userdata['crypto']=='SHA1') || ($userdata['crypto']=='MD5'))
		$pass_db = $userdata['password'];
	else
		$pass_db = $userdata['password_c'];
}


if($pass_fm != $pass_db)
{
	session_destroy();
	header("Location: /login/?relogin=1");
}
