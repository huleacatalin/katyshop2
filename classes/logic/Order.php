<?php

/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

class Order extends LogicObject
{
	var $id = 0;
	var $code = "";
	var $title = "New order";
	var $id_user = 0;
	var $status = "in cart";
	var $date_ordered = "";
	var $date_updated = "";

	// cache everything about the user and addresses.
	// In case a user or address record gets deleted or modified,
	// we keep the record here about the original data, when the order was sent.
	var $username = "";
	var $user_short_description = "";
	var $user_details = "";
	var $id_delivery_address = 0;
	var $id_invoice_address = 0;
	var $delivery_address = "";
	var $invoice_address = "";

	var $total = 0;

	var $orderProducts = array();

	function __construct()
	{
		parent::__construct();
		$this->date_ordered = date("Y-m-d H:i:s");
		$this->date_updated = date("Y-m-d H:i:s");
	}

	function validate()
	{
		$errors = array();
		if(!Tools::validateInt($this->id) || $this->id < 0)
			$errors[] = "id property of Order object must be positive integer";
		if(strlen($this->title) < 3 || strlen($this->title) > 255)
			$errors[] = "Order title must have between 3 and 255 characters";
		if(!Tools::validateInt($this->id_user, true, true))
			$errors[] = "id_user property of Order object must be positive integer";
		if(!in_array($this->status, Order::getPossibleStatuses()))
			$errors[] = "Order status is not valid";
		$df = new DateFormat();
		$df->readDateTime($this->date_ordered);
		if(!$df->validate())
			$errors[] = "Order date is not valid";
		$df->readDateTime($this->date_updated);
		if(!$df->validate())
			$errors[] = "Updated order date is not valid";

		if(!Tools::validateFloat($this->total) || $this->total < 0)
			$errors[] = "Total value of the order must be positive";

		if(count($this->orderProducts) < 1)
			$errors[] = "The order is empty";
		for($i = 0; $i < count($this->orderProducts); $i++)
		{
			if(!is_a($this->orderProducts[$i], "OrderProduct"))
				$errors[] = "An order line is not identified as a product";
		}

		$productsHaveErrors = false;
		if(count($errors) == 0)
		{
			// db validations
			$db = Application::getDb();
			$u = $db->tbUser->getUserById($this->id_user);
			$u = Factory::instantiateUser($u);
			if(!is_a($u, "UserPerson") && !is_a($u, "UserCompany"))
				$errors[] = "Only Person or Company users may issue orders";

			for($i = 0; $i < count($this->orderProducts); $i++)
			{
				if(!$this->orderProducts[$i]->validate())
					$productsHaveErrors = true;
			}
		}

		Application::appendErrors($errors);
		return (count($errors) == 0 || $productsHaveErrors);
	}

	function validateDeliveryAddress()
	{
		$errors = array();
		if(strlen($this->delivery_address) < 10 || strlen($this->delivery_address) > 1100)
			$errors[] = "Delivery address must have between 10 and 1000 characters";

		if(count($errors) == 0)
		{
			$db = Application::getDb();
			$a = $db->tbAddress->getRecordById($this->id_delivery_address);
			if($a->id_user != $this->id_user)
				$errors[] = "The selected delivery address does not belong to the user who issued the order";
		}

		Application::appendErrors($errors);
		return (count($errors) == 0);
	}

	function validateInvoiceAddress()
	{
		$errors = array();
		if(strlen($this->invoice_address) < 10 || strlen($this->invoice_address) > 1100)
			$errors[] = "Invoicing address must have between 10 and 1000 characters";

		if(count($errors) == 0)
		{
			$db = Application::getDb();
			$a = $db->tbAddress->getRecordById($this->id_invoice_address);
			if($a->id_user != $this->id_user)
				$errors[] = "The selected invoicing address doesn't belong to user who issued the order";
		}

		Application::appendErrors($errors);
		return (count($errors) == 0);
	}

	static function getPossibleStatuses()
	{
		return array("in cart", "sent", "working on it", "rejected", "delivered", "payed");
	}

