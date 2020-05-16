<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

if($productsCount > 0)
{
	?>
	<a name="products"></a>
	<h3><?php echo htmlspecialchars($pageTitle); ?></h3>
	
	<?php
	for($i = 0; $i < count($products); $i++)
	{
		$p = $products[$i];
		if(!$p->canBeDisplayed())
			continue;
		?>
	
		<div class="templatemo_product_box">
			<h1><a href="product.php?id_product=<?php echo intval($p->id); ?>"><?php echo htmlspecialchars($p->title); ?></a></h1>
			<?php
			if(!empty($p->picture) && is_file(WEB_DIR . "/img/products/small/{$p->picture}"))
			{
				?>
				<a href="product.php?id_product=<?php echo intval($p->id); ?>">
				<img src="img/products/small/<?php echo htmlspecialchars($p->picture); ?>">
				</a>
				<?php
			}
			else {
				?>
				<a href="product.php?id_product=<?php echo intval($p->id); ?>">
				<img src="html/book-store/img/design/no-img.jpg">
				</a>
				<?php
			}
			?>
			<div class="product_info">
				<p><?php echo htmlspecialchars($p->description); ?></p>
				<h3><?php echo htmlspecialchars(Application::getConfigValue("default_currency")); ?> <?php echo htmlspecialchars(displayPrice($p->price)); ?></h3>
				
				<form action="formparser/order.php?action=add_to_cart" method="post">
				<input type="hidden" name="id_product" value="<?php echo htmlspecialchars(@$p->id); ?>">
				<input type="submit" value="<?php echo htmlspecialchars(translate("Add to the cart")); ?>" class="button">
				</form>
				<div class="detail_button"><a href="product.php?id_product=<?php echo intval($p->id); ?>">Detail</a></div>
			</div>
			<div class="cleaner">&nbsp;</div>
		</div>
	
		<?php
		if($i % 2 == 0) {
			?>
            <div class="cleaner_with_width">&nbsp;</div>
			<?php
		}
		else {
			?>
			<div class="cleaner_with_height">&nbsp;</div>
			<?php
		}
	}
	?>
	<div class="cleaner_with_height">&nbsp;</div>
	<?php
	echo getListPages($productsCount);
}
?>