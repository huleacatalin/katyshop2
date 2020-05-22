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
<h1><?php echo htmlspecialchars(translate("Login")); ?></h1>
<?php require_once(dirname(__FILE__) . "/includes/print_messages.php"); ?>

<form action="formparser/user.php?action=login" method="post">
<label><?php echo htmlspecialchars(translate("Username")); ?>: <input type="text" name="username" required class="text"></label>
<label><?php echo htmlspecialchars(translate("Password")); ?>: <input type="password" name="password" required class="text"></label>
<label><input type="checkbox" name="remember_password" value="1"> <?php echo htmlspecialchars(translate("Remember my password")); ?></label>
<input type="submit" value="<?php echo htmlspecialchars(translate("Login")); ?>" class="button">
</form>

<div class="cl"></div>

<ul style="margin-top: 1em; margin-left: 1em; ">
<li><a href="register.php" style="font-weight: bold; font-size: 1.4em; "><?php echo htmlspecialchars(translate("Register new account")); ?></a></li>
<li><a href="forgot_password.php"><?php echo htmlspecialchars(translate("Password or activation code forgotten?")); ?></a></li>
<li><a href="activate.php"><?php echo htmlspecialchars(translate("Activation link")); ?></a></li>
</ul>

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