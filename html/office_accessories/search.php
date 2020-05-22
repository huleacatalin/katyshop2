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
							</div>
							<div class="bottom"></div>									
						</div>
						<!-- END Featured Products -->

<?php require_once(dirname(__FILE__) . "/includes/print_messages.php"); ?>

<a href="advanced_search.php?<?php echo Tools::http_build_query2($_GET); ?>"><?php echo htmlspecialchars(translate("advanced")); ?> <?php echo htmlspecialchars(translate("search")); ?> &raquo;</a>
<?php
require_once(dirname(__FILE__) . "/includes/products_list.php");
?>

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