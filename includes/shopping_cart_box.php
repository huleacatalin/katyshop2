<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

?>
<div id="shopping_cart_box">
<h3><a href="shopping_cart.php"><?php echo translate("Shopping cart"); ?></a></h3>
<?php
$basket = Application::getShoppingCart();
if($basket->getProductsCount() == 0)
{
	?>
	<p><?php echo translate("The cart is empty"); ?></p>
	<?php
}
else
{
	$basket->computeValue();
	?>
	<ul>
	<?php
	for($i = 0; $i < $basket->getProductsCount(); $i++)
	{
		$op = $basket->getOrderProduct($i + 1);
		?>
		<li>
			<a href="javascript:removeProduct('<?php echo intval($op->line_number); ?>'); " title="remove product"><img src="img/icons/delete.png" alt="remove product"></a>
			<big><b><?php echo htmlspecialchars($op->quantity); ?></b></big>
			<a href="product.php?id_product=<?php echo htmlspecialchars($op->id_product); ?>"><?php echo htmlspecialchars($op->product_name); ?></a>
		</li>
		<?php
	}
	?>
	</ul>
	<p><?php echo translate("Total to pay"); ?>: <?php echo htmlspecialchars(displayPrice($basket->total)); ?></p>
	<?php
}
?>
</div>
