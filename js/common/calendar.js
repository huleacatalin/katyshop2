
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

//###########################
//# CALENDAR CONFIG			#
//###########################

// how should dates be displayed on website?
var cal_conf = new Array();
cal_conf["date"] = "YYYY-MM-DD";
cal_conf["time"] = "H:i:s";
//cal_conf["date_time"] = "YYYY-MM-DD H:i:s";
cal_conf["date_time"] = "YYYY-MM-DD H:i";
cal_conf["separator_date"] = "-";
cal_conf["separator_time"] = ":";
cal_conf["separator_date_time"] = " ";

cal_conf["start_year"] = 1970;
cal_conf["end_year"] = 2050;

var FORM_NAME = "submit_form";
var INPUT_NAME = "calendar";
var DATE_TYPE = "date";

//###########################
//# MAIN WINDOW				#
//###########################

/**
 * formName and inputName will be used to get date value like this:
 * var dateValue = document.forms[formName][inputName];
 *
 * dateType may have one of two string values:
 *  - "date" - a string date, like "2006-08-14"
 *  - "dateTime" - a date time value, like "2006-08-14 15:22:45"
 */
function openCalendar(inputName, dateType, formName)
{
	if(formName + "" == "undefined")
		formName = FORM_NAME;
	if(inputName + "" == "undefined")
		inputName = INPUT_NAME;
	if(dateType + "" == "undefined")
		dateType = DATE_TYPE;

	var addr = "calendar.html?";
	addr += "formName=" + escape(formName) + "&";
	addr += "inputName=" + escape(inputName) + "&";
	addr += "dateType=" + escape(dateType) + "&";
	addr += "str=" + escape(document.forms[formName][inputName].value) + "&";
	
	addr += "format_date=" + escape(cal_conf["date"]) + "&";
	addr += "format_time=" + escape(cal_conf["time"]) + "&";
	addr += "format_date_time=" + escape(cal_conf["date_time"]) + "&";
	addr += "separator_date=" + escape(cal_conf["separator_date"]) + "&";
	addr += "separator_time=" + escape(cal_conf["separator_time"]) + "&";
	addr += "separator_date_time=" + escape(cal_conf["separator_date_time"]) + "&";
	addr += "start_year=" + escape(cal_conf["start_year"]) + "&";
	addr += "end_year=" + escape(cal_conf["end_year"]) + "&";
	
	popupCalendar(addr);
}

function popupCalendar(addr)
{
	var features = "channelmode=no,directories=no,fullscreen=no,height=300,left=50,location=no,";
	features += "menubar=no,resizable=yes,scrollbars=no,status=yes,toolbar=no,top=50,width=300";
	window.open(addr, "calendar", features);
}

//###########################
//# CALENDAR POP-UP			#
//###########################

var monthArray = new Array("January", "February", "March", "April", "May", "June", 
					"July", "August", "September", "October", "November", "December");
var daysOfWeek = new Array("Sun","Mon","Tue","Wed","Thu","Fri","Sat");

