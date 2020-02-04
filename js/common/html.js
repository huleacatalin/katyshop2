
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */
 
function resizeContent() {
	leftW = document.getElementById('left').offsetWidth;
	rightW = document.getElementById('right').offsetWidth;
	bodyW = document.body.clientWidth;
	newW =  bodyW - leftW - rightW - 50;
	if(newW < 300)
		newW = 300;
	document.getElementById('content').style.setProperty('width', newW);
}
window.onload = resizeContent;
window.onresize = resizeContent;

function setSelectValue(sel, val)
{
	for(var i = 0; i < sel.length; i++)
	{
		if(sel.options[i].value == val)
		{
			sel.options[i].selected = true;
			sel.selectedIndex = i;
		}
		else
		{
			sel.options[i].selected = false;
		}
	}
	//sel.value = val;
}

function toggleSelect(toggle, formName, inputName)
{
	var checked = toggle.checked;
	var frm = document.forms[formName];
	var inputs = frm[inputName];
	if(inputs + "" == "undefined")
		return;

	if(frm["toggle_select"].length + "" != "undefined")
	{
		for(var i = 0; i < frm["toggle_select"].length; i++)
			frm["toggle_select"][i].checked = checked;
	}

	if(inputs.length + "" == "undefined")
	{
		inputs.checked = checked;
	}
	else
	{
		for(var i = 0; i < inputs.length; i++)
		{
			inputs[i].checked = checked;
		}
	}
}

function makeAllInputsFocus()
{
	var inputs = document.getElementsByTagName("input");
	for(var i = 0; i < inputs.length; i++)
	{
		if(inputs[i].type == "text")
			inputs[i].onfocus = new Function ("x", "this.select()");
	}
}

function highlightMenu(td)
{
	var tr = td.parentNode;
	var allTd = tr.getElementsByTagName("td");
	for(var i = 0; i < allTd.length; i++)
	{
		allTd[i].className = "";
	}
	td.className = "focus";
}

function getBaseHref()
{
	var x = document.getElementsByTagName("base");
	if(x.length > 0)
	{
		x = x[0];
		if(defined(x.href))
			return x.href;
	}
	else
	{
		return "";
	}
}

function redirect(page, toBaseHref)
{
	if(!defined(toBaseHref))
		toBaseHref = true;

	var s = getBaseHref();
	if(toBaseHref)
		window.open(s + page, "_self");
	else
		window.open(page, "_self")
}

function changeUrlBySel(sel)
{
	redirect(sel.value);
}

function popupImage(img_src, toBaseHref)
{
	if(!defined(toBaseHref))
		toBaseHref = true;

	var feats = "channelmode=no,directories=no,fullscreen=no,height=300,left=200,location=no,menubar=no,";
	feats += "resizable=yes,scrollbars=yes,status=yes,titlebar=yes,toolbar=no,top=200,width=300";
	var s = getBaseHref();
	if(toBaseHref)
		window.open(s + img_src, "_blank", feats);
	else
		window.open(img_src, "_blank", feats);
}

function showHide(elementId)
{
	var el = document.getElementById(elementId);
	if(el.style.display == "none")
		el.style.display = "";
	else
		el.style.display = "none";
}
