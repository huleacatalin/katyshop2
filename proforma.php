<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(__FILE__) . "/init.php");
require_once(WEB_DIR . "/includes/req_person_company.php");

$filename = DATA_DIR . "/orders/{$_GET["code"]}.html";
$db = Application::getDb();
$user = Application::getUser();
$order = $db->tbOrder->getRecordByCode(@$_GET["code"]);
if($order->id_user != $user->id)
{
	die(translate("Proforma invoice cannot be displayed because it doesn't belong to you"));
}
elseif (!is_file($filename))
{
	die(translate("Could not find the file that contains proforma invoice informations"));
}
else
{
	$s = file_get_contents($filename);
	$s = Tools::decrypt($s, Application::getConfigValue('openssl_key'));
	echo $s;
}


?>