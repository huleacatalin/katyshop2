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
<h1><?php echo htmlspecialchars(translate("Payment and delivery")); ?></h1>
<?php require_once(dirname(__FILE__) . "/includes/print_messages.php"); ?>
<article>
<h2><?php echo htmlspecialchars(translate("How do I pay?")); ?></h2>
<p>You can pay:
<ul>
<li>in cache, at delivery (for persons);</li>
<li>by bank payment order (persons or companies customers);</li>
</ul>
</p>

<p>Cache payment, for products delivered from the stock is made at delivery moment,
at the value from phone confirmation of the order. You pay the money to the
messenger who delivers you the products.</p>

<h2>Products delivery</h2>
<p>We deliver our product to locations from the entire country.
The products are stored as they were packaged and sealed by manufacturer
and they are under assurance on the route to delivery.</p>

<p>Minimal order value is 100 USD (without delivery taxes).</p>

<p>Delivery in New York:
<ul>
<li>FOR FREE to your address - if the value is more than 500 USD;</li>
<li>10 USD delivery fee - if the value is less than 500 USD; </li>
</ul>
</p>

<p>Delivery outside New York:
<ul>
<li>FOR FREE to your address - if the value is more than 500 USD;</li>
<li>20 USD delivery fee - if the value is less than 500 USD; </li>
<li>Return fee 20 USD - only if you pay in cache at delivery (fee required by courier delivery company);</li>
</ul>
</p>

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