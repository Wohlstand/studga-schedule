function _gid(a){return document.getElementById(a)}
function edit(mid){
	_gid("m_"+mid).className="ebox_e";
        return false;
}
function cedit(mid){
        _gid("m_"+mid).className="ebox";
        return false;
}
function show(mid){
        if (_gid("l_"+mid).className == "closed")
	{
        	_gid("l_"+mid).className="opened";
        	_gid("m_"+mid).className="shown";
	}
	else
	{
        	_gid("l_"+mid).className="closed";
        	_gid("m_"+mid).className="hidden";
	}

	return false;
}
function hedit(mid){
        if (_gid("r_"+mid).className == "shown")
	{
        	_gid("r_"+mid).className="hidden";
        	_gid("e_"+mid).className="shown";
	}
	else
	{
        	_gid("r_"+mid).className="shown";
        	_gid("e_"+mid).className="hidden";
	}

	return false;
}
function mover(e,m){e.style.background = (m=="on") ? '#efefef' : '';}
function lTrim(str){
   var whitespace = new String(" \t\n\r");

   var s = new String(str);

   if (whitespace.indexOf(s.charAt(0)) != -1) {
      var j=0, i = s.length;
      while (j < i && whitespace.indexOf(s.charAt(j)) != -1)
         j++;
      s = s.substring(j, i);
   }
   return s;
}
function rTrim(str){
   var whitespace = new String(" \t\n\r");

   var s = new String(str);

   if (whitespace.indexOf(s.charAt(s.length-1)) != -1) {
      var i = s.length - 1;
      while (i >= 0 && whitespace.indexOf(s.charAt(i)) != -1)
         i--;
      s = s.substring(0, i+1);
   }
   return s;
}
function trim(str){return rTrim(lTrim(str));}
function isValidName(n){
	if (n.length > 60)
  		return false;
	var regex = /[_\-\.a-zA-Z0-9]$/;
	return regex.test(n);
}
function isValidPhone(p){
	var regex = /[1-9][0-9]{2}-[0-9]{4}/;
	return regex.test(p);
}

/*
* Disable "Enter" key in Form script- By Nurul Fadilah(nurul@volmedia.com)
* This notice must stay intact for use
* Visit http://www.dynamicdrive.com/ for full source code
*
* Note: Code customized by Garry Lienhard for use in Sambar Webmail.
*/
function handleEnter(field, event){
	var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
	if (keyCode == 13) 
	{
		var i;
		var found = 0;

		i = 0; 
		while (i < field.form.elements.length)
		{
			if (field == field.form.elements[i])
			{
				found = 1;
			}
			else if (found)
			{
				var nfield = field.form.elements[i];
				if ((nfield.type == "text") ||
					(nfield.type == "textarea") ||
					(nfield.type == "password"))
				{
					nfield.focus();
					return false;
				}
			}

			i++;
		}

		return false;
	} 
	else
	{
		return true;
	}      
}
function createCookie(name,value,days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*86400000));
		var expires = "; expires=" + date.toGMTString();
	} else var expires = "";
	document.cookie = name+"="+escape(value)+expires+"; path=/";
}
function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return unescape(c.substring(nameEQ.length,c.length));
	}
	return null;
}
function lz(x) {
    var t = String(x);
    return t.length == 1 ? "0" + t : t;
}
//Save List
var sl = new Object();
sl.init = function () {
   this.items = new Object();
   var packed=readCookie("sl")
   if(packed && packed != "empty"){
      var splitItems = packed.split("^")
      for (i in splitItems) {
         var parts = splitItems[i].split("=");
         this.items[unescape(parts[0])] = unescape(parts[1]);
      }
      if (document.getElementById("slCount")) {
         var count = this.count();
         document.getElementById("slCount").childNodes[0].nodeValue=count;
      }
   }
}
sl.edit = function(add, id) {
   var outState = 0;
   this.init();
   if (add && this.count() < 50) {
      var d = new Date();
      this.items[id] = '' + d.getFullYear() + '/' + lz(d.getMonth()+1) + '/' + lz(d.getDate());
      outState = 1
   } else {
      delete this.items[id];
      outState = 0
   }
   createCookie("sl", this.toString(), 730);
   if (document.getElementById("slCount")) {
      var count = this.count();
      document.getElementById("slCount").childNodes[0].nodeValue=count;
   }
   return outState;
}
sl.contains = function(id) {
   return typeof(this.items[id]) != 'undefined';
}
sl.toString = function () {
   var out="";
   for (id in this.items) {
      if (out!="") out += "^";
      out += escape(id) + "=" + escape(this.items[id]);
   }
   if (out=="") out="empty";
   return out;
}
sl.count = function () {
   var s = readCookie("sl");
   if (s==null || s.length==0 || s=="empty") return 0;
   var parts = s.split("^");
   if (parts==null) return 0;
   return parts.length;
}
sl.click = function(elem) {
    var isAdd = (elem.className=='save off');
    var isAdded = sl.edit(isAdd, elem.id);
    elem.className=(isAdded?'save on':'save off');
    elem.childNodes[0].childNodes[0].nodeValue=(isAdded?"Saved":"Save it");
}
function showSave(id) {
    document.write('<span class="'+(sl.contains(id)?"save on":"save off")+'" id="'+id+'" onclick="sl.click(this)"><span class="msg">'+(sl.contains(id)?"Saved":"Save it")+'</span></span>');
}
