<?php
header("Content-type: text/plain; charset=UTF-8");
$dir = dirname(__FILE__);

$files = array();
foreach (scandir($dir) as $file) $files[$file] = "$dir/$file";
asort($files);
$files = array_keys($files);
//Чтение списка файлов
//while (false !== ($file = readdir($dirHandle)))
for($i=0; $i<count($files);$i++)
{
   if(($files[$i]!=".")&&($files[$i]!="..")&&strstr($files[$i], ".xls"))
   echo str_replace("+", "%20", urlencode($files[$i]))."\n";
   //echo $files[$i]."\n";
}
?>