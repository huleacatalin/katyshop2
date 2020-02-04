<?php

/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

class ProductImage extends LogicObject
{
	var $id = 0;
	var $id_product = 0;
	var $pos = 0;
	var $filename = '';

	function __construct()
	{
		parent::__construct();
	}

	function validate()
	{
		$errors = array();
		if(strlen($this->filename) < 5 || strlen($this->filename) > 255)
			$errors[] = "Filename must have between 5 and 255 characters";
		
		$db = Application::getDb();
		if(!$db->tbProduct->productExists($this->id_product))
			$errors[] = 'Product for this image does not exist';

		Application::appendErrors($errors);
		return (count($errors) == 0);
	}
	
	function upload($index) {
		$up = new UploadFile("product_image", WEB_DIR . "/img/products/large", DATA_DIR . "/temp", $index);
		if(!$up->isEmpty())
		{
			$db = Application::getDb();
			$db->tbProductImage->insertObj($this);
			
			$up->setTmpPrefix("tmppi" . $this->id);
			$up->setPrefix("pi" . $this->id);
			$up->validateInput();
			$up->validateImage();
			$up->upload(false);
			$up->resize_limitwh(800, 600);
			if($up->commit())
			{
				$this->filename = $up->newFilename;
				$db->tbProductImage->updateObj($this);

				// make medium image:
				$im = new RESIZEIMAGE();
				$im->setImage(WEB_DIR . "/img/products/large/" . $this->filename);
				$im->resize_limitwh(400, 400, WEB_DIR . "/img/products/medium/" . $this->filename);

				// make small image:
				$im = new RESIZEIMAGE();
				$im->setImage(WEB_DIR . "/img/products/large/" . $this->filename);
				$im->resize_limitwh(150, 150, WEB_DIR . "/img/products/small/" . $this->filename);

				// make xsmall image:
				$im = new RESIZEIMAGE();
				$im->setImage(WEB_DIR . "/img/products/large/" . $this->filename);
				$im->resize_limitwh(75, 75, WEB_DIR . "/img/products/xsmall/" . $this->filename);

				Application::addMessage("Image uploaded");
			}
			else
			{
				Application::appendErrors($up->errors);
			}
		}
	}
	
	function deleteFromDb() {
		$db = Application::getDb();
		$db->tbProductImage->deleteObj($this);
		@unlink(WEB_DIR . "/img/products/large/" . $this->filename);
		@unlink(WEB_DIR . "/img/products/medium/" . $this->filename);
		@unlink(WEB_DIR . "/img/products/small/" . $this->filename);
		@unlink(WEB_DIR . "/img/products/xsmall/" . $this->filename);
	}
	
}

?>