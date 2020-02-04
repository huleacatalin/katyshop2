
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

function deleteProduct(id_product)
{
	if(confirm("Are you sure you want to delete this product?"))
	{
		var frm = document.getElementById("frm_delete_product");
		frm.id_product.value = id_product;
		frm.submit();
	}
}

function changeProductPicture()
{
	var x = document.getElementById("the_picture");
	x.style.display = "inline";
	x.disabled = false;
}

function product_moveUp(id_product)
{
	var frm = document.getElementById("frm_change_product_position");
	frm["id_product"].value = id_product;
	frm["direction"].value = "up";
	frm.submit();
}

function product_moveDown(id_product)
{
	var frm = document.getElementById("frm_change_product_position");
	frm["id_product"].value = id_product;
	frm["direction"].value = "down";
	frm.submit();
}

function activateProduct(id_product)
{
	var frm = document.getElementById("frm_change_product_active_state");
	frm["id_product"].value = id_product;
	frm["active"].value = 1;
	frm.submit();
}

function deactivateProduct(id_product)
{
	var frm = document.getElementById("frm_change_product_active_state");
	frm["id_product"].value = id_product;
	frm["active"].value = 0;
	frm.submit();
}
