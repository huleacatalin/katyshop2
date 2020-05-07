<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(__FILE__) . "/init.php");
require_once(WEB_DIR . "/includes/req_person_company.php");

$db = Application::getDb();
$user = Application::getUser();
$pageTitle = "";
$noAddressText = "";
$addresses = array();
if(@$_GET["action"] == "select_delivery_address")
{
	$pageTitle = translate("Select delivery address");
	$noAddressText = "delivery";
	$addresses = $db->tbAddress->getRecordsByUserId($user->id, "delivery");
}
elseif(@$_GET["action"] == "select_invoice_address")
{
	$pageTitle = translate("Select invoicing address");
	$noAddressText = "invoicing";
	$addresses = $db->tbAddress->getRecordsByUserId($user->id, "invoicing");
}

$theme = SessionWrapper::get('html_theme');
require_once(dirname(__FILE__) . "/html/$theme/shopping_cart_address.php");
?>