function getQueryString() {
	var arr = new Array();
	var str = window.location + "";

	str = str.split("?");
	if(str.length < 2)
		return arr;
	str = str[1];
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

function maxDaysInMonth(year, month) {
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

function getCalendar(year, month, day) {
	var s = "";
	var i = 0;
	var j = 0;
	var arr = getDaysArray(year, month);

	s = "<table border=\"0\" width=\"100%\">";
	s += "<tr>";
	for(i = 0; i < 7; i++)
		s += "<td align=\"center\">" + daysOfWeek[i] + "</td>";
	s += "</tr>";
	for(i = 0; i < 6; i++) {
		s += "<tr>";
		for(j = 0; j < 7; j++) {
			s += "<td onclick=\"changeDay('" + arr[i][j] + "');\" ";
			s += "style=\"cursor:hand;"
			if(day != "" && day == arr[i][j])
				s += "background-color:#77aaff;";
			if(j == 0 || j == 6)
				s += "color: #ff0000;";
			s += "\" align=\"right\">";
			s += arr[i][j] + "&nbsp;</td>";
		}
		s += "</tr>";
	}
	return s;
}

// returns the array of days from the mm monnth and yyyy year.
// formated for the 6 X 7 calendar table: first x days before the 1'st
// of the month are blank; also what is left behind the max number of days
// are blank cells.
function getDaysArray(year, month) {
	var arr = new Array();
	var d = new Date();
	var max = maxDaysInMonth(year, month);

	if(year != "" && month != "") {
		d.setFullYear(year);
		d.setMonth(month - 1);
		d.setDate(1);
		var day = d.getDay();
		for(var i = 0; i < 6; i++) {
			arr[i] = new Array();
			for(var j = 0; j < 7; j++) {
				var k = ((i * 7) + j - day + 1);
				k = (k < 1 || k > max) ? "" : k;
				arr[i][j] = k;
			}
		}
	}
	else {
		for(var i = 0; i < 6; i++) {
			arr[i] = new Array();
			for(var j = 0; j < 7; j++)
				arr[i][j] = "";
		}
	}
	return arr;
}

function changeCalendar() {
	var year = document.getElementById("calendarYear").value;
	var month = document.getElementById("calendarMonth").value;
	var day = document.getElementById("calendarDay").value;
	if(year != "" && month != "" && day != "") {
		var max = maxDaysInMonth(year, month);
		if(max < day) {
			day = max;
			document.getElementById("calendarDay").value = day;
		}
	}
	else {
		document.getElementById("calendarDay").value = "";
		day = "";
	}
	var s = getCalendar(year, month, day);
	var cal = document.getElementById("calendar");
	cal.innerHTML = s;
}

function changeDay(day) {
	dctl = document.getElementById("calendarDay").value = day;
	changeCalendar();
}

function initCalendar() {
	var yctl = document.getElementById("calendarYear");
	var mctl = document.getElementById("calendarMonth");
	var dctl = document.getElementById("calendarDay");
	
	var args = getQueryString();
	var df = new DateFormat();

	if(args["dateType"][0] == "dateTime")
	{
		df.readDateTime(args["str"][0], args["format_date_time"][0], args["separator_date"][0], args["separator_date_time"][0], args["separator_time"][0]);
		document.getElementById("calendarHour").value = df.hour;
		document.getElementById("calendarMinutes").value = df.minute;
		document.getElementById("calendarSeconds").value = df.second;
		document.getElementById("hourContainer").style.display = "";
	}
	else
	{
		df.readDate(args["str"][0], args["format_date"][0], args["separator_date"][0]);
		document.getElementById("hourContainer").style.display = "none";
	}
	
	var year = df.year;
	var month = df.month;
	var day = df.day;
	
	for(var i = args["start_year"][0]; i <= args["end_year"][0]; i++) {
		var opt = new Option();
		opt.value = i;
		opt.text = i;
		yctl.length++;
		yctl.options[yctl.length - 1] = opt;
		if(i == year) 
			yctl.options[yctl.length - 1].selected = true;
	}
	
	for(var i = 0; i < monthArray.length; i++) {
		var opt = new Option();
		opt.value = i + 1;
		opt.text = monthArray[i];
		mctl.length++;
		mctl.options[mctl.length - 1] = opt;
		if(i + 1 == month)
			mctl.options[mctl.length - 1].selected = true;
	}
	dctl.value = day;
	changeCalendar();

	document.getElementById("btnOk").focus();
}

function calendarOk() {
	var args = getQueryString();
	var arr = new Array();
	arr["year"] = document.getElementById("calendarYear").value;
	arr["month"] = document.getElementById("calendarMonth").value;
	arr["day"] = document.getElementById("calendarDay").value;
	arr["button"] = "ok";

	var all = (arr["year"] != "") && (arr["month"] != "") && (arr["day"] != "");
	var any = (arr["year"] != "") || (arr["month"] != "") || (arr["day"] != "");

	if(any != all) {
		alert("Please select the day of the month,\r\nOr leave all the fields blank.");
		return;
	}
	
	var df = new DateFormat();
	df.year = arr["year"];
	df.month = arr["month"];
	df.day = arr["day"];
	df.hour = document.getElementById("calendarHour").value;
	df.minute = document.getElementById("calendarMinutes").value;
	df.second = document.getElementById("calendarSeconds").value;
	if(!df.validateTime())
	{
		alert("Please enter valid numeric values for hour, minutes and seconds");
		return;
	}
	
	var parentForm = window.opener.document.forms[args["formName"][0]];
	var parentInput = parentForm[args["inputName"][0]];
	
	if(args["dateType"][0] == "dateTime")
		parentInput.value = df.display(args["format_date_time"][0], args["separator_date"][0], args["separator_date_time"][0], args["separator_time"][0]);
	else
		parentInput.value = df.displayDate(args["format_date"][0], args["separator_date"][0]);

	window.close();
}

function calendarCancel() {
	window.close();
}