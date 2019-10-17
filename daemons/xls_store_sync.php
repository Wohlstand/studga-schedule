<?php

header('Content-Type: text/html; charset=utf-8');
if(defined('STDIN') )
    echo("Starting script...\n");
else
    die("Not for Web\n");

require_once(dirname(__FILE__)."/../sys/db.php");
require_once(dirname(__FILE__)."/../sys/smtpmail2.php");

define("DOWNLOAD_NOTHING",      0);
define("DOWNLOAD_GOT_NEW",      1);
define("DOWNLOAD_DELETED_OLD",  2);

$g_Archived       = 0;
$g_NewFiles       = 0;
$g_AllFiles       = 0;
$g_SkippedUrls    = 0;
$g_DeletedFiles   = 0;
$g_AddedReport    = "";
$g_DeletedReport  = "";
$g_MailToRep      = "";

$g_destFolder = dirname(__FILE__) . "/../sd/excels/new";


$g_logFile = dirname(__FILE__) . "/../logs/CheckFile_LOG.txt";
$g_source =   "---------------------------------------------------------------\n".
              "Скрипт запускался " . date("Y-m-d H:i:s") . "\n";
$g_Saved_File = fopen($g_logFile, 'a+');
fwrite($g_Saved_File, $g_source);

if(!is_dir(dirname(__FILE__)."/_temp"))
    mkdir(dirname(__FILE__)."/_temp");

$g_protectedFiles  = array();

/*
    Защитить файл от удаления
*/
function fileToProtect($add_val)
{
    global $g_protectedFiles;
    array_push($g_protectedFiles, $add_val);
}

/*
    Защищёг ли файл?
*/
function fileIsProtected($prot_file)
{
    global $g_protectedFiles;
    if (($key = array_search($prot_file, $g_protectedFiles)) !== false) {
        return true;
    }
    return false;
}


$g_filesToRemove  = array();

/*
    Файл на удаление
*/
function fileToDelete($fileToKill, $sourceUrl, $synonim)
{
    global $g_filesToRemove;

    $strukt = [
        "file" => $fileToKill,
        "url" => $sourceUrl,
        "synonim" => $synonim,
    ];

    if (($key = array_search($strukt, $g_filesToRemove)) !== false) {
        return false;
    }

    array_push($g_filesToRemove, $strukt);
    return true;
}

/*
    Удалить файлы, помеченные на удаление, и которые не были защищены от удаления
*/
function deleteFilesToDelete()
{
    global
        $g_filesToRemove,
        $g_DeletedFiles,
        $g_SkippedUrls,
        $g_DeletedReport;

    if(count($g_filesToRemove) > 0)
    {
        echo "\n\nRemove old files:\n";
    }

    foreach($g_filesToRemove as $deadFile)
    {
        if(fileIsProtected($deadFile["file"]))
        {
            echo "Skip protected " . $deadFile["file"] . "...\n";
            $g_SkippedUrls++;
            continue;
        }

        doArch();

        echo "Remove " . $deadFile["file"] . "...\n";

        unlink($deadFile["file"]);
        $g_DeletedFiles++;

        $bname = basename($deadFile["file"]);

        $g_DeletedReport .= "-------------------------------------------------------------------------------------------<br>\r\n";
        $g_DeletedReport .= "Наличие:   Файла нет<br>\r\n";
        $g_DeletedReport .= "<b>URL:</b>       <a href=\"" . $deadFile["url"] . "\">" . urldecode($deadFile["url"]) . "</a><br>\r\n";
        $g_DeletedReport .= "<b>Имя:</b>       " . urldecode(basename($deadFile["url"])) . "<br>\r\n";
        if(!empty($deadFile["synonim"]))
            $g_DeletedReport .= "<b>Синоним:</b>   " . $deadFile["synonim"] . "<br>\r\n";
        $g_DeletedReport .= "<b>Итог:</b>      Файл удалён из кэша<br>\r\n";

        if(getField("SELECT count(*) FROM schedule_files WHERE filename= '" . $bname . "'", 0) > 0)
        {
            mysqlold_query("UPDATE schedule_files SET `deleted`=1 WHERE filename='" . $bname . "';");
        }
        else
        {
            mysqlold_query("INSERT INTO schedule_files (filename, hash, last_mod)
            values('" . $bname . "','[deleted]', CURRENT_TIMESTAMP);");
        }
    }
}


function doArch()
{
    global $g_Archived;

    if($g_Archived == 1)
        return 1;

    echo "[NEW-BACKUP] ";

    $archive_dir   = dirname(__FILE__)."/../sd/excels/backup/";
    $src_dir       = dirname(__FILE__)."/../sd/excels/new/";
    $zip           = new ZipArchive();
    $ArcFileName   = $archive_dir.date("Y-m-d-H-i-s")."_".(rand()%100).".zip";

    if($zip->open($ArcFileName, ZIPARCHIVE::CREATE) !== true)
    {
        echo "!!!!!!!!!!!!!!!!!!!!!!Ошибка создания архива!!!\n";
        exit(1);
    }

    //добавляем файлы в архив все файлы из папки src_dir
    $dirHandle = opendir($src_dir);
    while(false !== ($file = readdir($dirHandle)))
    {
        if(($file != ".") && ($file != "..") && ($file != "excels.rar") && ($file != "excels.php"))
            $zip->addFile($src_dir . $file, iconv("UTF-8", "CP866//IGNORE", $file));
    }

    //закрываем архив
    $zip->close();

    echo "---Создана резервная копия---\n";
    $g_Archived = 1;
}


function doDbQuery($query)
{
    return mysqlold_query($query);
}

function getField($query, $field)
{
    $q = doDbQuery($query);
    $arr = mysqlold_fetch_array($q);
    if(!$arr)
    {
        echo "!!!getField: Query results no fields: [$query]\n";
        return NULL;
    }
    return $arr[$field];
}

function initDownloder()
{
    set_time_limit(0);
    $ch = curl_init("http://mstuca.ru/");

    curl_setopt($ch, CURLOPT_TIMEOUT, 50);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_FILETIME, true);
    return $ch;
}

