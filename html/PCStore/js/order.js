
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

function removeOrderProduct(line_number)
{
	var frm = document.getElementById("frm_remove_product");
	frm["line_number"].value = line_number;
	frm.submit();
}

function sendOrder()
{
	var frm = document.getElementById("frm_update_basket");
	frm["next_step"].value = "1";
	frm.submit();
}

function selectOrderAddress(id_address)
{
	var frm = document.getElementById("frm_select_address");
	frm["id_address"].value = id_address;
	frm.submit();
}
