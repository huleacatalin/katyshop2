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
<h1><?php echo htmlspecialchars(translate("User account activation")); ?></h1>
<?php require_once(dirname(__FILE__) . "/includes/print_messages.php"); ?>

<form method="get" action="activate.php">
<label><?php echo htmlspecialchars(translate("Username")); ?>: <input type="text" name="username" required class="text"></label>
<label><?php echo htmlspecialchars(translate("Activation code")); ?>: <input type="text" name="activation_code" required class="text"></label>
<input type="submit" value="<?php echo htmlspecialchars(translate("Activate")); ?>" class="button">
</form>

</main>
<?php require_once(dirname(__FILE__) . "/includes/right.php"); ?>
<?php require_once(dirname(__FILE__) . "/includes/footer.php"); ?>
</body>
</html>