function closeDownloader($ch)
{
    curl_close($ch);
}

function markFileForRemove($finalFile, $srcUrl, $synonim)
{
    global
        $g_DeletedFiles,
        $g_DeletedReport;

    if(file_exists($finalFile))
    {
        fileToDelete($finalFile, $srcUrl, $synonim);
        return true;
    }
    return false;
}

function downloadFile($ch, $url, $folder, $synonim)
{
    global
        $g_NewFiles,
        $g_AllFiles,
        $g_SkippedUrls,
        $g_DeletedFiles,
        $g_AddedReport,
        $g_DeletedReport,
        $g_MailToRep;

    $g_AllFiles++;

    $url = trim($url);

    $tempFile = dirname(__FILE__) . "/_temp/temp.tmp";
    $finalFile = trim($folder . "/" . trim(urldecode(basename($url))));
    $finalBaseName = trim(urldecode(basename($url)));
    if(!empty($synonim))
    {
        $finalFile = trim($folder . "/" . trim($synonim));
        $finalBaseName = trim($synonim);
    }

    //This is the file where we save the    information
    $fp = fopen($tempFile, 'w+');
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_exec($ch);

    fclose($fp);

    $retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    echo $finalBaseName . ": ";

    if($retcode != 200)
    {
        if(file_exists($tempFile))
            unlink($tempFile);
        switch($retcode)
        {
        case 404:
            echo "$retcode Not exists...";
            if(markFileForRemove($finalFile, $url, $synonim))
            {
                echo " DELETE OLD\n";
                return DOWNLOAD_DELETED_OLD;
            }
            $g_SkippedUrls++;
            echo "\n";
            return DOWNLOAD_NOTHING;

        default:
            echo "$retcode BAD file, trying next...";
            if(markFileForRemove($finalFile, $url, $synonim))
            {
                echo " DELETE OLD\n";
                return DOWNLOAD_DELETED_OLD;
            }
            $g_SkippedUrls++;
            echo "\n";
            return DOWNLOAD_NOTHING;
        }
        return "";
    }

    $fileTime = curl_getinfo($ch, CURLINFO_FILETIME);
    $fileType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
    $fileSize = curl_getinfo($ch, CURLINFO_SIZE_DOWNLOAD);
    $fileHash = hash_file("md5", $tempFile);
    $fileHashExisting = "";
    if(file_exists($finalFile))
        $fileHashExisting = hash_file("md5", $finalFile);

    if(!strstr($fileType, "ms-excel"))
    {
        echo "NOT AN EXCEL!";
        if(file_exists($tempFile))
            unlink($tempFile);
        if(markFileForRemove($finalFile, $url, $synonim))
        {
            echo " DELETE OLD\n";
            return DOWNLOAD_DELETED_OLD;
        }
        $g_SkippedUrls++;
        echo "\n";
        return DOWNLOAD_NOTHING;
    }

    if($fileHashExisting == $fileHash)
    {
        echo "WE HAVE IT!\n";
        $g_SkippedUrls++;
        fileToProtect($finalFile);

        if(file_exists($tempFile))
            unlink($tempFile);
        return DOWNLOAD_NOTHING;
    }

    doArch();
    echo "Remote time: " . date('Y-m-d H:i:s', $fileTime) . ", raw $fileTime, type: $fileType, hash: $fileHash\n";

    $g_AddedReport .= "-------------------------------------------------------------------------------------------<br>\r\n";
    $g_AddedReport .= "Наличие:   Файл есть<br>\r\n";
    $g_AddedReport .= "<b>Дата:</b>      " . date('d.m.Y H:i:s', $fileTime) . "<br>\r\n";
    $g_AddedReport .= "<b>URL:</b>       <a href=\"" . $url . "\">" . urldecode($url) . "</a><br>\r\n";
    $g_AddedReport .= "<b>Имя:</b>       " . urldecode(basename($url)) . "<br>\r\n";
    if(!empty($synonym))
        $g_AddedReport .= "<b>Синоним:</b>   " . $synonym . "<br>\r\n";
    $g_AddedReport .= "<b>Размер:</b>    " .  $fileSize . " байт<br>\r\n";
    $g_AddedReport .= "<b>MD5:</b>       " . $fileHash . "<br>\r\n";
    $g_AddedReport .= "<b>Итог:</b>      Это Excel, загружена новая версия<br>\r\n";

    if(file_exists($finalFile))
        unlink($finalFile);
    rename($tempFile, $finalFile);

    fileToProtect($finalFile);
    $g_NewFiles++;


    if(getField("SELECT count(*) FROM schedule_files WHERE filename= '".$finalBaseName."'", 0) > 0)
    {
        if(
            (getField("SELECT last_mod FROM schedule_files WHERE filename= '" . $finalBaseName . "'", 0) != date('Y-m-d H:i:s', $fileTime)) ||
            ($fileTime == -1)
        )
        {
            mysqlold_query("UPDATE schedule_files SET last_mod='" . date('Y-m-d H:i:s', $fileTime) . "'," .
            " `deleted`=0, `synonym`=" . (!empty($synonym) ? 1 : 0) . "," .
            " hash='" . $fileHash . "' WHERE filename='" . $finalBaseName . "';");
        }
    }
    else
    {
        mysqlold_query("INSERT INTO schedule_files (filename, hash, last_mod)
        values('".$finalBaseName."','" . $fileHash . "','" . date('Y-m-d H:i:s', $fileTime) . "');");
    }


    return DOWNLOAD_GOT_NEW;
}




$ch = initDownloder();

if(!$ch)
{
    echo("Can't connect!!!\n");
    exit(1);
}

echo "Соединение установлено, начинается проверка файлов...\n";
echo "===========================================================================================\n";

$files_q = mysqlold_query("SELECT `link`,`synonym` FROM schedule_links ORDER by `synonym`,`link`;");

while(($files = mysqlold_fetch_array($files_q)) != NULL)
{
    downloadFile($ch,
                    $files['link'],
                    $g_destFolder,
                    $files['synonym']
    );
}

closeDownloader($ch);


// Remove candidates to remove
deleteFilesToDelete();


echo "===========================================================================================\n";
$g_MailToRep .= "===========================================================================================<br>\r\n";


echo "Всего провенено файлов:       ".$g_AllFiles."\n";
$g_MailToRep .= "<b>Всего провенено файлов:</b>       ".$g_AllFiles."<br>\r\n";
fwrite($g_Saved_File, "Всего провенено файлов:       ".$g_AllFiles."\n");

echo "Было загружено новых файлов:  ".$g_NewFiles."\n";
$g_MailToRep .= "<b>Было загружено новых файлов:</b>  ".$g_NewFiles."<br>\r\n";
fwrite($g_Saved_File, "Было загружено новых файлов:  ".$g_NewFiles."\n");

echo "Пропущенные ссылки:           ".$g_SkippedUrls."\n";
$g_MailToRep .= "<b>Пропущенные ссылки:</b>           ".$g_SkippedUrls."<br>\r\n";
fwrite($g_Saved_File, "Пропущенные ссылки:           ".$g_SkippedUrls."\n");

echo "Удалённые файлы:              ".$g_DeletedFiles."\n";
$g_MailToRep .= "<b>Удалённые файлы:</b>              ".$g_DeletedFiles."<br>\r\n";
fwrite($g_Saved_File, "Удалённые файлы:              ".$g_DeletedFiles."\n");

if( ($g_NewFiles > 0) || ($g_DeletedFiles > 0) )
{
    $subject = "Система расписаний МГТУ ГА: расписания обновлены!";

    $message =  "<b>Расписания обновлены!</b><br>\r\n" .
                "Было произведено обновление Excel-файлов в " . date("Y-m-d H:i:s") . "<br>\r\n" .
                "Всего было обновлено файлов: " . $g_NewFiles . "<br>\r\n";

    if($g_NewFiles > 0)
        $message .= "<h2>Обновлённые файлы:</h2>\r\n" . $g_AddedReport."\r\n";

    if($g_DeletedFiles > 0)
        $message .= "<h2>Удалённые файлы:</h2>\r\n" . $g_DeletedReport."\r\n";

    $message .= $g_MailToRep;

    $mail_from = $mailsetup['sendfrom'];
    $replyfrom = "Система расписаний МГТУ ГА";

    $mail_to   = $mailsetup['sendto'];
    $replyto   = "Администрация";

    $smtp = new SMTPMail();
    $smtp->setDebugPrint(false);
    $smtp->setSender($replyfrom, $mail_from);
    $smtp->createSimpleLetter($subject, $message, "html");
    if($smtp->sendLetter())
        echo "--Был отправлен отчёт о работе\n";
    else
        echo "--ОШИБКА ОТПРАВКИ ОТЧЁТА!\n";
}

fclose($g_Saved_File);

