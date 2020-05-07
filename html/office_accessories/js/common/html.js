
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
	document.body.getElementsByTagName('main')[0].style.setProperty('width', newW);
}
window.onload = resizeContent;
window.onresize = resizeContent;

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

function showHide(elementId)
{
	var el = document.getElementById(elementId);
	if(el.style.display == "none")
		el.style.display = "";
	else
		el.style.display = "none";
}
