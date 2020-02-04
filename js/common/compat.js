
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

function isGecko()
{
	return (window.navigator.product == "Gecko");
}

function isIE()
{
	return (window.navigator.appName == "Microsoft Internet Explorer");
}

function isOpera()
{
	return (window.navigator.appName == "Opera");
}

function getEvent(func)
{
	if(isGecko())
		return func.arguments[func.arguments.length - 1];
	else
		return window.event;
}

function getSrcElement(ev)
{
	if(isGecko())
		return ev.target;
	else
		return ev.srcElement;
}

function cancelEvent(ev)
{
	if(isOpera())
	{
		ev.stopPropagation();
		ev.preventDefault();
		ev.cancelBubble = true;
	}
	else if(isIE())
	{
		ev.returnValue = false;
		ev.cancelBubble = true;
	}
	else
	{
		ev.stopPropagation();
		ev.cancelBubble = true;
		ev.preventDefault();
	}
	return false;
}
