<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(dirname(__FILE__)) . "/init.php");
require_once(WEB_DIR . "/includes/req_admin.php");
?>
<html>
<head>
<title><?php echo APP_NAME; ?></title>
<?php require_once(WEB_DIR . "/includes/html_head.php"); ?>
</head>

<body>
<?php require_once(WEB_DIR . "/includes/header.php"); ?>
<?php require_once(WEB_DIR . "/admin/includes/left.php"); ?>
<div id="content">
<h1>Admin</h1>
<?php require_once(WEB_DIR . "/includes/print_messages.php"); ?>
<ul>
<li><a href="admin/index.php">Admin</a></li>
<li><a href="admin/user.php">Users</a></li>
<li><a href="admin/order.php">Orders</a></li>
<li><a href="admin/manufacturer.php">Manufacturers</a></li>
<li><a href="admin/contact_message.php">Messages</a></li>
<li><a href="admin/category.php">Categories</a></li>
</ul>

</div>
<?php require_once(WEB_DIR . "/includes/right.php"); ?>
<?php require_once(WEB_DIR . "/includes/footer.php"); ?>
</body>
</html>