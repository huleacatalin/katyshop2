
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

function resize_window() {
	if(document.body.clientWidth < 600) {
		document.getElementById('responsive_menu').style.display = 'block';
		document.getElementById('HEADER').style.display = 'none';
		document.getElementById('left').style.display = 'none';
		document.getElementById('right').style.display = 'none';
	}
	else if(document.body.clientWidth < 1000) {
		document.getElementById('responsive_menu').style.display = 'none';
		document.getElementById('HEADER').style.display = 'block';
		document.getElementById('left').style.display = 'block';
		document.getElementById('right').style.display = 'none';
	}
	else {
		document.getElementById('responsive_menu').style.display = 'none';
		document.getElementById('HEADER').style.display = 'block';
		document.getElementById('left').style.display = 'block';
		document.getElementById('right').style.display = 'block';
	}
}
window.onresize = resize_window;

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

function showHide2(elementId)
{
	var el = document.getElementById(elementId);
	if(el.style.display == "block")
		el.style.display = "none";
	else
		el.style.display = "block";
}

function responsive_menu() {
	showHide2('HEADER');
	showHide2('left');
}
