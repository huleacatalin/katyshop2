<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(dirname(__FILE__)) . "/init.php");

$user = Application::getUser();
$db = Application::getDb();
if(!$user->isUserLoggedIn())
	Tools::redirect("../login.php");
if($user->isAdminLoggedIn())
{
	Application::addError("Admin accounts cannot have addresses");
	Tools::redirect("../profile.php");
}

if(@$_GET["action"] == "save")
{
	$user = Application::getUser();
	$a = new Address();
	$a->copyFromArray($_POST);
	
	$a->delivery = (intval(@$_POST['delivery']) == 1) ? 1 : 0;
	$a->invoicing = (intval(@$_POST['invoicing']) == 1) ? 1 : 0;
	$a->primary_addr = (intval(@$_POST['primary_addr']) == 1) ? 1 : 0;
	
	$a->id_user = $user->id;
	if($a->validate())
	{
		$db->tbAddress->save($a);
		Application::addMessage("Address has been saved");
		Tools::redirect("../address.php");
	}
	else
	{
		SessionWrapper::set("editAddress", $a);
		Tools::redirect("../address.php?detail=true");
	}
}
elseif(@$_GET["action"] == "toggle_checkbox")
{
	$a = $db->tbAddress->getRecordById(@$_POST["id"]);
	$a->id_user = $user->id;
	$field = @$_POST["field"];
	if(!in_array($field, array("delivery", "invoicing", "primary_addr")))
	{
		Application::addError("Our server could not understand the request sent by your browser");
	}
	else
	{
		$a->$field = ($a->$field == 0) ? 1 : 0;
		if($a->validate())
		{
			$db->tbAddress->save($a);
			Application::addMessage("Address has been saved");
		}
	}
	Tools::redirect("../address.php");
}
elseif (@$_GET["action"] == "delete")
{
	$a = $db->tbAddress->getRecordById(@$_POST["id"]);
	if($a->id == 0)
	{
		Application::addError("Could not find address to delete");
	}
	elseif ($a->id_user != $user->id)
	{
		Application::addError("That address doens't belong to you");
	}
	else
	{
		$db->tbAddress->deleteObj($a);
		Application::addMessage("Address has been deleted");
	}

	Tools::redirect("../address.php");
}
?>