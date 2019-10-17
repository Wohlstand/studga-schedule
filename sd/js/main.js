soundManager.url = '/settings/sound/swf/'; // directory where SM2 .SWFs live
soundManager.debugMode = false;

var last_message_id = 0;
var load_in_process = false;
var nwmsg_title="<%email="Моя почта - Есть новые сообщения!";if (charsetpage == "win") printf(email); else printf(win_2_koi8(email));%>";
var nomsg_title="<%email="Моя почта";if (charsetpage == "win") printf(email); else printf(win_2_koi8(email));%>";
var newmsg_pgtitle="<%email="*** Есть новые сообщения ***";if (charsetpage == "win") printf(email); else printf(win_2_koi8(email));%>";
var Def_title="<%if (charsetpage == "koi8") printf(sysvar("site_name")); else printf(koi8_2_win(sysvar("site_name")));%>";


$(document).ready(function () {
    setInterval("Load();", 2000);
});    


function Load() {

    if(!load_in_process)
    {
	    load_in_process = true;
    	$.post("/settings/checkmail.asp", 
    	{
    	mail: newmail
    	},
   	    function (result) {
		    eval(result);
		    load_in_process = false;
    	});
    }
}

function blinkfunction()
{
if (newmail==true) setTimeout("document.getElementById('open_block').style.display='block'", 500);
if (newmail==true) setTimeout("document.title = newmsg_pgtitle", 500);
if (newmail==false) document.getElementById('open_block').style.display='none';
setTimeout("document.getElementById('open_block').style.display='none'", 1500);
setTimeout("document.title=Def_title", 1500);
if (newmail==true) setTimeout("blinkfunction()", 1500);
};
if (newmail==true) blinkfunction();


function newmail_true()
{
newmail=true;
soundManager.play('mySound0','/settings/mail.mp3');
document.getElementById("mailbox_button").src="/sysimage/images/email_newmsg.png";
document.getElementById("mailbox_button").onmouseover="";
document.getElementById("mailbox_button").onmouseout="";
document.getElementById("mailbox_button").title = nwmsg_title; //Переменная, Записанная ASP-скриптом
blinkfunction();
};

function newmail_false()
{
newmail=false;
document.getElementById("mailbox_button").src="/sysimage/images/email_nomsg.png";
document.getElementById("mailbox_button").onmouseover="document.getElementById('open_nomsg').style.display='block'";
document.getElementById("mailbox_button").onmouseout="document.getElementById('open_nomsg').style.display='none'";
document.getElementById("mailbox_button").title = nomsg_title; //Переменная, Записанная ASP-скриптом
document.getElementById('open_block').style.display='none';
document.title=Def_title;
};