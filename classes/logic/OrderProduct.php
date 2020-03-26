<?php

/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

class OrderProduct extends LogicObject
{
	var $id_order = 0;
	var $line_number = 0;

	// from Product object
	var $id_product = 0;
	var $product_name = "";
	var $product_description = "";
	var $price = 0;
	var $measuring_unit = "";

	var $quantity = 0;
	var $total = 0;

	function __construct()
	{
		parent::__construct();
	}

	function validate()
	{
		$errors = array();
		if(!Tools::validateInt($this->id_order, true))
			$errors[] = "id_order property of OrderProduct object must be positive integer";
		if(!Tools::validateInt($this->line_number) || intval($this->line_number) < 1 || intval($this->line_number) > 50)
			$errors[] = "An order can hold between 1 and 50 products";
		if(!Tools::validateInt($this->id_product, true, true))
			$errors[] = "id_product property must be a positive integer";
		if(strlen($this->product_name) < 3 || strlen($this->product_name) > 255)
			$errors[] = "Products name must have between 3 and 255 characters";
		if(!Tools::validateFloat($this->price, true, true))
			$errors[] = "Price must be positive integer";
		if(!Product::validateQuantity($this->quantity, $this->measuring_unit))
			$errors[] = "Quantity is not correct";

		if(!Tools::validateFloat($this->total) || $this->total < 0)
			$errors[] = "Total value of the order must be positive";

		if(count($errors) == 0)
		{
			$db = Application::getDb();
			if(!$db->tbProduct->productExists($this->id_product))
				$errors[] = translate("Product named") . " " . $this->product_name . " " . translate("from the position") . " " . $this->line_number . " " . translate("doesn't exist in our database");
			$p = $db->tbProduct->getRecordById($this->id_product);
			if(intval($p->active) != 1)
				$errors[] = translate("Product named") . " " . $this->product_name . " " . translate("from the position") . " " . $this->line_number . " " .  translate("from the order cannot be ordered because it is no longer active on the website");
		}

		Application::appendErrors($errors);
		return (count($errors) == 0);
	}

	/**
	 * @param Product $p
	 */
	function initFromProduct($p)
	{
		$this->id_product = $p->id;
		$this->product_name = $p->title;
		$this->product_description = $p->description;
		$this->price = $p->price;
		$this->measuring_unit = $p->measuring_unit;
	}

	function computeValue()
	{
		$this->total = $this->quantity * $this->price;
	}

	function encrypt()
	{
		$arr = array('product_name', 'product_description', 'measuring_unit');
		foreach($arr as $prop) {
			$this->$prop = Tools::encrypt($this->$prop, Application::getConfigValue('openssl_key'));
		}
	}
	
	function decrypt()
	{
		$arr = array('product_name', 'product_description', 'measuring_unit');
		foreach($arr as $prop) {
			$this->$prop = Tools::decrypt($this->$prop, Application::getConfigValue('openssl_key'));
		}
	}
}

?>