	function generateCode()
	{
		$db = Application::getDb();
		$u = $db->tbUser->getUserById($this->id_user);
		if($u->id == 0)
			Logger::err("User not found in Order::generateCode()", __FILE__, __LINE__);
		$usr = strtolower($u->username);
		$s = "O" . str_pad($this->id, 5, "0", STR_PAD_LEFT);
		$s .= "U" . str_pad($this->id_user, 5, "0", STR_PAD_LEFT);
		if(Tools::validateAlphanumeric($usr))
			$s .= substr($usr, 0, 3);
		else
			Logger::err("Username not alphanumeric in Order::generateCode() ", __FILE__, __LINE__);
		$this->code = $s;
	}

	function generateProforma()
	{
		SessionWrapper::set("generateProforma", $this);
		ob_get_clean();
		ob_start();
		require_once(WEB_DIR . "/includes/generate_proforma.php");
		$s = ob_get_clean();
		if(file_exists(DATA_DIR . "/orders/{$this->code}.html"))
		{
			Application::addError("Could not write the proforma file for {$this->code} because there is already another file with the same name");
			Logger::err("Could not write the proforma file for {$this->code} because another file with the same name already exists", __FILE__, __LINE__);
		}
		else
		{
			$s = Tools::encrypt($s, Application::getConfigValue('openssl_key'));
			$f = fopen(DATA_DIR . "/orders/{$this->code}.html", "w");
			if(fwrite($f, $s) === false)
			{
				Application::addError("There was an error while trying to write the file {$this->code}.html");
				Logger::err("There was an error while trying to write the file {$this->code}.html", __FILE__, __LINE__);
			}
			fclose($f);
		}
		ob_start();
	}

	function encrypt()
	{
		$arr = array('delivery_address', 'invoice_address', 'user_details', 'user_short_description');
		foreach($arr as $prop) {
			$this->$prop = Tools::encrypt($this->$prop, Application::getConfigValue('openssl_key'));
		}
	}
	
	function decrypt()
	{
		$arr = array('delivery_address', 'invoice_address', 'user_details', 'user_short_description');
		foreach($arr as $prop) {
			$this->$prop = Tools::decrypt($this->$prop, Application::getConfigValue('openssl_key'));
		}
	}

	//#######################################
	//# ORDER PRODUCT RELATED METHODS		#
	//#######################################

	/**
	 * @param OrderProduct $orderProduct
	 */
	function addOrderProduct($orderProduct)
	{
		$alreadyExists = false;
		for($i = 0; $i < count($this->orderProducts); $i++)
		{
			if($orderProduct->id_product == $this->orderProducts[$i]->id_product)
			{
				$alreadyExists = true;
				$q = $this->orderProducts[$i]->quantity;
				$this->orderProducts[$i]->copyFromObject($orderProduct);
				$this->orderProducts[$i]->quantity += $q;
				$this->orderProducts[$i]->line_number = $i + 1;
			}
		}

		if(!$alreadyExists)
		{
			$op = new OrderProduct();
			$op->copyFromObject($orderProduct);
			$op->line_number = count($this->orderProducts) + 1;
			$this->orderProducts[] = $op;
		}
	}

	/**
	 * @return OrderProduct
	 */
	function getOrderProduct($line_number)
	{
		$ret = new OrderProduct();
		if($line_number <= count($this->orderProducts) && $line_number > 0)
			$ret->copyFromObject($this->orderProducts[$line_number - 1]);
		return $ret;
	}

	function removeOrderProduct($line_number)
	{
		if($line_number <= count($this->orderProducts) && $line_number > 0)
		{
			$x = count($this->orderProducts);
			for($i = $line_number - 1; $i < $x - 1; $i++)
			{
				$this->orderProducts[$i]->copyFromObject($this->orderProducts[$i + 1]);
				$this->orderProducts[$i]->line_number = $i + 1;
			}
			unset($this->orderProducts[$x - 1]);
		}
	}

	function resetOrderProducts()
	{
		$this->orderProducts = array();
	}

	function getProductsCount()
	{
		return count($this->orderProducts);
	}

	function setProductsIds()
	{
		for($i = 0; $i < count($this->orderProducts); $i++)
			$this->orderProducts[$i]->id_order = $this->id;
	}

	function computeValue()
	{
		$this->total = 0;
		for($i = 0; $i < count($this->orderProducts); $i++)
		{
			$this->orderProducts[$i]->computeValue();
			$this->total += $this->orderProducts[$i]->total;
		}
	}



}

?>