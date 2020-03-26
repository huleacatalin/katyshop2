<?php

/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

class Visitor extends LogicObject
{
	var $ip = "";
	var $logged_in = 0;

	function __construct()
	{
		parent::__construct();
		$this->ip = $_SERVER['REMOTE_ADDR'];
	}

	/**
	 * @static
	 * @return Visitor
	 */
	static function getInstance()
	{
		global $Application;
		$user = $Application->user;
		// first try to get the user from global scope
		if(is_a($user, "Visitor"))
			return $user;

		// $user was not yet declared, try to get it from session
		$user = SessionWrapper::get("Application_user");

		if(!is_a($user, "User") && !empty($_COOKIE["username"]) && !empty($_COOKIE["login_code"]))
		{
			// is not logged in, try to login from cookie (remember password)
			$user = Visitor::loginFromCookie($_COOKIE["username"], $_COOKIE["login_code"]);
		}

		// if there is no user on the session, create a new Visitor
		if(!is_a($user, "User"))
			$user = new Visitor();
		return $user;
	}

	static function login($username, $password, $rememberPassword)
	{
		$user = new Visitor();
		$db = Application::getDb();
		if($db->tbUser->usernameExists($username))
		{
			$user = $db->tbUser->getUserByUsername($username);
			$user = Factory::instantiateUser($user);
			$user->login2($username, $password, $rememberPassword);
		}
		else
		{
			Application::addError("This username does not exist");
		}
		SessionWrapper::set("Application_user", $user);
		return $user;
	}

	static function loginFromCookie($username, $login_code)
	{
		$user = new Visitor();
		$db = Application::getDb();
		if($db->tbUser->usernameExists($username))
		{
			$user = $db->tbUser->getUserByUsername($username);
			$user = Factory::instantiateUser($user);
			$user->loginFromCookie2($username, $login_code);
		}
		return $user;
	}

	static function logout()
	{
		setcookie("username", "", time() - 60 * 60 * 24 * 14, "/");
		setcookie("login_code", "", time() - 60 * 60 * 24 * 14, "/");

		$db = Application::getDb();
		$user = Application::getUser();
		if(is_a($user, "User"))
			$db->tbUser->setLoginCode($user->id, "");

		$user = new Visitor();
		SessionWrapper::set("Application_user", $user);
		return $user;
	}

	function isUserLoggedIn()
	{
		return (is_a($this, "User") && $this->logged_in == 1);
	}

	function isPersonLoggedIn()
	{
		return (is_a($this, "UserPerson") && $this->logged_in == 1);
	}

	function isCompanyLoggedIn()
	{
		return (is_a($this, "UserCompany") && $this->logged_in == 1);
	}

	function isAdminLoggedIn()
	{
		return (is_a($this, "Admin") && $this->logged_in == 1);
	}

	function toStr($humanReadable = false, $brief = false)
	{
		if($humanReadable)
		{
			$s = translate("Unauthenticated user with IP address") . " {$this->ip}";
			return $s;
		}
		else
		{
			return parent::toStr();
		}
	}


}
?>