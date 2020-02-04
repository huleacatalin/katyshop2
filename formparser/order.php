<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(dirname(__FILE__)) . "/init.php");

$db = Application::getDb();
if(@$_GET["action"] == "add_to_cart")
{
	$p = $db->tbProduct->getRecordById(@$_POST["id_product"]);
	if($p->id == 0)
	{
		Application::addError("Could not find product to add to the cart");
	}
	else
	{
		$basket = Application::getShoppingCart();
		$op = new OrderProduct();
		$op->initFromProduct($p);
		$op->quantity = 1;
		$basket->addOrderProduct($op);
		Application::setShoppingCart($basket);
	}
	Tools::redirect("../shopping_cart.php");
}
elseif (@$_GET["action"] == "remove_product")
{
	$basket = Application::getShoppingCart();
	$basket->removeOrderProduct(@$_POST["line_number"]);
	Application::setShoppingCart($basket);
	Tools::redirect("../shopping_cart.php");
}
elseif (@$_GET["action"] == "update_basket")
{
	$basket = Application::getShoppingCart();
	if(intval(@$_POST["next_step"]) != 0)
	{
		$user = Application::getUser();
		if(!$user->isUserLoggedIn())
		{
			SessionWrapper::set("login_return_to_cart", "true");
			Application::addError("You must login in order to send the order");
			Tools::redirect("../login.php");
		}
		if($user->isAdminLoggedIn())
		{
			Application::addError("Admin accounts cannot send orders");
			Tools::redirect("../shopping_cart.php");
		}
		$basket->id_user = $user->id;
	}

	$basket->title = @$_POST["title"];
	$basket->resetOrderProducts();
	for($i = 0; $i < count(@$_POST["line_number"]); $i++)
	{
		$op = new OrderProduct();
		$p = $db->tbProduct->getRecordById(@$_POST["id_product"][$i]);
		if($p->id == 0)
		{
			Application::addError("Could not find one of the products to add to the cart");
		}
		else
		{
			$op->initFromProduct($p);
			$op->quantity = readPrice(@$_POST["quantity"][$i]);
			$basket->addOrderProduct($op);
		}
	}
	if(intval(@$_POST["next_step"]) == 1)
		$basket->validate();
	Application::setShoppingCart($basket);
	if(intval(@$_POST["next_step"]) == 1 && !Application::hasErrors())
		Tools::redirect("../shopping_cart_address.php?action=select_delivery_address");
	else
		Tools::redirect("../shopping_cart.php");
}
elseif (@$_GET["action"] == "select_delivery_address")
{
	$user = Application::getUser();
	if(!$user->isUserLoggedIn())
	{
		SessionWrapper::set("login_return_to_cart", "true");
		Application::addError("You must login to send the order");
		Tools::redirect("../login.php");
	}
	if($user->isAdminLoggedIn())
	{
		Application::addError("Admin accounts cannot send orders");
		Tools::redirect("../shopping_cart.php");
	}
	$a = $db->tbAddress->getRecordById(@$_POST["id_address"]);
	if($a->id == 0)
		Application::addError("Could not find the delivery address selected by you");
	elseif($a->id_user != $user->id)
		Application::addError("The selected address doesn't belong to you");
	elseif(intval($a->delivery) != 1)
		Application::addError("The selected address is not a delivery address");

	if(Application::hasErrors())
	{
		Tools::redirect("../shopping_cart_address.php?action=select_delivery_address");
	}
	else
	{
		$basket = Application::getShoppingCart();
		$basket->id_delivery_address = $a->id;
		$basket->delivery_address = $a->toStr(true);
		Application::setShoppingCart($basket);
		Tools::redirect("../shopping_cart_address.php?action=select_invoice_address");
	}
}
elseif (@$_GET["action"] == "select_invoice_address")
{
	$user = Application::getUser();
	if(!$user->isUserLoggedIn())
	{
		SessionWrapper::set("login_return_to_cart", "true");
		Application::addError("You must login before sending the order");
		Tools::redirect("../login.php");
	}
	if($user->isAdminLoggedIn())
	{
		Application::addError("Admin accounts cannot send orders");
		Tools::redirect("../shopping_cart.php");
	}
	$a = $db->tbAddress->getRecordById(@$_POST["id_address"]);

	if($a->id == 0)
		Application::addError("Could not find invoice address selected by you");
	elseif($a->id_user != $user->id)
		Application::addError("The selected address doesn't belong to you");
	elseif(intval($a->invoicing) != 1)
		Application::addError("The selected address is not a invoicing address");

	if(Application::hasErrors())
	{
		Tools::redirect("../shopping_cart_address.php?action=select_invoice_address");
	}
	else
	{
		$basket = Application::getShoppingCart();
		$basket->id_invoice_address = $a->id;
		$basket->invoice_address = $a->toStr(true);
		Application::setShoppingCart($basket);
		Tools::redirect("../order.php");
	}
}
elseif (@$_GET["action"] == "finalize")
{
	$user = Application::getUser();
	if(!$user->isUserLoggedIn())
	{
		SessionWrapper::set("login_return_to_cart", "true");
		Application::addError("You must login to send the order");
		Tools::redirect("../login.php");
	}
	if($user->isAdminLoggedIn())
	{
		Application::addError("Admin accounts cannot send orders");
		Tools::redirect("../shopping_cart.php");
	}
	$basket = Application::getShoppingCart();
	$basket->id_user = $user->id;
	$basket->username = $user->username;
	$basket->user_short_description = $user->toStr(true, true);
	$basket->user_details = $user->toStr(true);

	if(!$basket->validate())
		Tools::redirect("../shopping_cart.php");
	if(!$basket->validateDeliveryAddress())
		Tools::redirect("../shopping_cart.php?action=select_delivery_address");
	if(!$basket->validateInvoiceAddress())
		Tools::redirect("../shopping_cart.php?action=select_invoice_address");

	$x = $db->tbOrder->insertObj($basket);
	$ma = Application::getMailAgent();
	$ma->newOrder($user, $basket);
	$basket = new Order();
	Application::setShoppingCart($basket);
	Application::addMessage("Order has been sent");
	Tools::redirect("../order.php?id=$x");
}




?>