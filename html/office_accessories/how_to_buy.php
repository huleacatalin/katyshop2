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
	<!-- Wrapper -->
	<div id="wrapper">
		<div id="wrapper-bottom">
			<div class="shell">
				<?php require_once(dirname(__FILE__) . "/includes/header.php"); ?>
				<!-- Main -->
				<div id="main">
					
						<!-- Featured Products -->
						<div class="products-holder" style="margin-left: 5px; ">
							<div class="top"></div>
							<div class="middle">
								<div class="cl"></div>

								<a href="shopping_cart.php" class="cart_micro"><?php echo translate('View cart'); ?> &raquo; </a>
								<div class="cl"></div>
<article>
<h1><?php echo htmlspecialchars(translate("How to buy")); ?></h1>
<?php require_once(dirname(__FILE__) . "/includes/print_messages.php"); ?>

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

</article>
								<div class="cl"></div>
							</div>
							<div class="bottom"></div>									
						</div>
						<!-- END Featured Products -->
						
				</div>
				<!-- END Main -->
			</div>
		</div>
		<div id="footer-push"></div>
	</div>
	<!-- END Wrapper -->
	<?php require_once(dirname(__FILE__) . "/includes/footer.php"); ?>
</body>
</html>