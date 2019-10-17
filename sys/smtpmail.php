<?php

require_once("mailsetup.php");

function mEncode($string)
{
	return "=?UTF-8?B?". base64_encode($string) . "?=";
}

function smtpmail($mail_to, $mail_from, $subject, $message, $headers='', $auth='reqire')
{
	error_reporting( E_ERROR );
    global $config;
    $SEND 	=   "Date: ".date("D, d M Y H:i:s O") . "\r\n";
    //$SEND .=   'Subject: =?'.$config['smtp_charset'].'?B?'.base64_encode($subject)."=?=\r\n";
	$SEND 	.=	'Subject: ' . mEncode($subject) . "\r\n";

	if($headers)
	 	$SEND .= $headers."\r\n\r\n";
    else
    {
        $SEND .= "Reply-To: ".$config['smtp_username']."\r\n";
        $SEND .= "MIME-Version: 1.0\r\n";
        $SEND .= "Content-Type: text/".$config['smtp_type']."; charset=\"".$config['smtp_charset']."\"\r\n";
        $SEND .= "Content-Transfer-Encoding: 8bit\r\n";
        $SEND .= "From: \"".$config['smtp_from']."\" <".$config['smtp_username'].">\r\n";
        $SEND .= "To: $mail_to <$mail_to>\r\n";
        $SEND .= "X-Priority: 3\r\n";
    }
    $SEND .=  $message."\r\n";

    if(($socket = fsockopen($config['smtp_host'], $config['smtp_port'], $errno, $errstr, 10)) == NULL )
 	{
        if($config['smtp_debug']) echo $errno."FAILED CONNECT to ".$config['smtp_host'] . " :".$errstr;
        return false;
    }

    if(!server_parse($socket, "220", __LINE__))
	{
		if($config['smtp_debug']) echo '<p>FAILED GREETING!</p>';
		return false;
	}

    fputs($socket, "EHLO " . $config['smtp_host'] . "\r\n");
    if (!server_parse($socket, "250", __LINE__))
	{
       if ($config['smtp_debug']) echo '<p>HELO FAILED!</p>';
       fclose($socket);
       return false;
    }

	if($auth=='reqire')
	{
        fputs($socket, "AUTH LOGIN\r\n");
        if (!server_parse($socket, "334", __LINE__)) {
           if ($config['smtp_debug']) echo '<p>LOGIN FAILED.</p>';
           fclose($socket);
           return false;
        }
        fputs($socket, base64_encode($config['smtp_username'])."\r\n");
        if (!server_parse($socket, "334", __LINE__)) {
           if ($config['smtp_debug']) echo '<p>USERNAME FAILED!</p>';
           fclose($socket);
           return false;
        }
        fputs($socket, base64_encode($config['smtp_password'])."\r\n");
        if (!server_parse($socket, "235", __LINE__)) {
           if ($config['smtp_debug']) echo '<p>PASSWORD FAILED</p>';
           fclose($socket);
           return false;
        }
	}

    fputs($socket, "MAIL FROM: <".$mail_from.">\r\n");
    if (!server_parse($socket, "250", __LINE__)) {
       if ($config['smtp_debug']) echo '<p>FAILED MAIL FROM: </p>';
       fclose($socket);
       return false;
    }

    fputs($socket, "RCPT TO: <" . $mail_to . ">\r\n");
    if (!server_parse($socket, "250", __LINE__)) {
       if ($config['smtp_debug']) echo '<p>FAILED RCPT TO: </p>';
       fclose($socket);
       return false;
    }

    fputs($socket, "DATA\r\n");
    if (!server_parse($socket, "354", __LINE__)) {
       if ($config['smtp_debug']) echo '<p>FAILED DATA</p>';
       fclose($socket);
       return false;
    }

    fputs($socket, $SEND."\r\n.\r\n");
    if (!server_parse($socket, "250", __LINE__)) {
       if ($config['smtp_debug']) echo '<p>FAILED SEND</p>';
       fclose($socket);
       return false;
    }

    fputs($socket, "QUIT\r\n");
    fclose($socket);
    return TRUE;
}

function server_parse($socket, $response, $line = __LINE__)
{
    global $config;

    while (substr($server_response, 3, 1) != ' ')
	{
        if (!($server_response = fgets($socket, 256)))
		{
			if($config['smtp_debug']) echo "<p>FULL: $server_response!</p>$response<br>$line<br>";
				return false;
        }
    }
    if (!(substr($server_response, 0, 3) == $response))
	{
		if($config['smtp_debug']) echo "<p>$server_response!</p>$response<br>$line<br>";
			return false;
    }

	if($config['smtp_debug']) echo $server_response."<br>";

    return true;
}
