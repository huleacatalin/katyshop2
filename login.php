<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(__FILE__) . "/init.php");

$user = Application::getUser();
if($user->isUserLoggedIn())
	Tools::redirect("index.php");
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
<h1><?php echo translate("Login"); ?></h1>
<?php require_once(WEB_DIR . "/includes/print_messages.php"); ?>

<form action="formparser/user.php?action=login" method="post">
<label><?php echo translate("Username"); ?>: <input type="text" name="username" required class="text"></label>
<label><?php echo translate("Password"); ?>: <input type="password" name="password" required class="text"></label>
<label><input type="checkbox" name="remember_password" value="1"> <?php echo translate("Remember my password"); ?></label>
<input type="submit" value="<?php echo translate("Login"); ?>" class="button">
</form>

<ul>
<li><a href="register.php" style="font-weight: bold; font-size: 1.4em; "><?php echo translate("Register new account"); ?></a></li>
<li><a href="forgot_password.php"><?php echo translate("Password or activation code forgotten?"); ?></a></li>
<li><a href="activate.php"><?php echo translate("Activation link"); ?></a></li>
</ul>

</main>
<?php require_once(WEB_DIR . "/includes/right.php"); ?>
<?php require_once(WEB_DIR . "/includes/footer.php"); ?>
</body>
</html>