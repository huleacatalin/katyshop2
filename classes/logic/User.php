<?php

/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(__FILE__) . "/Visitor.php");

class User extends Visitor
{
	// database stored properties
	var $id = 0;
	var $username = ""; // unique
	var $password = ""; // only password can be edited from profile
	var $email = ""; // unique, md5
	var $email2 = ""; // openssl
	var $acc_type = ""; // person, company
	var $active = 0; // is this account active? if not, it's not allowed to login
	var $activation_code = ""; // this is sent the first time on mail, and user must use it to activate his account
	var $login_code = ""; // this is used by "remember my password" feature, sent by cookie and used instead of password
	var $date_registered = "";
	
	function __construct()
	{
		parent::__construct();
		$this->activation_code = Tools::getRandomChars(10);
		$this->date_registered = date("Y-m-d H:i:s");
	}

	function validateCommonFields()
	{
		$errors = array();
		if(!Tools::validateAlphanumeric($this->username))
			$errors[] = "Username must only have letters, numbers or underscore characters";
		if(strlen($this->username) < 5 || strlen($this->username) > 20)
			$errors[] = "Username must have between 5 and 20 characters";
		if(strlen($this->password) < 5 || strlen($this->password) > 255)
			$errors[] = "Password must have between 5 and 255 characters";
		if(!in_array($this->acc_type, array("person", "company", "admin")))
			$errors[] = "Please choose a valid account type";
		return $errors;
	}

	function validateRegister($confirmPassword)
	{
		$db = Application::getDb();
		$errors = $this->validateCommonFields();
		if($this->password != $confirmPassword)
			$errors[] = "The 2 passwords do not match";

		if($db->tbUser->usernameExists($this->username))
			$errors[] = "This username is already taken, please try again";
		if(!Tools::validateEmail($this->email) || strlen($this->email) > 255)
			$errors[] = "Email address is not valid";
		if($db->tbUser->emailExists(md5($this->email)))
			$errors[] = "This email address has already been used to create another account";

		Application::appendErrors($errors);
		return (count($errors) == 0);
	}

	function validateUpdate($oldPassword, $newPassword, $confirmPassword)
	{
		$errors = $this->validateCommonFields();
		if(!empty($newPassword))
		{
			if(!password_verify($oldPassword, $this->password))
				$errors[] = "Old password is not correct";
			if($newPassword != $confirmPassword)
				$errors[] = "New password and confirmation password are not the same";
			if(strlen($newPassword) < 5 || strlen($newPassword) > 255)
				$errors[] = "New password must have between 5 and 255 characters";
		}

		Application::appendErrors($errors);
		return (count($errors) == 0);
	}

	function login2($username, $password, $rememberPassword)
	{
		if($this->username == $username && password_verify($password, $this->password) && $this->active == 1)
		{
			$this->logged_in = 1;
			if ($rememberPassword == 1)
			{
				$login_code = Tools::getRandomChars(20);
				$this->login_code = password_hash($login_code, PASSWORD_DEFAULT);
				$db = Application::getDb();
				$db->tbUser->updateObj($this);
				setcookie("username", $this->username, time() + 60 * 60 * 24 * 14, "/");
				setcookie("login_code", $login_code, time() + 60 * 60 * 24 * 14, "/");
			}
			return true;
		}
		else
		{
			$this->logged_in = 0;
			if(!password_verify($password, $this->password))
				Application::addError("Password is not correct");
			elseif (!$this->wasActivated())
				Application::addError("You must first activate your account before you can login");
			elseif ($this->isDeactivated())
				Application::addError("Your account has been deactivated, please contact our support personnel for more details");
		}
		return ($this->logged_in == 1);
	}

	function loginFromCookie2($username, $login_code)
	{
		if($this->username == $username && password_verify($login_code, $this->login_code) && $this->active == 1)
		{
			$this->logged_in = 1;
			return true;
		}
		else
		{
			$this->logged_in = 0;
		}
		return ($this->logged_in == 1);
	}

	/**
	 * is this user active, can he login?
	 */
	function isActive()
	{
		return ($this->active == "1");
	}

	/**
	 * did the user ever entered the activation code?
	 */
	function wasActivated()
	{
		return (strlen($this->activation_code) == 0);
	}

	/**
	 * is this user deactivated by an admin?
	 */
	function isDeactivated()
	{
		return (!$this->isActive() && $this->wasActivated());
	}

	function activate()
	{
		$this->active = "1";
		$this->activation_code = "";
	}

	function toStr($humanReadable = false, $brief = false)
	{
		if($humanReadable)
		{
			if($brief)
			{
				$s = "
" . translate("customer ID") . ": {$this->id}";
			}
			else
			{
				$s = "
" . translate("User account, with IP address") . " {$this->ip}
" . translate("ID") . ": {$this->id}
" . translate("Username") . ": {$this->username}
" . translate("Email") . ": {$this->email2}
" . translate("Account type") . ": {$this->acc_type}
" . translate("Registered date") . ": {$this->date_registered}
" . translate("Active account") . ": {$this->active} (1 = active, 0 = inactive)
" . translate("Activation code") . ": {$this->activation_code}
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
		if($this->id == 0) {
			$this->email2 = $this->email;
			$this->email = md5($this->email);
		}
		
		$arr = array('email2', 'date_registered');
		foreach($arr as $prop) {
			$this->$prop = Tools::encrypt($this->$prop, Application::getConfigValue('openssl_key'));
		}
	}
	
	function decrypt()
	{
		$arr = array('email2', 'date_registered');
		foreach($arr as $prop) {
			$this->$prop = Tools::decrypt($this->$prop, Application::getConfigValue('openssl_key'));
		}
	}
}









?>