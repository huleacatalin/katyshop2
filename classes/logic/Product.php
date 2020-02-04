<?php

/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

class Product extends LogicObject
{
	var $id = 0;
	var $id_category = 0;
	var $id_manufacturer = 0;
	var $pos = 0;
	var $title = "";
	var $price = 0;
	var $measuring_unit = "";
	var $description = "";
	var $content = "";
	var $technical_details = "";
	var $picture = "";
	var $date_created = "";
	var $active = 1;

	var $manufacturer = "";
	var $images = array();

	function __construct($argId = 0, $argTitle = "")
	{
		parent::__construct();
		$this->date_created = date("Y-m-d H:i:s");
		$this->id = $argId;
		$this->title = $argTitle;
	}

	function validateCommonFields()
	{
		$errors = array();
		if(!Tools::validateInt($this->id))
			$errors[] = "id property of Product object must be integer";
		if(!Tools::validateInt($this->id_category))
			$errors[] = "id_category property of Product object must be integer";
		if(!Tools::validateFloat($this->price, true, true) || $this->price < 0.01)
			$errors[] = "Product's price must be a strict positive real number";
		if(!Tools::validateInt($this->pos) || $this->pos < 1)
			$errors[] = "Product's position must be strict positive integer";
		if(strlen($this->title) < 3 || strlen($this->title) > 255)
			$errors[] = "Title must have between 3 and 255 characters";
		if(!empty($this->picture) && !Tools::isImage($this->picture))
			$errors[] = "Uploaded file is not an image";

		$df = new DateFormat();
		if(!$df->readDateTime($this->date_created) || !$df->validate())
			$errors[] = "Product creation date is not valid";

		if($this->active != 0 && $this->active != 1)
			$errors[] = "'active' property of Product object can only be 0 or 1";

		return $errors;
	}

	function validate()
	{
		$this->title = trim($this->title);
		$errors = $this->validateCommonFields();

		if(count($errors) == 0)
		{
			$db = Application::getDb();
			if($this->id > 0 && !$db->tbProduct->productExists($this->id))
				$errors[] = "Could not find product to update";
			if($this->id_category > 0 && !$db->tbCategory->categoryExists($this->id_category))
				$errors[] = "Could not find parent category";
			if(!in_array($this->measuring_unit, Product::getPossibleMeasuringUnits()))
				$errors[] = "Please choose the measuring unit";

			$titleProd = $db->tbProduct->getProductByTitle($this->title, $this->id_category);
			if($titleProd->id > 0 && $titleProd->id != $this->id)
				$errors[] = "There is already another product with this title";
			if($this->id_manufacturer > 0 && !$db->tbManufacturer->idExists($this->id_manufacturer))
				$errors[] = "Could not find the selected manufacturer for this product";
		}

		Application::appendErrors($errors);
		return (count($errors) == 0);
	}

	/**
	 * Return false if this product or any of it's parent categories is not active
	 */
	function canBeDisplayed()
	{
		$db = Application::getDb();
		$bread = $db->tbCategory->getBreadcrumb($this->id_category);
		for($i = 0; $i < count($bread); $i++)
		{
			if($bread[$i]->active != 1)
				return false;
		}
		if(intval($this->active) != 1)
			return false;
		return true;
	}

	function removeImages()
	{
		if(empty($this->picture))
			return ;
		@unlink(WEB_DIR . "/img/products/small/{$this->picture}");
		@unlink(WEB_DIR . "/img/products/medium/{$this->picture}");
		@unlink(WEB_DIR . "/img/products/large/{$this->picture}");
	}

	static function getPossibleMeasuringUnits()
	{
		return array("pieces", "kg");
	}

	static function validateQuantity($q, $measuringUnit)
	{
		switch ($measuringUnit)
		{
			case "pieces":
				return Tools::validateInt($q, true, true);
				break;
			case "kg":
				return Tools::validateFloat($q, true, true);
				break;
			default:
				return false;
				break;
		}
	}
	
	function getImagesFromDb()
	{
		$db = Application::getDb();
		$this->images = $db->tbProductImage->getImagesByProductId($this->id);
		return $this->images;
	}


}

?>