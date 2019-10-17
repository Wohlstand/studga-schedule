function atoprint(aId)
{
	var atext = document.getElementById(aId).innerHTML;
	var captext = window.document.title;
	var alink = window.document.location;
	var prwin = open('', "Версия расписания для печати","toolbar=no,menubar=no,status=no,directories=no,resizable=yes,scrollbars=yes,top=100,left=20,width=1100,height=600");
	prwin.document.open();
	prwin.document.writeln('<html><head><title>Расписание занятий - Версия для печати<\/title><\/head>');
	prwin.document.writeln('<link rel="stylesheet" href="/css/style_print.css" type="text/css">');
	prwin.document.writeln('<link rel="stylesheet" href="/css/style_print2.css" type="text/css" media="print">');
	prwin.document.writeln('<body text="#000000" bgcolor="#FFFFFF"><div onselectstart="return false;" oncopy="return false;">');
	prwin.document.writeln('<div class="hideforprint" style="margin-bottom:5px; font-size: 10pt;"><input type="button" onclick="window.print();" value="Печать"> • <input type="button" onclick="window.close();" value="Закрыть окно"><\/div><hr class="hideforprint">');
	prwin.document.writeln('<h1 style="font-style: italic; text-align: center; font-family: \'Times New Roman\'; font-size: x-large">'+captext+'<\/h1>');
	prwin.document.writeln('<div style="padding: 0px 10px 0px 10px;">');
	prwin.document.writeln(atext.replace(/<a (.*?)>([\s\S]*?)(?=<\/a>)<\/a>/gi, "<span>$2</span>"));
	prwin.document.writeln('</div>');
	prwin.document.writeln('<hr><div style="font-size:8pt;margin-top:20px;">Все права защищены © ЭВМ МГТУ ГА<\/div>');
	prwin.document.writeln('<div style="font-size:8pt;">Страница материала: '+alink+'<\/div>');
	prwin.document.writeln('<div class="hideforprint" style="margin-bottom:5px; font-size: 10pt;"><input type="button" onclick="window.print();" value="Печать"> • <input type="button" onclick="window.close();" value="Закрыть окно"><\/div>');
	prwin.document.writeln('<\/div><\/body><\/html>');
	prwin.document.close();
}