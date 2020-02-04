
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

function deleteProductImage(id_product_image)
{
	var frm = document.getElementById("frm_delete_product_image");
	frm.id_product_image.value = id_product_image;
	frm.submit();
}

function product_image_moveUp(id_product_image)
{
	var frm = document.getElementById("frm_change_image_position");
	frm["id_product_image"].value = id_product_image;
	frm["direction"].value = "up";
	frm.submit();
}

function product_image_moveDown(id_product_image)
{
	var frm = document.getElementById("frm_change_image_position");
	frm["id_product_image"].value = id_product_image;
	frm["direction"].value = "down";
	frm.submit();
}
