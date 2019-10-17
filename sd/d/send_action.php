<?php
$Inc_sys = "../../sys/";

require_once($Inc_sys . "db.php");
require_once($Inc_sys . "common.php");
//require_once($Inc_sys."sd_stat.php");

if (isset($_POST['datatype']))
    $data_type = $_POST['datatype'];
else
    die("Function is empty");


//captcha2345


define("ERR_INITIAL", "000000000");
define("CAPCHA_NOTHING", "<nothing!>");

$errorcode = ERR_INITIAL;

/*
session_start();
if (isset($_SESSION['captcha_keystring']))
{
    if ($_SESSION['captcha_keystring'] === $_POST['captcha3125'])
    {
        unset($_SESSION['captcha_keystring']);
    }
    else
    {
        unset($_SESSION['captcha_keystring']);
        $errorcode = substr_replace($errorcode, "1", 0, 1);
    }
}
else
{
    die('ОШИБКА: Сессия капчи не сохранилась...');
}
unset($_SESSION['captcha_keystring']);
*/

$capchaCode = isset($_POST['wordofchuckenshit']) ? strval($_POST['wordofchuckenshit']) : CAPCHA_NOTHING;
$capchaIsValid = false;
$capchaIsPregValid = preg_match("/^[A-Za-z0-9]{5,8}$/", $capchaCode);

require_once dirname(__FILE__) . '/../securimage/securimage.php';
$securimage = new Securimage();
$capchaIsValid = $securimage->check($capchaCode);

if( ($capchaCode == CAPCHA_NOTHING) || (!$capchaIsPregValid) || (!$capchaIsValid) )
{
  	$errorcode = substr_replace($errorcode, "1", 0, 1);
}

switch ($data_type)
{
    case 'lector':
        //object_id
        if (($_POST['fullname'] == "") && ($_POST['scince_rank'] == "") && ($_POST['comment'] == ""))
        {
            $errorcode = substr_replace($errorcode, "1", 1, 1);
        }

        if ($errorcode != ERR_INITIAL)
        {
            $err = ($errorcode[4] * pow(2, 4) + $errorcode[3] * pow(2, 3) + $errorcode[2] * (2 * 2) + $errorcode[1] * 2 + $errorcode[0] * 1);
            //echo $errorcode;

            $formdata = base64_encode($_POST['object_id']) . "|" .
            //0
                base64_encode($_POST['fullname']) . "|" .
            //1
                base64_encode($_POST['scince_rank']) . "|" .
            //2
                base64_encode($_POST['comment']);
            //3

            $formdata = base64_encode($formdata);

            header("Location: send_lectorinfo.php?obj_id=" . intval($_POST['object_id']) . "&error=" . $err . "&formdata=" . $formdata);
            exit;
        }

        if (!mysqlold_query("INSERT INTO `sent_info` (`type`, `object_id`, `info1`, `info2`, `comment`, `ip`, `useragent`) values(
'lector',
" . intval($_POST['object_id']) . ",
'" . mysqlold_real_escape_string($_POST['fullname']) . "',
'" . mysqlold_real_escape_string($_POST['scince_rank']) . "',
'" . mysqlold_real_escape_string($_POST['comment']) . "',
'" . mysqlold_real_escape_string($_SERVER['REMOTE_ADDR']) . "',
'" . mysqlold_real_escape_string($_SERVER['HTTP_USER_AGENT']) . "'
)"))
        {
            echo mysqlold_error() . "<br>\n";
            exit;
        }
        header("Location: info_sent.php");
        exit;

        break;

    case 'room':
        //object_id
        if (($_POST['v220'] == "") && ($_POST['comment'] == ""))
        {
            $errorcode = substr_replace($errorcode, "1", 1, 1);
        }

        if ($errorcode != ERR_INITIAL)
        {
            $err = ($errorcode[4] * pow(2, 4) + $errorcode[3] * pow(2, 3) + $errorcode[2] * (2 * 2) + $errorcode[1] * 2 + $errorcode[0] * 1);
            //echo $errorcode;

            $formdata = base64_encode($_POST['object_id']) . "|" . //0
                base64_encode($_POST['v220']) . "|" . //1
                base64_encode($_POST['comment']); //2

            $formdata = base64_encode($formdata);

            header("Location: send_roominfo.php?obj_id=" . intval($_POST['object_id']) . "&error=" . $err . "&formdata=" . $formdata);
            exit;
        }

        if (!mysqlold_query("INSERT INTO `sent_info` (`type`, `object_id`, `info1`, `comment`, `ip`, `useragent`) values(
'room',
" . intval($_POST['object_id']) . ",
'" . mysqlold_real_escape_string($_POST['v220']) . "',
'" . mysqlold_real_escape_string($_POST['comment']) . "',
'" . mysqlold_real_escape_string($_SERVER['REMOTE_ADDR']) . "',
'" . mysqlold_real_escape_string($_SERVER['HTTP_USER_AGENT']) . "'
)"))
        {
            echo mysqlold_error() . "<br>\n";
            exit;
        }

        header("Location: info_sent.php");
        exit;

        break;

    default:
        echo "Ошибся функцией, курица";
        exit;
}


//$_SERVER['HTTP_USER_AGENT']
//$_SERVER['REMOTE_ADDR']

