<?php

/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

class ContactMessage extends LogicObject
{
	var $id = 0;
	var $id_user = 0;
	var $user_details = "";

	var $sender_name = "";
	var $sender_email = "";
	var $subject = "";
	var $message = "";
	var $date_sent = "";

	function __construct()
	{
		parent::__construct();
		$this->date_sent = date("Y-m-d H:i:s");
	}

	function validate()
	{
		$errors = array();
		if(strlen($this->sender_name) < 3 || strlen($this->sender_name) > 177) // 177
			$errors[] = "Name must have between 3 and 177 characters";
		if(strlen($this->sender_email) < 3 || strlen($this->sender_email) > 177)
			$errors[] = "Email address must have between 3 and 177 characters";
		if(!Tools::validateEmail($this->sender_email))
			$errors[] = "Email address is not valid";
		if(strlen($this->subject) < 3 || strlen($this->subject) > 255)
			$errors[] = "Subject must have between 3 and 255 characters";
		if(strlen($this->message) < 3 || strlen($this->message) > 1000)
			$errors[] = "Message must have between 3 and 1000 characters";

		Application::appendErrors($errors);
		return (count($errors) == 0);
	}
	
	function encrypt()
	{
		$arr = array('user_details', 'sender_name', 'sender_email', 'message');
		foreach($arr as $prop) {
			$this->$prop = Tools::encrypt($this->$prop, Application::getConfigValue('openssl_key'));
		}
	}
	
	function decrypt()
	{
		$arr = array('user_details', 'sender_name', 'sender_email', 'message');
		foreach($arr as $prop) {
			$this->$prop = Tools::decrypt($this->$prop, Application::getConfigValue('openssl_key'));
		}
	}
}

?>