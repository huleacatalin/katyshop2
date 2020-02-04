<?php

/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(dirname(dirname(__FILE__))) . "/init.php");
require_once(WEB_DIR . "/includes/req_admin.php");

$db = Application::getDb();
if(@$_GET["action"] == "save")
{
	$m = new Manufacturer();
	$m->copyFromArray($_POST);
	if($m->validate())
	{
		if($m->id > 0)
		{
			$old = $db->tbManufacturer->getManufacturerById($m->id);
			$m->picture = $old->picture;
		}
		$db->tbManufacturer->save($m);
		Application::addMessage("Manufacturer has been saved");

		$up = new UploadFile("picture", WEB_DIR . "/img/manufacturers", DATA_DIR . "/temp");
		if(!$up->isEmpty())
		{
			$up->setTmpPrefix("tmpman" . $m->id);
			$up->setPrefix("man" . $m->id);
			$up->validateInput();
			$up->validateImage();
			$up->upload(false);
			$up->resize_limitwh(220, 100);
			if($up->commit($m->picture))
			{
				$m->picture = $up->newFilename;
				$db->tbManufacturer->save($m);
				Application::addMessage("Image changed");
			}
			else
			{
				Application::appendErrors($up->errors);
			}
		}

		if(Application::hasErrors())
		{
			SessionWrapper::set("editManufacturer", $m);
			Tools::redirect("../manufacturer.php?action=detail");
		}
		else
		{
			Tools::redirect("../manufacturer.php?action=detail&id={$m->id}");
		}
	}
	else
	{
		SessionWrapper::set("editManufacturer", $m);
		Tools::redirect("../manufacturer.php?action=detail");
	}
}
elseif (@$_GET["action"] == "delete")
{
	$m = $db->tbManufacturer->getManufacturerById(@$_POST["id"]);
	if($m->id == 0)
	{
		Application::addError("Could not find manufacturer to delete");
		Tools::redirect("../manufacturer.php");
	}
	else
	{
		$db->tbManufacturer->deleteObj($m);
		Application::addMessage("Manufacturer deleted");
		Tools::redirect("../manufacturer.php");
	}
}

?>