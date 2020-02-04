<?php

/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

class Manufacturer extends LogicObject
{
	var $id = 0;
	var $title = "";
	var $description = "";
	var $picture = "";

	function __construct()
	{
		parent::__construct();
	}

	function validate()
	{
		$errors = array();
		if(!Tools::validateInt($this->id, true))
			$errors[] = "id property of Manufacturer object must be positive integer";
		if(strlen($this->title) < 3 || strlen($this->title) > 255)
			$errors[] = "Manufacturer title must have between 3 and 255 characters";
		if(strlen($this->description) > 500)
			$errors[] = "Manufacturer description must not have more than 500 characters";

		if(count($errors) == 0)
		{
			$db = Application::getDb();
			if($this->id > 0 && !$db->tbManufacturer->idExists($this->id))
				$errors[] = "Could not find the manufacturer to edit";

			$temp = $db->tbManufacturer->getManufacturerByTitle($this->title);
			if($temp->id > 0 && $temp->id != $this->id)
				$errors[] = "There is already another manufacturer with this title";
		}

		Application::appendErrors($errors);
		return (count($errors) == 0);
	}
}

?>