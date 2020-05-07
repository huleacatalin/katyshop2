<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(__FILE__) . "/init.php");
require_once(dirname(__FILE__) . "/includes/req_admin.php");
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
<h1><?php echo htmlspecialchars(translate("Admin")); ?></h1>
<?php require_once(dirname(__FILE__) . "/includes/print_messages.php"); ?>
<nav>
<ul>
<li><a href="admin/index.php"><?php echo htmlspecialchars(translate("Admin")); ?></a></li>
<li><a href="admin/user.php"><?php echo htmlspecialchars(translate("Users")); ?></a></li>
<li><a href="admin/order.php"><?php echo htmlspecialchars(translate("Orders")); ?></a></li>
<li><a href="admin/manufacturer.php"><?php echo htmlspecialchars(translate("Manufacturers")); ?></a></li>
<li><a href="admin/contact_message.php"><?php echo htmlspecialchars(translate("Messages")); ?></a></li>
<li><a href="admin/category.php"><?php echo htmlspecialchars(translate("Products")); ?></a></li>
</ul>
</nav>

</main>
<?php require_once(dirname(__FILE__) . "/includes/right.php"); ?>
<?php require_once(dirname(__FILE__) . "/includes/footer.php"); ?>
</body>
</html>