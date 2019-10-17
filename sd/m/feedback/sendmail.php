<?php
require "../../../sys/smtpmail2.php";

////////////////Отправка администратору письма о регистрации в системе

define("ERR_INITIAL", "000000000");
define("CAPCHA_NOTHING", "<nothing!>");

$errorcode = ERR_INITIAL;

$capchaCode = isset($_POST['wordofchuckenshit']) ? strval($_POST['wordofchuckenshit']) : CAPCHA_NOTHING;
$capchaIsValid = false;
$capchaIsPregValid = preg_match("/^[A-Za-z0-9]{5,8}$/", $capchaCode);

require_once dirname(__FILE__) . '/../../securimage/securimage.php';
$securimage = new Securimage();
$capchaIsValid = $securimage->check($capchaCode);

if( ($capchaCode == CAPCHA_NOTHING) || (!$capchaIsPregValid) || (!$capchaIsValid) )
{
  	$errorcode = substr_replace($errorcode, "1", 0, 1);
}

/* Поля-ловушки для ботов */
if($_POST['url'] != "")
{
    die("Ha-ha! (C) Nelson Mandela Muntz");
}
if($_POST['phone'] != "")
{
    die("Ha-ha! (C) Nelson Mandela Muntz");
}
if($_POST['company'] != "")
{
    die("Ha-ha! (C) Nelson Mandela Muntz");
}
/* Поля-ловушки для ботов */

if($_POST['sendername']=="")
{
    $errorcode = substr_replace($errorcode, "1", 1, 1);
}


if($_POST['mailfrom']=="")
{
    $errorcode = substr_replace($errorcode, "1", 2, 1);
}


if(isset($_POST['mailfrom']) && ($_POST['mailfrom']!=""))
if(!preg_match("|^[-0-9a-z_\.]+@[-0-9a-z_^\.]+\.[a-z]{2,6}$|i", $_POST['mailfrom']))
{
	$errorcode = substr_replace($errorcode, "1", 3, 1);//Ошибка ввода мыла
}


if($_POST['messg']=="")
{
    $errorcode = substr_replace($errorcode, "1", 4, 1);
}

if($errorcode != ERR_INITIAL)
{
    $err = ($errorcode[4] * pow(2,4) +
            $errorcode[3] * pow(2,3) +
            $errorcode[2] * pow(2,2) +
            $errorcode[1] * pow(2,1) +
            $errorcode[0] * pow(2,0));

    $formdata = base64_encode($_POST['sendername'])."|".    //0
    base64_encode($_POST['mailfrom'])."|".                  //1
    base64_encode($_POST['messg']);                         //2

    $formdata = base64_encode($formdata);

    header("Location: index.php?error=".$err."&formdata=".$formdata."&".$_SESSION['captcha_keystring']);
    exit;
}


$subject = "Расписания МГТУ ГА Mobile: сообщение от посетителя " . $_POST['sendername'] . "\n\r";

$mail_from = $_POST['mailfrom'];
$replyfrom = $_POST['sendername'];

$message =
	"<b>Здравствуйте, Вам сообщение от посетителя сайта:</b><br>\r\n".
	"<i>" . $_POST['sendername'] . "</i><br>\n\r".
	"<b>IP</b>: <a href=\"http://www.geoiptool.com/ru/?IP=".$_SERVER['REMOTE_ADDR']."\">".$_SERVER['REMOTE_ADDR']."</a><br/>\r\n".
	"<b>E-Mail</b>: ".$mail_from."<br/>\r\n".
	"<b>AGENT</b>: ".$_SERVER['HTTP_USER_AGENT']."<br/>\r\n".
	"<hr>\r\n" . nl2br(htmlspecialchars($_POST['messg'])) . "\r\n".
	"<br>\r\n";

$smtp = new SMTPMail();
$smtp->setDebugPrint(false);
$smtp->setSender($replyfrom, $mail_from);
$smtp->createSimpleLetter($subject, $message, "html");
$smtp->sendLetter();

header("Location: sended.php");

