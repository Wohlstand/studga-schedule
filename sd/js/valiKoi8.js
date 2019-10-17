// Check that the number of characters in a string is between a max and a min
function isValidLength(string, min, max)
{
        if (string.length < min || string.length > max)
                return false;
        else
                return true;
}

// RSS feed validation
function isValidUrl (url) {
  var regexp = "^((http|https)\://)([a-zA-Z0-9]+)(\.[a-zA-Z0-9]+)+(\:[0-9]+)?([\/a-zA-Z0-9\.\,\;\?\'\\\+&%\$#\=~_\-]+)*$";
  var match = url.match (regexp);
  return (match != null);
}

// Remove leading and trailing whitespace from a string
function trimWhitespace(string)
{
        var newString  = '';
        var substring  = '';
        beginningFound = false;

        // copy characters over to a new string
        // retain whitespace characters if they are between other characters
        for (var i = 0; i < string.length; i++)
        {
                // copy non-whitespace characters
                if (string.charAt(i) != ' ' && string.charCodeAt(i) != 9)
                {
                        // if the temporary string contains some whitespace characters,
                        // copy them first
                        if (substring != '')
                        {
                newString += substring;
                substring = '';
                        }
                        newString += string.charAt(i);
                        if (beginningFound == false)
                                beginningFound = true;
                }
                else if (beginningFound == true)
                {
                        substring += string.charAt(i);
                }
   }
   return newString;
}

function isValidIP(objIP)
{
        var ip = objIP.value;
        if (objIP.length == 0)
                return false;

        // Invalid Format, number of dots is not 3
        if (countChars(ip, ".") != 3)
                return false;

        var arrIP = ip.split(".");
        for (var i = 0; i < 4; i++)
        {
                if ((arrIP[i].length < 1) || (arrIP[i].length > 3))
                {
                        // Invalid Format, multiple dots or more than 3 digits between dots
                        return false;
                }

                if (!isInteger(arrIP[i]))
                {
                        // non-integers present in the value
                        return false;
                }

                arrIP[i] = parseInt(arrIP[i]);

                if (i == 0)
                {
                        // start IP value
                        if ((arrIP[i] == 0) || (arrIP[i] > 223) || (arrIP[i] == 127))
                        {
                                return false;
                        }
                }
                else
                {
                        // the 2nd, 3rd and 4th IP values between the dots
                        // these must not be more than 255
                        if (arrIP[i] > 255)
                        {
                                return false;
                        }
                }
        }

        objIP.value = arrIP.join(".");

        return true;
}

function countChars(s,c)
{
        var spos = 0;
        var fpos =0;
        var count = 0;

        // checking for the null character
        if (c == "")
        {
                return count;
        }
        while((fpos = s.indexOf(c, spos)) >= 0)
        {
                count++;
                spos = fpos + 1;
        }

        return count;
}

function isInteger(s)
{
        var c;
        // checking for null string
        if (s.length==0)
        {
                return false;
        }

        for (var i=0;i < s.length;i++)
        {
                c = s.substring(i,i+1);
                if (c < "0" || c > "9")
                {
                        return false;
                }
        }
        return true;
}

