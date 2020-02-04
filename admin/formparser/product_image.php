<?php

/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(dirname(dirname(__FILE__))) . "/init.php");
require_once(WEB_DIR . "/includes/req_admin.php");

$db = Application::getDb();
if(@$_GET['action'] == 'delete') {
	$pi = $db->tbProductImage->getRecordById(@$_POST['id_product_image']);
	$pi->deleteFromDb();
	Tools::redirect("../product.php?action=edit&id_product=" . intval($pi->id_product) . "#images");
}
elseif(@$_GET['action'] == 'change_position') {
	$pi = $db->tbProductImage->getRecordById(@$_POST["id_product_image"]);
	if($pi->id == 0)
	{
		Application::addError("Could not find product image to change it's position");
	}
	else
	{
		if(@$_POST["direction"] == "up")
			$pi->pos--;
		elseif (@$_POST["direction"] == "down")
			$pi->pos++;
		else
			Application::addError("You must specify the direction how to change the position");

		$maxPos = $db->tbProductImage->getMaxPos($pi->id_product);
		if($pi->pos < 1)
			$pi->pos = 1;
		elseif ($pi->pos > $maxPos)
			$pi->pos = $maxPos;

		if($pi->validate())
		{
			$db->tbProductImage->updateObj($pi);
			Application::addMessage("Product image's position has been updated");
		}
	}
	Tools::redirect("../product.php?action=edit&id_product=" . intval($pi->id_product) . "#images");
}

?>