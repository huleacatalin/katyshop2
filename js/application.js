
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

function loadScript(filename)
{
	document.write('<script type="text/javascript" src="js/' + filename + '"></script>');
}

loadScript("common/compat.js");
loadScript("common/generic.js");
loadScript("common/DateFormat.js");
loadScript("common/calendar.js");
loadScript("common/from_php.js");
loadScript("common/html.js");

loadScript("user.js");
loadScript("address.js");
loadScript("category.js");
loadScript("product.js");
loadScript("product_image.js");
loadScript("order.js");
loadScript("manufacturer.js");
