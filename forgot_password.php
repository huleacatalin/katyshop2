<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(__FILE__) . "/init.php");
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
<h1>Forgot password?</h1>

<?php require_once(WEB_DIR . "/includes/print_messages.php"); ?>
<p>Use this form to generate a new password. If you didn't activate the account yet, the activation code will also be sent by email.</p>

<form method="post" action="formparser/user.php?action=forgot_password">
<label>Username: <input type="text" name="username" class="text"></label>
<label>Email: <input type="text" name="email" class="text"></label>
<input type="submit" value="Send" class="button">
</form>

</div>
<?php require_once(WEB_DIR . "/includes/right.php"); ?>
<?php require_once(WEB_DIR . "/includes/footer.php"); ?>
</body>
</html>