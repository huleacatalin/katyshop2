
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

function changeManufacturerPicture()
{
	var x = document.getElementById("the_picture");
	x.style.display = "";
	x.disabled = false;
	resizeContent();
}

function deleteManufacturer(id_manufacturer)
{
	if(confirm("Are you sure you want to delete this manufacturer?"))
	{
		var frm = document.getElementById("frm_delete_manufacturer");
		frm.id.value = id_manufacturer;
		frm.submit();
	}
}
