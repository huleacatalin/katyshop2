<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(__FILE__) . "/init.php");

$user = Application::getUser();
if(!$user->isUserLoggedIn())
	Tools::redirect("index.php");
$updateUser = SessionWrapper::get("updateUser");
if(!is_a($updateUser, "User"))
{
	$updateUser = Factory::instantiateUser($user);
}
$db = Application::getDb();
$addressesCount = $db->tbAddress->getCount(array("id_user" => $user->id));

$theme = SessionWrapper::get('html_theme');
require_once(dirname(__FILE__) . "/html/$theme/profile.php");
?>