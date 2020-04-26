<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */
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