
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

function deleteAddress()
{
	if(confirm("Are you sure you want to delete this address?"))
	{
		var frm = document.getElementById("frm_delete_address");
		frm.submit();
	}
}
