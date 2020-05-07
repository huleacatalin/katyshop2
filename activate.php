<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(__FILE__) . "/init.php");

if(!empty($_GET["username"]))
{
	$db = Application::getDb();
	$u = $db->tbUser->getUserByUsername($_GET["username"]);
	$u = Factory::instantiateUser($u);
	if($u->id == 0)
	{
		Application::addError("This username could not be found");
	}
	elseif($u->isActive())
	{
		Application::addMessage("Account is active you may now login");
		Tools::redirect("login.php", true);
	}
	elseif($u->isDeactivated())
	{
		Application::addError("This user has been deactivated by an admin and cannot be used for login. Please contact the support department");
	}
	elseif($u->activation_code == @$_GET["activation_code"])
	{
		$u->activate();
		$db->tbUser->updateObj($u);
		Application::addMessage("Congratulations, your account has been activated. You may now login.");
		Tools::redirect("login.php", true);
	}
	elseif($u->activation_code != @$_GET["activation_code"])
	{
		Application::addError("Wrong activation code");
	}
}
$theme = SessionWrapper::get('html_theme');
require_once(dirname(__FILE__) . "/html/$theme/activate.php");
?>