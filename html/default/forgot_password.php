<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

?>
<html>
<head>
<title><?php echo htmlspecialchars(APP_NAME); ?></title>
<?php require_once(dirname(__FILE__) . "/includes/html_head.php"); ?>
</head>

<body>
<?php require_once(dirname(__FILE__) . "/includes/header.php"); ?>
<?php require_once(dirname(__FILE__) . "/includes/left.php"); ?>
<main>
<h1><?php echo htmlspecialchars(translate("Forgot password?")); ?></h1>

<?php require_once(dirname(__FILE__) . "/includes/print_messages.php"); ?>
<p><?php echo htmlspecialchars(translate("Use this form to generate a new password. If you didn't activate the account yet, the activation code will also be sent by email.")); ?></p>

<form method="post" action="formparser/user.php?action=forgot_password">
<label><?php echo htmlspecialchars(translate("Username")); ?>: <input type="text" name="username" required class="text"></label>
<label><?php echo htmlspecialchars(translate("Email")); ?>: <input type="email" name="email" required class="text"></label>
<input type="submit" value="<?php echo htmlspecialchars(translate("Send")); ?>" class="button">
</form>

</main>
<?php require_once(dirname(__FILE__) . "/includes/right.php"); ?>
<?php require_once(dirname(__FILE__) . "/includes/footer.php"); ?>
</body>
</html>