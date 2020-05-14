<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

if($productsCount > 0)
{
	?>
	<a name="products"></a>
	<div id="products">
		<h2><?php echo htmlspecialchars($pageTitle); ?><span class="title-bottom">&nbsp;</span></h2>
		<?php
		for($i = 0; $i < count($products); $i++)
		{
			$p = $products[$i];
			if(!$p->canBeDisplayed())
				continue;
			?>
			<div class="product">
				<a href="product.php?id_product=<?php echo intval($p->id); ?>">
					<span class="title"><?php echo htmlspecialchars($p->title); ?></span>
					<?php
					if(!empty($p->picture) && is_file(WEB_DIR . "/img/products/small/{$p->picture}"))
					{
						?>
						<img src="img/products/small/<?php echo htmlspecialchars($p->picture); ?>">
						<?php
					}
					else {
						?>
						<img src="html/PCStore/img/design/no-img.jpg">
						<?php
					}
					
					if(!empty($p->manufacturer))
					{
						?>
						<span class="number"><?php echo htmlspecialchars($p->manufacturer); ?></span>
						<?php
					}
					?>
					<span class="price" style="padding-top: 5px; "><span><?php echo htmlspecialchars(Application::getConfigValue("default_currency")); ?></span><?php echo htmlspecialchars(displayPrice($p->price)); ?></span>
				</a>
				
			</div>
			<?php
		}
		?>
		<div class="cl">&nbsp;</div>
	</div>
	<!-- End Products -->
	<?php
	echo getListPages($productsCount);
}
?>