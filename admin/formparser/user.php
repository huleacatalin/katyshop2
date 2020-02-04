<?php

/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(dirname(dirname(__FILE__))) . "/init.php");
require_once(WEB_DIR . "/includes/req_admin.php");


if(@$_GET["action"] == "activate")
{
	$db = Application::getDb();
	$db->tbUser->activate(@$_POST["id"]);
	$s = (@$_POST["detail"] == "true") ? "?action=detail&id=" . intval(@$_POST["id"]) : "";
	Tools::redirect("../user.php$s");
}
elseif(@$_GET["action"] == "deactivate")
{
	$db = Application::getDb();
	$db->tbUser->deactivate(@$_POST["id"]);
	$s = (@$_POST["detail"] == "true") ? "?action=detail&id=" . intval(@$_POST["id"]) : "";
	Tools::redirect("../user.php$s");
}
elseif (@$_GET["action"] == "create_admin")
{
	$user = Application::getUser();
	$registerAdmin = new Admin();

	$registerAdmin->copyFromArray(@$_POST);
	$registerAdmin->acc_type = "admin";
	$registerAdmin->active = 1;
	$registerAdmin->activation_code = "";
	$registerAdmin->login_code = "";
	$registerAdmin->is_admin = 1;
	if($registerAdmin->validateRegister(@$_POST["confirm_password"]))
	{
		$registerAdmin->password = password_hash($registerAdmin->password, PASSWORD_DEFAULT);
		$db = Application::getDb();
		$db->tbUser->insertObj($registerAdmin);

		Application::addMessage("Admin account has been created");
	}

	if(Application::hasErrors())
	{
		SessionWrapper::set("registerAdmin", $registerAdmin);
		Tools::redirect("../user.php?action=create_admin");
	}
	else
	{
		SessionWrapper::set("registerAdmin", "");
		Tools::redirect("../user.php");
	}
}

elseif (@$_GET["action"] == "delete")
{
	$db = Application::getDb();
	$u = $db->tbUser->getUserById(@$_POST["id"]);
	$u = Factory::instantiateUser($u);
	if($u->id == 0)
	{
		Application::addError("Could not find the user to delete");
	}
	else
	{
		$db->tbUser->deleteObj($u);
		Application::addMessage("The user has been deleted");
	}
	Tools::redirect("../user.php");
}

?>
