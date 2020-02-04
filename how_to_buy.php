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
<h1>How to buy</h1>
<?php require_once(WEB_DIR . "/includes/print_messages.php"); ?>

<h2>Step 1</h2>
<ul>
<li>choose the product;</li>
<li>push the button (Add to cart);</li>
<li>add as many products as you wish;</li>
<li>when you want to see the contents of the cart, in the right upper side of the page you have the (Shopping cart) button;</li>
<li>in this section you can add or remove some of the products.</li>
</ul>

<h2>Step 2</h2>
<ul>
<li>if you are for the first time on our site you will have to register.
	You will choose a username and a login password. 
	You must also input data about invoicing and delivery of products to the address you wish.
	Fields marked with * are mandatory;</li>
<li>After checking these data you finish the registration by activating your account using the activation link or activation code you receive in the activation email.</li>
</ul>

<h2>Step 3</h2>
<ul>
<li>Your order will be received by our team and you will be contacted by phone or email asking for confirmation
and to establish date and time of delivery.</li>
</ul>

</div>
<?php require_once(WEB_DIR . "/includes/right.php"); ?>
<?php require_once(WEB_DIR . "/includes/footer.php"); ?>
</body>
</html>