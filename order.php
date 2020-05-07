<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(__FILE__) . "/init.php");
require_once(WEB_DIR . "/includes/req_person_company.php");

$db = Application::getDb();
$user = Application::getUser();
$order = $db->tbOrder->getRecordById(@$_GET["id"]);

if($order->id == 0)
{
	$order = Application::getShoppingCart();
}
elseif($order->id_user != $user->id)
{
	Application::addError("Selected order cannot be displayed because it doesn't belong to you");
	Tools::redirect("index.php");
	exit();
}

$order->computeValue();

$theme = SessionWrapper::get('html_theme');
require_once(dirname(__FILE__) . "/html/$theme/order.php");
?>