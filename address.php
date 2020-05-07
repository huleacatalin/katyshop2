<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(__FILE__) . "/init.php");
require_once(WEB_DIR . "/includes/req_person_company.php");

$user = Application::getUser();
$db = Application::getDb();
$counties = Application::getConfigValue("counties");

if(@$_GET["detail"] == "true")
{
	if(!array_key_exists("id", $_GET))
	{
		$address = SessionWrapper::get("editAddress");
		if(!is_a($address, "Address"))
			$address = new Address();
	}
	else
	{
		$address = $db->tbAddress->getRecordById(@$_GET["id"]);
		if($address->id_user != $user->id)
			$address = new Address();
	}
}
else {
	$addresses = $db->tbAddress->getRecordsByUserId($user->id, @$_GET["condition"]);
}
$theme = SessionWrapper::get('html_theme');
require_once(dirname(__FILE__) . "/html/$theme/address.php");
?>