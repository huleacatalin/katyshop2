<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

function template_include_shopping_cart_box() {
	// local variables scope so they don't conflict with the global ones
	$user = Visitor::getInstance();
	$basket = Application::getShoppingCart();

	if (!$user->isAdminLoggedIn()) {
		?>
		<ul>
			<li class="widget products-box" style="margin-bottom: 0px; padding-bottom: 0px; ">
				<h2><a href="shopping_cart.php"><?php echo htmlspecialchars(translate("Shopping cart")); ?></a></h2>
			</li>
		<?php
		if($basket->getProductsCount() == 0)
		{
			?>
			<p><?php echo htmlspecialchars(translate("The cart is empty")); ?></p>
			<?php
		}
		else
		{
			?>
			<ul>
			<?php
			for($i = 0; $i < $basket->getProductsCount(); $i++)
			{
				$op = $basket->getOrderProduct($i + 1);
				?>
				<li>
					<a href="javascript:removeOrderProduct('<?php echo intval($op->line_number); ?>'); " title="remove product"><img src="html/PCStore/img/icons/delete.png" alt="remove product"></a>
					<big><b><?php echo htmlspecialchars($op->quantity); ?></b></big>
					<a href="product.php?id_product=<?php echo htmlspecialchars($op->id_product); ?>"><?php echo htmlspecialchars($op->product_name); ?></a>
				</li>
				<?php
			}
			?>
			</ul>
			<p><?php echo htmlspecialchars(translate("Total to pay")); ?>: <?php echo htmlspecialchars(displayPrice($basket->total)); ?></p>
			<p style="padding-top: 1em; padding-bottom: 1em; "><a href="shopping_cart.php" class="button"><?php echo htmlspecialchars(translate("View cart")); ?> &gt;</a></p>
			<?php
		}
		?>
		</ul>
		<?php
	}
}
template_include_shopping_cart_box();
?>