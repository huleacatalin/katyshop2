<?php

/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

class Address extends LogicObject
{
	var $id = 0;
	var $id_user = 0;

	var $delivery = 1;
	var $invoicing = 1;
	var $primary_addr = 1;

	var $county = "";
	var $city = "";
	var $address = "";

	function __construct()
	{
		parent::__construct();
	}

	function validate()
	{
		$errors = array();
		$db = Application::getDb();
		if(!$db->tbUser->idExists($this->id_user))
			$errors[] = "There is no user having this address";
		if(strlen($this->county) < 3 || strlen($this->county) > 177)
			$errors[] = "The county must have between 3 and 177 characters";
		if(strlen($this->city) < 3 || strlen($this->city) > 177)
			$errors[] = "The city must have between 3 and 177 characters";
		if(strlen($this->address) < 3 || strlen($this->address) > 1000)
			$errors[] = "The city must have between 3 and 1000 characters";

		if($this->id > 0)
		{
			$user = Application::getUser();
			$a = $db->tbAddress->getRecordById($this->id);
			if($a->id == 0)
				$errors[] = "Could not find this address to update it";
			elseif ($a->id_user != $user->id)
				$errors[] = "This address doesn't belong to you";
		}

		Application::appendErrors($errors);
		return (count($errors) == 0);
	}

	function toStr($humanReadable = false)
	{
		if($humanReadable)
		{
			$s = "County: $this->county
City: $this->city
Address: $this->address";
			return $s;
		}
		else
		{
			return parent::toStr();
		}
	}
	
	function encrypt()
	{
		$arr = array('county', 'city', 'address');
		foreach($arr as $prop) {
			$this->$prop = Tools::encrypt($this->$prop, Application::getConfigValue('openssl_key'));
		}
	}
	
	function decrypt()
	{
		$arr = array('county', 'city', 'address');
		foreach($arr as $prop) {
			$this->$prop = Tools::decrypt($this->$prop, Application::getConfigValue('openssl_key'));
		}
	}
}

?>