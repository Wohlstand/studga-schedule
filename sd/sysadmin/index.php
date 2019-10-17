<?
if(!strstr($_SERVER['REMOTE_ADDR'], "172.16.18.157"))
{
    header("HTTP/1.0 404 Not Found");
    echo "<body>Ты ошибся пейджом, курица!</body></html>";
    exit;
}
?>
