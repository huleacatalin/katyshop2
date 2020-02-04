<?php

/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(dirname(dirname(__FILE__))) . "/init.php");
require_once(WEB_DIR . "/includes/req_admin.php");

$db = Application::getDb();
if(@$_GET["action"] == "change_status")
{
	if(!$db->tbOrder->orderExists(@$_POST["id_order"]))
		Application::addError("Could not find the order to change status");
	if(!in_array(@$_POST["status"], Order::getPossibleStatuses()))
		Application::addError("Please choose a valid status for the order");
	if(@$_POST["status"] == "in cart")
		Application::addError("The order already sent cannot have the 'in cart' status");

	if(!Application::hasErrors())
	{
		$am = Application::getMailAgent();
		$am->orderStatusChanged(@$_POST["id_order"], @$_POST["status"]);
		$db->tbOrder->changeStatus(@$_POST["id_order"], @$_POST["status"]);
		Application::addMessage("Order status has been changed");
	}
	Tools::redirect("../order.php?action=detail&id=" . intval(@$_POST["id_order"]));
}

?>