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
	<!-- Begin Wrapper -->
	<div id="wrapper">
	
		<?php require_once(dirname(__FILE__) . "/includes/header.php"); ?>
		<!-- Begin Main -->
		<div id="main">
			<!-- Begin Inner -->
			<div class="inner">
				<div class="shell">
				
					<?php require_once(dirname(__FILE__) . "/includes/left.php"); ?>
					<!-- Begin Content -->
					<div id="content">
						<main>
						<article>
						<h2><?php echo htmlspecialchars(translate("How to buy")); ?><span class="title-bottom">&nbsp;</span></h2>
						<?php require_once(dirname(__FILE__) . "/includes/print_messages.php"); ?>

						<h2>Step 1<span class="title-bottom">&nbsp;</span></h2>
						<ul>
						<li>choose the product;</li>
						<li>push the button (Add to cart);</li>
						<li>add as many products as you wish;</li>
						<li>when you want to see the contents of the cart, in the right upper side of the page you have the (Shopping cart) button;</li>
						<li>in this section you can add or remove some of the products.</li>
						</ul>

						<h2>Step 2<span class="title-bottom">&nbsp;</span></h2>
						<ul>
						<li>if you are for the first time on our site you will have to register.
							You will choose a username and a login password. 
							You must also input data about invoicing and delivery of products to the address you wish.
							Fields marked with * are mandatory;</li>
						<li>After checking these data you finish the registration by activating your account using the activation link or activation code you receive in the activation email.</li>
						</ul>

						<h2>Step 3<span class="title-bottom">&nbsp;</span></h2>
						<ul>
						<li>Your order will be received by our team and you will be contacted by phone or email asking for confirmation
						and to establish date and time of delivery.</li>
						</ul>

						</article>
						</main>
					</div>
					<!-- End Content -->
					<?php require_once(dirname(__FILE__) . "/includes/right.php"); ?>
					<div class="cl">&nbsp;</div>
				</div>
			</div>
			<!-- End Inner -->
		</div>
		<!-- End Main -->
		<?php require_once(dirname(__FILE__) . "/includes/footer.php"); ?>
	</div>
	<!-- End Wrapper -->
</body>
</html>