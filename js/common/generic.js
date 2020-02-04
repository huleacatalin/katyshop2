
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

function validateInt(str, min, max)
{
	if(min + "" == "undefined")
		min = -1;
	if(max + "" == "undefined")
		max = -1;
	if(parseInt(str) != str)
		return false;
	str *= str;
	if((str < min && min != -1) || (str > max && max != -1))
		return false;
	return true;
}

function validateFloat(str, min, max)
{
	if(min + "" == "undefined")
		min = -1;
	if(max + "" == "undefined")
		max = -1;
	if(parseFloat(str) != str)
		return false;
	str *= 1;
	if((str < min && min != -1) || (str > max && max != -1))
		return false;
	return true;
}

function defined(x)
{
	return (x + "" != "undefined");
}

function httpGetAllParams(excludeKeys)
{
	if(excludeKeys + "" == "undefined")
		excludeKeys = new Array();
	
	var s = "";
	var href = window.location.href;
	if(href.indexOf("?") == -1)
		return "";
	// return only the part of querystring after the question mark:
	href = href.substr(href.indexOf("?") + 1);
	if(href.indexOf("&") == -1)
		return href;
	var arr = href.split("&");
	for(var i = 0; i < arr.length; i++)
	{
		var temp = arr[i];
		if(temp.indexOf("=") != -1)
			temp = temp.substring(0, temp.indexOf("="));
		if(!in_array(temp, excludeKeys))
		{
			if(s.length > 0)
				s += "&";
			s += arr[i];
		}
	}
	return s;
}

// kinda' print_r()
function showObjectMembers(ob)
{
	var s = "";
	for(var i in ob)
	{
		s += "\r\n" + i + ": " + ob[i];
	}
	alert(s);
}
