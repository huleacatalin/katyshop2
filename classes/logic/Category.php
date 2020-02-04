<?php

/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

class Category extends LogicObject
{
	var $id = 0;
	var $id_parent = 0;
	var $pos = 0;
	var $nest_level = 0;
	var $title = "";
	var $description = "";
	var $picture = "";
	var $date_created = "";
	var $active = 1;

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
			$errors[] = "The ID property of Category object must be integer";
		if(!Tools::validateInt($this->id_parent))
			$errors[] = "The id_parent property of Category object must be integer";
		if($this->id == $this->id_parent && $this->id > 0)
			$errors[] = "A category cannot be it's own parent";
		if(!Tools::validateInt($this->pos) || $this->pos < 1)
			$errors[] = "Category position must be positive integer";
		if(strlen($this->title) < 3 || strlen($this->title) > 255)
			$errors[] = "Title must have between 3 and 255 characters";
		if(!empty($this->picture) && !Tools::isImage($this->picture))
			$errors[] = "Uploaded file is not an image";

		$df = new DateFormat();
		if(!$df->readDateTime($this->date_created) || !$df->validate())
			$errors[] = "Category creation date is not valid";

		if($this->active != 0 && $this->active != 1)
			$errors[] = "The 'active' property of Category object can only be 0 or 1";

		return $errors;
	}

	function validate()
	{
		$this->title = trim($this->title);
		$errors = $this->validateCommonFields();

		if(count($errors) == 0)
		{
			$db = Application::getDb();
			if($this->id > 0 && !$db->tbCategory->categoryExists($this->id))
				$errors[] = "Could not find category to update";
			if($this->id_parent > 0 && !$db->tbCategory->categoryExists($this->id_parent))
				$errors[] = "Could not find parent category";
			$bread = $db->tbCategory->getBreadcrumb($this->id_parent);
			for($i = 0; $i < count($bread); $i++)
			{
				if($bread[$i]->id == $this->id)
				{
					$errors[] = "Category cannot be moved into a subcategory of it's own";
					break;
				}
			}

			$titleCat = $db->tbCategory->getCategoryByTitle($this->title, $this->id_parent);
			if($titleCat->id > 0 && $titleCat->id != $this->id)
				$errors[] = "There is already another category with this title";

			$maxPos = $db->tbCategory->getMaxPos($this->id_parent);
			if($this->id > 0)
			{
				$old = $db->tbCategory->getRecordById($this->id);
				if($old->id_parent != $this->id_parent)
					$maxPos++;
			}
			else
			{
				$maxPos++;
			}
			if($maxPos < $this->pos)
				$errors[] = "Maximum possible value for position is $maxPos";
		}

		Application::appendErrors($errors);
		return (count($errors) == 0);
	}

	/**
	 * Return false if this category or any of it's parents is not active
	 */
	function canBeDisplayed()
	{
		$db = Application::getDb();
		$bread = $db->tbCategory->getBreadcrumb($this->id);
		for($i = 0; $i < count($bread); $i++)
		{
			if($bread[$i]->active != 1)
				return false;
		}
		return true;
	}

	function removeImages()
	{
		if(empty($this->picture))
			return ;
		@unlink(WEB_DIR . "/img/categories/{$this->picture}");
	}

}

?>