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
	$c = new Category();
	$c->copyFromArray($_POST);
	if($c->validate())
	{
		if($c->id > 0)
		{
			$old = $db->tbCategory->getRecordById($c->id);
			$c->picture = $old->picture;
		}
		$db->tbCategory->save($c);
		Application::addMessage("Category saved");

		$up = new UploadFile("picture", WEB_DIR . "/img/categories", DATA_DIR . "/temp");
		if(!$up->isEmpty())
		{
			$up->setTmpPrefix("tmpcat" . $c->id);
			$up->setPrefix("cat" . $c->id);
			$up->validateInput();
			$up->validateImage();
			$up->upload(false);
			$up->resize_limitwh(220, 100);
			if($up->commit($c->picture))
			{
				$c->picture = $up->newFilename;
				$db->tbCategory->save($c);
				Application::addMessage("Image changed");
			}
			else
			{
				Application::appendErrors($up->errors);
			}
		}

		if(Application::hasErrors())
		{
			SessionWrapper::set("editCategory", $c);
			Tools::redirect("../category.php?action=edit&id_parent=" . intval($c->id_parent));
		}
		else
		{
			Tools::redirect("../category.php?id_category={$c->id}");
		}
	}
	else
	{
		SessionWrapper::set("editCategory", $c);
		Tools::redirect("../category.php?action=edit&id_parent=" . intval($c->id_parent));
	}
}
elseif (@$_GET["action"] == "delete")
{
	$c = $db->tbCategory->getRecordById(@$_POST["id_category"]);
	if($c->id == 0)
	{
		Application::addError("Could not find category to delete");
		Tools::redirect("../category.php");
	}
	else
	{
		$db->tbCategory->deleteObj($c);
		Application::addMessage("Category has been deleted");
		Tools::redirect("../category.php?id_category={$c->id_parent}#subcategs");
	}
}
elseif (@$_GET["action"] == "change_position")
{
	$c = $db->tbCategory->getRecordById(@$_POST["id_category"]);
	if($c->id == 0)
	{
		Application::addError("Could not find the category to change it's position");
	}
	else
	{
		if(@$_POST["direction"] == "up")
			$c->pos--;
		elseif (@$_POST["direction"] == "down")
			$c->pos++;
		else
			Application::addError("You must specify the direction how to change the position");

		$maxPos = $db->tbCategory->getMaxPos($c->id_parent);
		if($c->pos < 1)
			$c->pos = 1;
		elseif ($c->pos > $maxPos)
			$c->pos = $maxPos;

		if($c->validate())
		{
			$db->tbCategory->save($c);
			Application::addMessage("Category position has been changed");
		}
	}
	Tools::redirect("../category.php?id_category=" . intval($c->id_parent) . "#subcategs");

}
elseif (@$_GET["action"] == "change_active_state")
{
	$c = $db->tbCategory->getRecordById(@$_POST["id_category"]);
	if($c->id == 0)
	{
		Application::addError("Could not find category to activate / deactivate");
	}
	else
	{
		$c->active = (@$_POST["active"] == "1") ? 1 : 0;
		if($c->validate())
		{
			$db->tbCategory->save($c);
			if($c->active == 1)
				Application::addMessage("Category has been activated");
			else
				Application::addMessage("Category has been deactivated");
		}
	}
	Tools::redirect("../category.php?id_category=" . intval($c->id_parent) . "#subcategs");
}




?>