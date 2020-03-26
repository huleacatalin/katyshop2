<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

if($productsCount > 0)
{
	?>
	<a name="products"></a>
	<h3><?php echo $pageTitle; ?></h3>
	<table cellspacing="0" id="products_list">
	<tr>
	<td></td>
	<td><?php echo translate("Product"); ?>
		<?php
		displayOrderBy($id_category, "title", "asc", $page, "products");
		displayOrderBy($id_category, "title", "desc", $page, "products");
		?>
	</td>
	<td><?php echo translate("Price"); ?>
		<?php
		displayOrderBy($id_category, "price", "asc", $page, "products");
		displayOrderBy($id_category, "price", "desc", $page, "products");
		?>
	</td>
	<td></td>
	</tr>
	<?php
	for($i = 0; $i < count($list); $i++)
	{
		$p = $list[$i];
		if(!$p->canBeDisplayed())
			continue;
		?>
		<tr valign="top" class="border_top">
		<td align="center">
		<?php
		if(!empty($p->picture) && is_file(WEB_DIR . "/img/products/small/{$p->picture}"))
		{
			?>
			<a href="product.php?id_product=<?php echo intval($p->id); ?>">
			<img src="img/products/small/<?php echo htmlspecialchars($p->picture); ?>">
			</a>
			<?php
		}
		?>
		</td>
		<td>
		<h3><a href="product.php?id_product=<?php echo intval($p->id); ?>"><?php echo htmlspecialchars($p->title); ?></a></h3>
		<p class="description"><a href="product.php?id_product=<?php echo intval($p->id); ?>"><?php echo nl2br(htmlspecialchars($p->description)); ?></a></p>
		<?php
		if(!empty($p->manufacturer))
		{
			?>
			<p class="manufacturer"><?php echo translate("Manufacturer"); ?>: <?php echo htmlspecialchars($p->manufacturer); ?></p>
			<?php
		}
		?>
		</td>
		<td class="price">
		<?php echo displayPrice($p->price); ?> <?php echo htmlspecialchars(Application::getConfigValue("default_currency")); ?>
		</td>

		<td>
		<form action="formparser/order.php?action=add_to_cart" method="post">
		<input type="hidden" name="id_product" value="<?php echo htmlspecialchars(@$p->id); ?>">
		<input type="submit" value="<?php echo translate("Add to the cart"); ?>" class="button">
		</form>
		</td>
		</tr>
		<?php
	}
	?>
	</table>
	<?php
	echo getListPages($productsCount);
}
?>