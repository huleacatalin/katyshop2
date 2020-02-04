
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

function DateFormat()
{
    this.year       = 0;
    this.month      = 1;
    this.day        = 1;
    this.hour       = 0;
    this.minute     = 0;
    this.second     = 0;
    this.partsecond = parseFloat(0);
    
    // methods
	this.clear = DateFormat_clear;
	this.readDate = DateFormat_readDate;
	this.readTime = DateFormat_readTime;
	this.readDateTime = DateFormat_readDateTime;
	this.display = DateFormat_display;
	this.displayDate = DateFormat_displayDate;
	this.displayTime = DateFormat_displayTime;
	this.validateDate = DateFormat_validateDate;
	this.validateTime = DateFormat_validateTime;
	this.validate = DateFormat_validate;
	this.maxDaysInMonth = DateFormat_maxDaysInMonth;
}

function DateFormat_clear()
{
    this.year       = 0;
    this.month      = 1;
    this.day        = 1;
    this.hour       = 0;
    this.minute     = 0;
    this.second     = 0;
    this.partsecond = parseFloat(0);
}

function DateFormat_readDate(str, format, separator, clear)
{
	if(format + "" == "undefined")
		var format = "YYYY-MM-DD";
	if(separator + "" == "undefined")
		var separator = "-";
	if(clear + "" == "undefined")
		var clear = true;
	
	if(clear)
		this.clear();

    var arr = str.split(separator);
    var orderBy = format.split(separator);
    if(arr.length != orderBy.length)
    	return false;
	
	for(var i = 0; i < orderBy.length; i++)
	{
		switch (orderBy[i])
		{
			case "YYYY":
				this.year = arr[i];
				break;
			case "MM":
				this.month = arr[i];
				break;
			case "DD":
				this.day = arr[i];
				break;
		}
	}
	return true;
}

function DateFormat_readTime(str, format, separator, clear)
{
	if(format + "" == "undefined")
		var format = "H:i:s";
	if(separator + "" == "undefined")
		var separator = ":";
	if(clear + "" == "undefined")
		var clear = true;
		
	if(clear)
		this.clear();
    
    var arr = str.split(separator);
    var orderBy = format.split(separator);
    if(arr.length != orderBy.length)
    	return false;
	
	for(i = 0; i < orderBy.length; i++)
	{
		switch (orderBy[i])
		{
			case "H":
				this.hour = arr[i];
				break;
			case "i":
				this.minute = arr[i];
				break;
			case "s":
				this.second = arr[i];
				break;
		}
	}
	return true;
}

function DateFormat_readDateTime(str, format, dateSeparator, dateTimeSeparator, timeSeparator)
{
	if(format + "" == "undefined")
		var format = "YYYY-MM-DD H:i:s";
	if(dateSeparator + "" == "undefined")
		var dateSeparator = "-";
	if(dateTimeSeparator + "" == "undefined")
		var dateTimeSeparator = " ";
	if(timeSeparator + "" == "undefined")
		var timeSeparator = ":";
	
	this.clear();
	
	var arr = str.split(dateTimeSeparator);
	var orderBy = format.split(dateTimeSeparator);
    if(arr.length != orderBy.length)
    	return false;
	
	for(i = 0; i < orderBy.length; i++)
	{
		if(orderBy[i].indexOf("YYYY") != -1)
		{
			var temp = this.readDate(arr[i], orderBy[i], dateSeparator, false);
			if(!temp)
				return false;
		}
		else if(orderBy[i].indexOf("H") != -1)
		{
			var temp = this.readTime(arr[i], orderBy[i], timeSeparator, false);
			if(!temp)
				return false;
		}
	}
	return true;
}

