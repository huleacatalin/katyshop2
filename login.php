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

<div id="content">
<h1>Login</h1>
<?php require_once(WEB_DIR . "/includes/print_messages.php"); ?>

<form action="formparser/user.php?action=login" method="post">
<label>Username: <input type="text" name="username" class="text"></label>
<label>Password: <input type="password" name="password" class="text"></label>
<label><input type="checkbox" name="remember_password" value="1"> Remember my password</label>
<input type="submit" value="Login" class="button">
</form>

<ul>
<li><a href="forgot_password.php">Password or activation code forgotten?</a></li>
<li><a href="activate.php">Activation link</a></li>
<li><a href="register.php">Register new account</a></li>
</ul>

</div>
<?php require_once(WEB_DIR . "/includes/right.php"); ?>
<?php require_once(WEB_DIR . "/includes/footer.php"); ?>
</body>
</html>