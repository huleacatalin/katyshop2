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
	<div class="products_list">
	<?php
	for($i = 0; $i < count($products); $i++)
	{
		$p = $products[$i];
		if(!$p->canBeDisplayed())
			continue;
		?>
		<article class="product">
		<header>
		<h3><a href="product.php?id_product=<?php echo intval($p->id); ?>"><?php echo htmlspecialchars($p->title); ?></a></h3>
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
			<img src="html/default/img/design/no-img.jpg">
			</a>
			<?php
		}
		?>
		<p class="description"><a href="product.php?id_product=<?php echo intval($p->id); ?>"><?php echo nl2br(htmlspecialchars($p->description)); ?></a></p>
		<?php
		if(!empty($p->manufacturer))
		{
			?>
			<p class="manufacturer"><?php echo htmlspecialchars(translate("Manufacturer")); ?>: <?php echo htmlspecialchars($p->manufacturer); ?></p>
			<?php
		}
		?>
		<?php echo htmlspecialchars(displayPrice($p->price)); ?> <?php echo htmlspecialchars(Application::getConfigValue("default_currency")); ?>
		
		<form action="formparser/order.php?action=add_to_cart" method="post">
		<input type="hidden" name="id_product" value="<?php echo htmlspecialchars(@$p->id); ?>">
		<input type="submit" value="<?php echo htmlspecialchars(translate("Add to the cart")); ?>" class="button">
		</form>
		
		</header>
		</article>
		<?php
	}
	?>
	</div><!-- END OF products_list -->
	<br clear="all">
	<?php
	echo getListPages($productsCount);
}
?>