function validateField(e)
{
        var p = e.getAttribute("ptype");

        var re;
        switch (p.toLowerCase())
        {
                case "txt" :
                case "textonly" :               // Text only allowed
                        re = /^[a-z ]*$/i;
                        break;
                case "num" :
                case "number" :                 // Only numbers (allow decimal)
                        re = /^[\d\.]*$/;
                        break;
                case "int" :
                case "integer" :                // Integers only
                        re = /^\d*$/;
                        break;
                case "phonenumber" :    // Phone number characters
                        re = /^[\d \-\(\)\+]*$/;
                        break;
                case "date" :
                        re = /^(()|(\d{1,2}(\/|-)\d{1,2}(\/|-)\d{2,4}))$/;
                        break;
                case "idate" :
                        re = /^(()|(\d{2,4}(\/|-)\d{1,2}(\/|-)\d{1,2}))$/;
                        break;
                case "email" :
                        re = /^.+@[^\.].*\.[a-z]{2,}$/;
                        break;
                case "alnum" :
                case "alphanumeric" :
                        re = /^[\w]*$/i;
                        break;
                case "ipaddress" :              // IP Address rule
                        return isValidIP(e);
                case "addr" :
                case "hostaddress" :    // Address rule
                        re = /^[\w- \.,#]*$/i;
                        break;
                case "name" :
                        re = /^[a-z,0-9,\-\. ]*$/i;
                        break;
                case "uname" :  case "username" :         // User name
                        re = /^[a-z,0-9,\-,\_,\.]*$/g;
                        break;
                case "pwd" :               // Password
                        re = /^[a-z,0-9,\_,\-,\ ,\.,\,,\?,\$,\@]*$/i;
                        break;
                case "path" :
                re = /^[a-z\-\.\d \/]*$/gi
                break;
                case "folder" :
                re = /^[a-z\-\d]*$/gi
                break;
                case "database" :               // Database name
                        re = /^[a-z][a-z,0-9,\-\_]*$/i;
                        break;
                case "notnull" :                // Requires *anything*
                default :
                        re = /.+/;
                        break;
        }

        if (re.test(e.value))
        {
                return true;
        }
        else
        {
                return false;
        }
}

function setError(e, msg)
{
        var name = e.getAttribute("err");
        if (name == null)
                return;

        var err = document.getElementById(name);
        if (err == null)
                return;

        if (msg == null)
        {
                if (err.innerHTML.length > 0)
                        err.innerHTML = String.fromCharCode(160);
        }
        else
        {
                err.innerHTML = "<br/>" + msg + "<br/>";
        }
}

function validateForm(f)
{
        errors = 0;
        err = document.getElementById("validationError");
        if (err)
        {
                err.innerHTML = "";
                err.className = "";
        }

        // Loop through every element in the form specified.
        for (i = 0; i < f.elements.length; i++)
        {
                fe = f.elements[i];

                if (fe.type.toLowerCase() == "text" ||
                        fe.type.toLowerCase() == "textarea" ||
                        fe.type.toLowerCase() == "password")
                {
                        fe.style.background = "#ffffff";
                        setError(fe, null);
                        fe.value = trimWhitespace(fe.value)

                        if (fe.getAttribute("required") && fe.value == '')
                        {
                                fe.style.background = "#ffff99";
                                setError(fe, "Required field.");
                                errors++;
                        }
                else if (fe.getAttribute("maxlength") &&
                                !isValidLength(fe.value, 0, fe.getAttribute("maxlength")))
                        {
                                fe.style.background = "#ffff99";
                                setError(fe, "Field length exceeds maximum: " +
                                        fe.getAttribute("maxlength"));
                                errors++;
                        }
                else if (fe.getAttribute("minlength") &&
                                !isValidLength(fe.value, fe.getAttribute("minlength"),
                                Number.MAX_VALUE))
                        {
                                fe.style.background = "#ffff99";
                                setError(fe, "Field length does not meet the minimum: " +
                                        fe.getAttribute("minlength"));
                                errors++;
                }
                        else if ((fe.value != '') &&
                                fe.getAttribute("ptype") &&
                                !validateField(fe))
                        {
                                fe.style.background = "#ffff99";
                                setError(fe, "Field violates pattern expected (" +
                                        fe.getAttribute("ptype") + ")");
                                errors++;
                        }
                }
        }

        if (errors > 0)
        {
                if (err)
                {
                        err.className = "error";
                        err.innerHTML = "<center>Пожалуйста, исправте записи в выделенных полях.</center>";
                }
                else
                {
                        alert("One or more fields are incomplete or have invalid content; the fields have been highlighted.");
                }

                return false;
        }

        return true;
}
