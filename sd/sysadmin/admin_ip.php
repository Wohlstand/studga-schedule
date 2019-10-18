<?php
if(
(!strstr($_SERVER['REMOTE_ADDR'], "172.16.10.31"))
&&
(!strstr($_SERVER['REMOTE_ADDR'], "172.16.10.71"))
&&
(!strstr($_SERVER['REMOTE_ADDR'], "172.16.13.36"))
&&
(!strstr($_SERVER['REMOTE_ADDR'], "172.16.0.1"))
&&
(!strstr($_SERVER['REMOTE_ADDR'], "172.16.18.250"))
&&
(!strstr($_SERVER['REMOTE_ADDR'], "172.16.16.135"))
&&
(!strstr($_SERVER['REMOTE_ADDR'], "172.16.18.157"))
&&
(!strstr($_SERVER['REMOTE_ADDR'], "172.16.2.3"))
&&
(!strstr($_SERVER['REMOTE_ADDR'], "127.0.0.1"))
&&
(!strstr($_SERVER['REMOTE_ADDR'], "2001:470:1f15:942:"))
)
{
    header("HTTP/1.0 404 Not Found");
    header("Content-type: text/html; charset: UTF-8;");
    echo "<html><body>Ты ошибся пейджем, курица!<br>" . $_SERVER['REMOTE_ADDR'] . "</body></html>";
    exit;
}

