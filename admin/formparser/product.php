<?php

/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(dirname(dirname(__FILE__))) . "/init.php");
require_once(dirname(dirname(dirname(__FILE__))) . "/classes/common/htmlpurifier/library/HTMLPurifier.auto.php");
require_once(WEB_DIR . "/includes/req_admin.php");

function append_http_querystring() {
	return "&start=" . htmlspecialchars(@$_POST['start']) .
			"&rowsPerPage=" . htmlspecialchars(@$_POST['rowsPerPage']) .
			"&order_by[subcategs]=" . htmlspecialchars(@$_POST['order_by']['subcategs']) .
			"&order_by[products]" . htmlspecialchars(@$_POST['order_by']['products']) .
			"&order_direction[subcategs]" . htmlspecialchars(@$_POST['order_direction']['subcategs']) .
			"&order_direction[products]" . htmlspecialchars(@$_POST['order_direction']['products']);
}


$db = Application::getDb();
if(@$_GET["action"] == "save")
{
	$p = new Product();
	$p->copyFromArray($_POST);

	if(Tools::validateFormattedNumber(@$_POST["price"], 2, ".", ","))
		$p->price = readPrice(@$_POST["price"]);
	else
		$p->price = 0;
	if($p->validate())
	{
		if($p->id > 0)
		{
			$old = $db->tbProduct->getRecordById($p->id);
			$p->picture = $old->picture;
		}
		
		$purifierConfig = HTMLPurifier_Config::createDefault();
		$purifier = new HTMLPurifier($purifierConfig);
		$p->content = $purifier->purify($p->content);
		
		$db->tbProduct->save($p);
		Application::addMessage("Product has been saved");

		$up = new UploadFile("picture", WEB_DIR . "/img/products/large", DATA_DIR . "/temp");
		if(!$up->isEmpty())
		{
			$up->setTmpPrefix("tmpprod" . $p->id);
			$up->setPrefix("prod" . $p->id);
			$up->validateInput();
			$up->validateImage();
			$up->upload(false);
			$up->resize_limitwh(1024, 768);
			if($up->commit($p->picture))
			{
				if(!empty($p->picture))
				{
					if(is_file(WEB_DIR . "/img/products/medium/" . $p->picture))
						@unlink(WEB_DIR . "/img/products/medium/" . $p->picture);
					if(is_file(WEB_DIR . "/img/products/small/" . $p->picture))
						@unlink(WEB_DIR . "/img/products/small/" . $p->picture);
				}
				$p->picture = $up->newFilename;
				$db->tbProduct->save($p);

				// make medium image:
				$im = new RESIZEIMAGE();
				$im->setImage(WEB_DIR . "/img/products/large/" . $p->picture);
				$im->resize_limitwh(150, 150, WEB_DIR . "/img/products/medium/" . $p->picture);

				// make small image:
				$im = new RESIZEIMAGE();
				$im->setImage(WEB_DIR . "/img/products/large/" . $p->picture);
				$im->resize_limitwh(75, 75, WEB_DIR . "/img/products/small/" . $p->picture);

				Application::addMessage("Image changed");
			}
			else
			{
				Application::appendErrors($up->errors);
			}
		}
		
		for($i = 0; $i < 5; $i++) {
			if(!empty($_FILES['product_image']['name'][$i])) {
				$pi = new ProductImage();
				$pi->id_product = $p->id;
				$pi->upload($i);
			}
		}

		if(Application::hasErrors())
		{
			SessionWrapper::set("editProduct", $p);
			Tools::redirect("../product.php?action=edit&id_category=" . intval($p->id_category));
		}
		else
		{
			Tools::redirect("../product.php?action=edit&id_product={$p->id}");
		}
	}
	else
	{
		SessionWrapper::set("editProduct", $p);
		Tools::redirect("../product.php?action=edit&id_category=" . intval($p->id_category));
	}
}
elseif (@$_GET["action"] == "delete")
{
	$p = $db->tbProduct->getRecordById(@$_POST["id_product"]);
	if($p->id == 0)
	{
		Application::addError("Could not find product to delete");
		Tools::redirect("../category.php");
	}
	else
	{
		$db->tbProduct->deleteObj($p);
		Application::addMessage("Product has been deleted");
		Tools::redirect("../category.php?id_category={$p->id_category}" . append_http_querystring() . "#products");
	}
}
elseif (@$_GET["action"] == "change_position")
{
	$p = $db->tbProduct->getRecordById(@$_POST["id_product"]);
	if($p->id == 0)
	{
		Application::addError("Could not find product to change it's position");
	}
	else
	{
		if(@$_POST["direction"] == "up")
			$p->pos--;
		elseif (@$_POST["direction"] == "down")
			$p->pos++;
		else
			Application::addError("You must specify the direction how to change the position");

		$maxPos = $db->tbProduct->getMaxPos($p->id_category);
		if($p->pos < 1)
			$p->pos = 1;
		elseif ($p->pos > $maxPos)
			$p->pos = $maxPos;

		if($p->validate())
		{
			$db->tbProduct->save($p);
			Application::addMessage("Product's position has been updated");
		}
	}
	Tools::redirect("../category.php?id_category=" . intval($p->id_category) . append_http_querystring() . "#products");
}
elseif (@$_GET["action"] == "change_active_state")
{
	$p = $db->tbProduct->getRecordById(@$_POST["id_product"]);
	if($p->id == 0)
	{
		Application::addError("Could not find product to activate / deactivate");
	}
	else
	{
		$p->active = (@$_POST["active"] == "1") ? 1 : 0;
		if($p->validate())
		{
			$db->tbProduct->save($p);
			if($p->active == 1)
				Application::addMessage("Product has been activated");
			else
				Application::addMessage("Product has been deactivated");
		}
	}
	Tools::redirect("../category.php?id_category=" . intval($p->id_category) . append_http_querystring() . "#products");
}



?>