function DateFormat_display(format, dateSeparator, dateTimeSeparator, timeSeparator)
{
	if(format + "" == "undefined")
		var format = "YYYY-MM-DD H:i:s";
	if(dateSeparator + "" == "undefined")
		var dateSeparator = "-";
	if(dateTimeSeparator + "" == "undefined")
		var dateTimeSeparator = " ";
	if(timeSeparator + "" == "undefined")
		var timeSeparator = ":";
		
	var str = "";
	var arr = format.split(dateTimeSeparator);
	for(var i = 0; i < arr.length; i++)
	{
		if(i > 0)
			str += dateTimeSeparator;
		if(arr[i].indexOf("YYYY") != -1)
		{
			str += this.displayDate(arr[i], dateSeparator);
		}
		else if (arr[i].indexOf("H") != -1)
		{
			str += this.displayTime(arr[i], timeSeparator);
		}
	}
	return str;
}

function DateFormat_displayDate(format, separator)
{
	if(format + "" == "undefined")
		var format = "YYYY-MM-DD";
	if(separator + "" == "undefined")
		var separator = "-";
	
	if(this.month.length < 2)
		this.month = "0" + this.month;
	if(this.day.length < 2)
		this.day = "0" + this.day;
		
	var str = "";
	var arr = format.split(separator);
	for(i = 0; i < arr.length; i++)
	{
		if(i > 0)
			str += separator;
		switch (arr[i])
		{
			case "YYYY":
				str += this.year;
				break;
			case "MM":
				str += this.month;
				break;
			case "DD":
				str += this.day;
				break;
		}
	}
	return str;
}

function DateFormat_displayTime(format, separator)
{
	if(format + "" == "undefined")
		var format = "H:i:s";
	if(separator + "" == "undefined")
		var separator = ":";
	
	if(this.hour.length < 2)
		this.hour = "0" + this.hour;
	if(this.minute.length < 2)
		this.minute = "0" + this.minute;
	if(this.second.length < 2)
		this.second = "0" + this.second;
	
	var str = "";
	var arr = format.split(separator);
	for(i = 0; i < arr.length; i++)
	{
		if(i > 0)
			str += separator;
		switch (arr[i])
		{
			case "H":
				str += this.hour;
				break;
			case "i":
				str += this.minute;
				break;
			case "s":
				str += this.second;
				break;
		}
	}
	return str;
}

function DateFormat_validateDate(minYear, maxYear)
{
	if(minYear + "" == "undefined")
		var minYear = 1970;
	if(maxYear + "" == "undefined")
		var maxYear = 2050;
	
	if(isNaN(this.year) || isNaN(this.month) || isNaN(this.day))
		return false;
	if(parseInt(this.year) < minYear || parseInt(this.year) > maxYear)
		return false;
	if(parseInt(this.month) < 1 || parseInt(this.month) > 12)
		return false;
	if(parseInt(this.day) < 1 || parseInt(this.day) > 31)
		return false;
		
	var maxDays = this.maxDaysInMonth(this.year, this.month);
	if(this.day > maxDays)
		return false;

	return true;
}

function DateFormat_validateTime()
{
	if(isNaN(this.hour) || isNaN(this.minute) || isNaN(this.second))
		return false;
	if(parseInt(this.hour) < 0 || parseInt(this.hour) > 24)
		return false;
	if(parseInt(this.minute) < 0 || parseInt(this.minute) > 60)
		return false;
	if(parseInt(this.second) < 0 || parseInt(this.second) > 60)
		return false;
	return true;
}

function DateFormat_validate(minYear, maxYear)
{
	if(minYear + "" == "undefined")
		var minYear = 1970;
	if(maxYear + "" == "undefined")
		var maxYear = 2050;

	return this.validateDate(minYear, maxYear) && this.validateTime();
}

function DateFormat_maxDaysInMonth(year, month) {
	var leap = false;
	var max = 30;

	if(year % 400 == 0) {
		leap = true;
	}
	else {
		if(year % 100 == 0) {
			leap = false;
		}
		else {
			if(year % 4 == 0) {
				leap = true;
			}
		}
	}

	if(month == 2) {
		if(leap == 1) {
			max = 29;
		}
		else {
			max = 28;
		}
	}
	else {
		if(month % 2 == 1) {
			if(month < 8) max = 31;
		}
		else {
			if(month > 7) max = 31;
		}
	}
	return max;
}



