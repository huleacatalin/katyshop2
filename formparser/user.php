<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(dirname(__FILE__)) . "/init.php");

if(@$_GET["action"] == "register")
{
	$user = Application::getUser();
	if($user->isUserLoggedIn())
		Application::addError("You may not use the register form because you are logged in");
	elseif(@$_POST["acc_type"] == "person")
		$registerUser = new UserPerson();
	elseif (@$_POST["acc_type"] == "company")
		$registerUser = new UserCompany();
	else
		Application::addError("Please choose a valid account type");

	if(array_key_exists("activation_code", @$_POST))
		Application::addError("Your browser sent a request that our server could not understand");
	if(is_a($registerUser, "User") && !Application::hasErrors())
	{
		$registerUser->copyFromArray(@$_POST);
		$registerUser->readDate("birth_date", @$_POST["birth_date"]);
		$registerUser->active = 0;
		$registerUser->login_code = "";
		if($registerUser->validateRegister(@$_POST["confirm_password"]))
		{
			$registerUser->password = password_hash($registerUser->password, PASSWORD_DEFAULT);
			$db = Application::getDb();
			$db->tbUser->insertObj($registerUser);

			$mailAgent = Application::getMailAgent();
			if(!$mailAgent->registrationMail($registerUser, @$_POST["password"]))
				Application::addError("Our mail server doesn't work properly for the moment, the mail with activation code could not be sent");

			Application::addMessage("Your account has been created");
		}
	}

	if(Application::hasErrors())
	{
		SessionWrapper::set("registerUser", $registerUser);
		Tools::redirect("../register.php");
	}
	else
	{
		SessionWrapper::set("registerUser", "");
		Tools::redirect("../login.php");
	}
}
elseif (@$_GET["action"] == "login")
{
	$user = Application::getUser();
	if($user->isUserLoggedIn())
		Application::addError("You are already authenticated");
	else
		$user = Application::login(@$_POST["username"], @$_POST["password"], intval(@$_POST["remember_password"]));

	if($user->isUserLoggedIn())
	{
		Application::addMessage("You logged in");
		if(SessionWrapper::get("login_return_to_cart") == "true")
			Tools::redirect("../shopping_cart.php");
		elseif(is_a($user, "Admin"))
			Tools::redirect('../admin/');
		else
			Tools::redirect("../profile.php");
	}
	else
	{
		Application::addError("Login failed");
		Tools::redirect("../login.php");
	}
}
elseif (@$_GET["action"] == "logout")
{
	if(@$_POST["logout"] == 1)
		Application::logout();
	Tools::redirect("../index.php");
}
elseif (@$_GET["action"] == "profile")
{
	$db = Application::getDb();
	$user = Application::getUser();
	if(!$user->isUserLoggedIn())
		Tools::redirect("../login.php");

	// get the real class of user - UserPerson, UserCompany
	$updateUser = Factory::instantiateUser($user);

	// fill $updateUser with all data from $_POST. This is not secure yet,
	// because bogus data could be sent, such as ip, id, username, active... properties.
	$updateUser->copyFromArray($_POST);
	$updateUser->readDate("birth_date", @$_POST["birth_date"]);

	// protect sensitive data:
	$userData = new User();
	// copy from $user only the properties related to User class
	$userData->copyFromObject($user);
	// put back to $updateUser the real data from database,
	// properties from User class, that are not supposed to be edited from profile page.
	$updateUser->copyFromObject($userData);
	// at this moment, User class properties of $updateUser are secure, as they are in database,
	// and all data related to UserPerson and UserCompany is edited by user, as it was sent from $_POST.

	if($updateUser->validateUpdate(@$_POST["old_password"], @$_POST["password"], @$_POST["confirm_password"]))
	{
		if(!empty($_POST["password"]))
			$updateUser->password = password_hash($_POST["password"], PASSWORD_DEFAULT);
		$db->tbUser->updateObj($updateUser);
		SessionWrapper::set("Application_user", $updateUser);
		Application::addMessage("Your profile has been updated");
	}

	if(Application::hasErrors())
		SessionWrapper::set("updateUser", $updateUser);
	else
		SessionWrapper::set("updateUser", "");

		SessionWrapper::set("updateUser", $updateUser);
	Tools::redirect("../profile.php");
}
elseif(@$_GET["action"] == "forgot_password")
{
	$db = Application::getDb();
	$u = $db->tbUser->getUserByUsername(@$_POST["username"]);
	$u = Factory::instantiateUser($u);
	if($u->id == 0)
	{
		Application::addError("This username doesn't exists");
	}
	elseif(empty($_POST["email"]))
	{
		Application::addError("Please enter email address");
	}
	elseif($u->email2 != @$_POST["email"])
	{
		Application::addError("Email address is not correct");
	}
	else
	{
		$newPass = Tools::getRandomChars(10);
		$u->password = password_hash($newPass, PASSWORD_DEFAULT);
		$db->tbUser->updateObj($u);
		Application::addMessage("A new random password has been generated");
		$mailAgent = Application::getMailAgent();
		if($mailAgent->forgotPasswordMail($u, $newPass))
			Application::addMessage("Please check your email address to receive the new password, you will be able to use this new password to authenticate yourself.");
		else
			Application::addError("Our mail server doesn't work properly, the mail with random password could not be sent. Please try again later.");
	}

	if(Application::hasErrors())
		Tools::redirect("../forgot_password.php");
	else
		Tools::redirect("../login.php");
}



?>