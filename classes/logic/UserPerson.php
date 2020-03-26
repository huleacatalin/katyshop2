<?php

/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(__FILE__) . "/User.php");

class UserPerson extends User
{
	// database stored properties
	var $id = 0;
	var $first_name = "";
	var $last_name = "";
	var $gender = "";
	var $birth_date = "";
	var $phone = "";

	function __construct()
	{
		parent::__construct();
	}

	function validateRegister($confirmPassword)
	{
		if(!parent::validateRegister($confirmPassword))
			return false;
		$errors = array();

		if(!in_array($this->gender, array("female", "male")))
			$errors[] = "Please choose a valid gender";
		if(strlen($this->first_name) < 3 || strlen($this->first_name) > 20)
			$errors[] = "First name must have between 3 and 20 characters";
		if(strlen($this->last_name) < 3 || strlen($this->last_name) > 20)
			$errors[] = "Name must have between 3 and 20 characters";
		if(strlen($this->phone) > 20)
			$errors[] = "Phone must have at most 20 characters";

		Application::appendErrors($errors);
		return (count($errors) == 0);
	}

	function validateUpdate($oldPassword, $newPassword, $confirmPassword)
	{
		if(!parent::validateUpdate($oldPassword, $newPassword, $confirmPassword))
			return false;
		$errors = array();

		if(!in_array($this->gender, array("female", "male")))
			$errors[] = "Please choose a valid gender";
		if(strlen($this->first_name) < 3 || strlen($this->first_name) > 20)
			$errors[] = "First name must have between 3 and 20 characters";
		if(strlen($this->last_name) < 3 || strlen($this->last_name) > 20)
			$errors[] = "Last name must have between 3 and 20 characters";
		if(strlen($this->phone) < 3 || strlen($this->phone) > 20)
			$errors[] = "Phone must have between 3 and 20 characters";
			
		Application::appendErrors($errors);
		return (count($errors) == 0);
	}

	function toStr($humanReadable = false, $brief = false)
	{
		if($humanReadable)
		{
			$s = parent::toStr($humanReadable, $brief);

			if($brief)
			{
				$s .= "
{$this->first_name} {$this->last_name}
";
			}
			else
			{
				$s .= "
" . translate("Person account with details") . ":
" . translate("First name") . ": {$this->first_name}
" . translate("Last name") . ": {$this->last_name}
" . translate("Gender") . ": {$this->gender}
" . translate("Birth date") . ": {$this->birth_date}
" . translate("Phone") . ": {$this->phone}
";
			}
			return $s;
		}
		else
		{
			return parent::toStr();
		}
	}

	function encrypt()
	{
		$arr = array('first_name', 'last_name', 'gender', 'birth_date', 'phone');
		foreach($arr as $prop) {
			$this->$prop = Tools::encrypt($this->$prop, Application::getConfigValue('openssl_key'));
		}
		parent::encrypt();
	}
	
	function decrypt()
	{
		$arr = array('first_name', 'last_name', 'gender', 'birth_date', 'phone');
		foreach($arr as $prop) {
			$this->$prop = Tools::decrypt($this->$prop, Application::getConfigValue('openssl_key'));
		}
		parent::decrypt();
	}

}









?>