// No Oldies (C) VEG, Created: 08.08.2009, Updated: 27.08.2012
(function(){
if (typeof oldies != 'undefined') return;
oldies = true;
// var is_ie6 = (window.external && typeof window.XMLHttpRequest == "undefined");

// Language detection
var lang = document.getElementsByTagName('html').length ? document.getElementsByTagName('html')[0].getAttribute('lang') : '';
if (!lang)
{
	var title = document.getElementsByTagName('title').length ? document.getElementsByTagName('title')[0].innerHTML : '';
	lang = (title && title.match(/[\u0400-\u04FF]+/)) ? 'ru' : 'en';
}
else if (lang.length > 2) lang = lang.substring(0, 2);
if (lang != 'en' && lang != 'ru' && lang != 'uk') lang = 'en';

// Display notify
var message;
var helpurl = '/js/oldbrowser/' + lang + '.html';
switch (lang)
{
	case 'ru':	message = 'Ваш браузер устарел. Сайт будет работать неправильно. Чтобы исправить проблему нажмите здесь.';	break;
	case 'uk':	message = 'Ваш браузер застарів. Сайт буде працювати неправильно. Щоб виправити проблему натисніть тут.';	break;
	default:	message = 'Your browser is outdated. The website will not work properly. To solve the problem click here.';	break;
}
document.write('<div id="oldies-bar" style="z-index: 65535; background: #ffffe1 url(/js/oldbrowser/images/exclaim.gif) no-repeat 7px 2px; border-bottom: 1px solid #716f64; border-top: 1px solid #e0dfd0; padding: 0; margin: 0; position: fixed; width:100%; height: 21px; left:0; top:0; _position: absolute; _top: expression(eval(document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop)); _left: expression(eval(document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft)); _width: expression(eval(document.documentElement.clientWidth ? document.documentElement.clientWidth : document.body.clientWidth));"><span style="display: block; float: right; padding: 2px 7px 2px 7px; margin: 0; cursor: pointer; font: 12px Verdana; color: #536482;" onclick="document.getElementById(\'oldies-shadow\').style.display=\'none\'; document.getElementById(\'oldies-bar\').style.display=\'none\';">×</span><a href="'+helpurl+'" style="display: block; text-decoration: none; cursor: pointer; padding: 3px 0 2px 26px; margin: 0 30px 0 0; font: 11px Verdana; color: #536482;">'+message+'</a></div><div id="oldies-shadow" style="height: 22px; padding: 0; margin: 0;"></div>');

})();