<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(__FILE__) . "/init.php");

if(!empty($_GET["username"]))
{
	$db = Application::getDb();
	$u = $db->tbUser->getUserByUsername($_GET["username"]);
	$u = Factory::instantiateUser($u);
	if($u->id == 0)
	{
		Application::addError("This username could not be found");
	}
	elseif($u->isActive())
	{
		Application::addMessage("Account is active you may now login");
		Tools::redirect("login.php", true);
	}
	elseif($u->isDeactivated())
	{
		$errors[] = "This user has been deactivated by an admin and cannot be used for login. Please contact the support department";
	}
	elseif($u->activation_code == @$_GET["activation_code"])
	{
		$u->activate();
		$db->tbUser->updateObj($u);
		Application::addMessage("Congratulations, your account has been activated. You may now login.");
		Tools::redirect("login.php", true);
	}
	elseif($u->activation_code != @$_GET["activation_code"])
	{
		Application::addError("Wrong activation code");
	}
}
?>
<html>
<head>
<title><?php echo APP_NAME; ?></title>
<?php require_once(WEB_DIR . "/includes/html_head.php"); ?>
</head>

<body>
<?php require_once(WEB_DIR . "/includes/header.php"); ?>
<?php require_once(WEB_DIR . "/includes/left.php"); ?>
<main>
<h1><?php echo translate("User account activation"); ?></h1>
<?php require_once(WEB_DIR . "/includes/print_messages.php"); ?>

<form method="get" action="activate.php">
<label><?php echo translate("Username"); ?>: <input type="text" name="username" required class="text"></label>
<label><?php echo translate("Activation code"); ?>: <input type="text" name="activation_code" required class="text"></label>
<input type="submit" value="<?php echo translate("Activate"); ?>" class="button">
</form>

</main>
<?php require_once(WEB_DIR . "/includes/right.php"); ?>
<?php require_once(WEB_DIR . "/includes/footer.php"); ?>
</body>
</html>