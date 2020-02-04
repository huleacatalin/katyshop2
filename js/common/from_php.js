
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

/**
 * javascript implementation for PHP function number_format(), read PHP manual for that function
 * string number_format ( float number [, int decimals [, string dec_point, string thousands_sep]] )
 */
function number_format(number, decimals, dec_point, thousands_sep)
{
	var s = "";
	
	// make default value for number
	number = parseFloat(number);
	if(isNaN(number))
		number = 0;
	s = number + "";
	
	// make default value for decimals
	decimals = parseInt(decimals);
	if(isNaN(decimals) || decimals < 0)
		decimals = 0;
	if(decimals > 20)
		decimals = 20;
	
	// make default value for dec_point
	if(!defined(dec_point))
		dec_point = ".";
	dec_point += "";
	dec_point = dec_point.substr(0, 1); // only the first char
	
	// make default value for thousands_sep
	if(!defined(thousands_sep))
		thousands_sep = ",";
	thousands_sep += "";
	thousands_sep = thousands_sep.substr(0, 1); // only the first char
	
	// s is now something like: "-10500.4447"
	var arr = s.split("."); // arr[0] is now integer part (-10500) and arr[1] is decimals (4447)
	s = "";
	for(var i = arr[0].length; i > 0; i -= 3)
	{
		var start = (i - 3 >= 0) ? i - 3 : 0;
		s = arr[0].substr(start, i - start) + "" + s;
		if(i > 3 && arr[0].substr(0, start) != "-")
			s = thousands_sep + "" + s;
	}
	
	// s contains now the integer part formatted. Something like "-10,500"
	if(decimals > 0)
	{
		// add decimals part
		s += "" + dec_point;
		var start = 0;
		if(arr.length > 1)
		{
			s += "" + arr[1].substr(0, decimals);
			start = arr[1].length;
		}
		for(var i = start; i < decimals; i++)
			s += "0";
	}
	
	return s;
}

// reverse of number_format() - read a number formatted with number_format()
// and return it as a float
function read_number_format(number, decimals, dec_point, thousands_sep)
{
	var s = "";
	
	// make default value for number
	if(!defined(number))
		number = "";
	s = number + "";

	// make default value for decimals
	decimals = parseInt(decimals);
	if(isNaN(decimals) || decimals < 0)
		decimals = 0;
	if(decimals > 20)
		decimals = 20;
	
	// make default value for dec_point
	if(!defined(dec_point))
		dec_point = ".";
	dec_point += "";
	dec_point = dec_point.substr(0, 1); // only the first char
	
	// make default value for thousands_sep
	if(!defined(thousands_sep))
		thousands_sep = ",";
	thousands_sep += "";
	thousands_sep = thousands_sep.substr(0, 1); // only the first char
	
	var arr = s.split(dec_point);
	var arr0 = arr[0].split(thousands_sep);
	s = "";
	for(var i = 0; i < arr0.length; i++)
		s += "" + arr0[i];
	if(arr.length > 1)
		s += "." + arr[1];

	s = parseFloat(s);
	if(isNaN(s))
		s = 0;

	return s;
}

// js aproximate implementation of parse_url() function from php.
// If url is partial, it will not work exactly the same as in php.
// Example:
// $ php -r 'print_r(parse_url("http://username:password@hostname:8080/path?arg=value#anchor"));'
// Array
// (
//     [scheme] => http
//     [host] => hostname
// 	   [port] => 8080
//     [user] => username
//     [pass] => password
//     [path] => /path
//     [query] => arg=value
//     [fragment] => anchor
// )
function parse_url(url)
{
	var ret = {"scheme": "", "host": "", "port": "", "user": "", "pass": "", 
				"path": "", "query": "", "fragment": ""};
	var s = url;
	var arr = s.split("://");
	if(arr.length > 1)
	{
		// parse "scheme": "", "host": "", "port": "", "user": "", "pass": ""
		// only if scheme was in url, otherwise it is a partial url
		ret["scheme"] = arr[0];
		s = "";
		for(var i = 1; i < arr.length; i++)
		{
			if(i > 1)
				s += "://";
			s += arr[i];
		}

		// s is now username:password@hostname:8080/path?arg=value#anchor
		arr = s.split("/");
		var arr2 = arr[0].split("@");
		var userPart = ""; // username:password
		var hostPart = ""; // hostname:8080
		
		// parse username:password@hostname:8080 into userPart and hostPart
		if(arr2.length == 1)
		{
			hostPart = arr2[0];
		}
		else
		{
			userPart = arr2[0];
			for(var i = 1; i < arr2.length; i++)
			{
				if(i > 1)
					hostPart += "@";
				hostPart += arr2[i];
			}
		}
		
		// parse userPart = username:password
		if(userPart.length > 0)
		{
			var arr3 = userPart.split(":");
			ret["user"] = arr3[0]; // "username"
			for(i = 1; i < arr3.length; i++)
			{
				if(i > 1)
					ret["pass"] += ":";
				ret["pass"] += arr3[i]; // in the end, it will be like "password"
			}
		}
		
		// parse hostPart = hostname:8080
		if(hostPart.length > 0)
		{
			var arr3 = hostPart.split(":");
			ret["port"] = arr3[arr3.length - 1]; // "8080"
			ret["host"] = "";
			for(i = 0; i < arr3.length - 1; i++)
			{
				if(i > 0)
					ret["host"] += ":";
				ret["host"] += arr3[i]; // in the end, it will be like "8080"
			}
		}
		
		s = "";
		for(var i = 1; i < arr.length; i++)
			s += "/" + arr[i];
		// s is now /path?arg=value#anchor
		
	}
	
	arr = s.split("#");
	var pathPart = arr[0] // /path?arg=value
	for(i = 1; i < arr.length; i++)
	{
		if(i > 1)
			ret["fragment"] += "#";
		ret["fragment"] += arr[i]; // anchor
	}
	
	arr = pathPart.split("?");
	ret["path"] = arr[0];
	for(var i = 1; i < arr.length; i++)
	{
		if(i > 1)
			ret["query"] += "?";
		ret["query"] += arr[i];
	}
	
	return ret;
}

// aproximate js implementation of parse_str() from php.
// it's not working the same when you pass parameters like "arg[]=val1&arg[]=val2"
// returns the array of values
// Example:
// var q = "arg1=value1&arg1=value2&arg2=value3";
// var arr = parse_str(q);
// arr it will be:
// arr["arg1"][0] = "value1";
// arr["arg1"][1] = "value2";
// arr["arg2"][0] = "value3";
function parse_str(query)
{
	var arr = new Array();
	var str = query;

	str = str.split("&");
	for(var i = 0; i < str.length; i++) {
		var temp = str[i].split("=");
		if(arr[temp[0]] + "" == "undefined") {
			arr[temp[0]] = new Array();
		}
		var x = arr[temp[0]].length;
		arr[temp[0]][x] = (temp[1] + "" != "undefined") ? unescape(temp[1]) : "";
	}
	return arr;
}

/**
 * Similar to in_array function from php
 */
function in_array(needle, haystack)
{
	for(key in haystack)
	{
		if(haystack[key] == needle)
			return true;
	}
	
	return false;
}
