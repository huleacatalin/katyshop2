
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

function deleteCategory(id_category)
{
	if(confirm("Are you sure you want to delete this category?"))
	{
		var frm = document.getElementById("frm_delete_category");
		frm.id_category.value = id_category;
		frm.submit();
	}
}

function changeCategoryPicture()
{
	var x = document.getElementById("the_picture");
	x.style.display = "inline";
	x.disabled = false;
}

function category_moveUp(id_category)
{
	var frm = document.getElementById("frm_change_category_position");
	frm["id_category"].value = id_category;
	frm["direction"].value = "up";
	frm.submit();
}

function category_moveDown(id_category)
{
	var frm = document.getElementById("frm_change_category_position");
	frm["id_category"].value = id_category;
	frm["direction"].value = "down";
	frm.submit();
}

function activateCategory(id_category)
{
	var frm = document.getElementById("frm_change_category_active_state");
	frm["id_category"].value = id_category;
	frm["active"].value = 1;
	frm.submit();
}

function deactivateCategory(id_category)
{
	var frm = document.getElementById("frm_change_category_active_state");
	frm["id_category"].value = id_category;
	frm["active"].value = 0;
	frm.submit();
}
