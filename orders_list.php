<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(__FILE__) . "/init.php");
require_once(WEB_DIR . "/includes/req_person_company.php");

$orderStatuses = Order::getPossibleStatuses();

$db = Application::getDb();
$user = Application::getUser();
$arr = Compat::array_clone(@$_GET);
$arr["id_user"] = $user->id;
$orders = $db->tbOrder->search($arr, @$_GET["start"], @$_GET["rowsPerPage"], @$_GET["order_by"], @$_GET["order_direction"]);
$ordersCount = $db->tbOrder->getCount($arr, @$_GET["start"], @$_GET["rowsPerPage"], @$_GET["order_by"], @$_GET["order_direction"]);

$theme = SessionWrapper::get('html_theme');
require_once(dirname(__FILE__) . "/html/$theme/orders_list.php");
?>