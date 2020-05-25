<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

if($productsCount > 0)
{
	?>
	<a name="products"></a>
	<!-- Featured Products -->
	<div class="products-holder">
		<div style="margin-left: -5px; ">
			<span class="label-left"></span>												
			<div class="label-bg">
				<h3 style="color: white; "><?php echo htmlspecialchars($pageTitle); ?></h3>									
			</div>
			<span class="label-right"></span>
			<div class="cl"></div>
		</div>
		<div class="top" style="margin-top: -20px; "></div>
		<div class="middle">
			<?php
			for($i = 0; $i < count($products); $i++)
			{
				$p = $products[$i];
				if(!$p->canBeDisplayed())
					continue;
				?>
				<div class="product">
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
						<img src="html/office_accessories/img/design/no-img.jpg">
						</a>
						<?php
					}
					?>

					<div class="desc">
						<p class="name"><a href="product.php?id_product=<?php echo intval($p->id); ?>"><?php echo htmlspecialchars($p->title); ?></a></p>
						<?php
						if(!empty($p->manufacturer))
						{
							?>
							<p><?php echo htmlspecialchars(translate("Manufacturer")); ?>: <span><?php echo htmlspecialchars($p->manufacturer); ?></span></p>
							<?php
						}
						?>
						
						<form action="formparser/order.php?action=add_to_cart" method="post" style="margin-top: 5px; ">
						<input type="hidden" name="id_product" value="<?php echo htmlspecialchars(@$p->id); ?>">
						<input type="submit" value="<?php echo htmlspecialchars(translate("Add to the cart")); ?>" class="button">
						</form>
					</div>
					
					<div class="price-box">
						<p><span class="price"><?php echo htmlspecialchars(displayPrice($p->price)); ?></span> <?php echo htmlspecialchars(Application::getConfigValue("default_currency")); ?></p>
						<p class="per-peace">Per <?php echo htmlspecialchars($p->measuring_unit); ?></p>
					</div>
					<div class="cl"></div>
				</div><!-- END <div class="product"> -->
				<?php
			}
			?>
			
			<div class="cl"></div>	
		</div>
		<div class="bottom"></div>
	</div>
	<!-- END Featured Products -->
	<?php
	echo getListPages($productsCount);
}
?>