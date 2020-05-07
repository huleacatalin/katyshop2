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
		<div class="top"></div>
		<div class="middle">													
			<div class="label">
				<h3><?php echo htmlspecialchars($pageTitle); ?></h3>									
			</div>
			<div class="cl"></div>
			
			<?php
			for($i = 0; $i < count($products); $i++)
			{
				$p = $products[$i];
				if(!$p->canBeDisplayed())
					continue;
				?>
				<div class="product">
					<a href="product.php?id_product=<?php echo intval($p->id); ?>">
						<img src="img/products/small/<?php echo htmlspecialchars($p->picture); ?>">
					</a>

					<div class="desc">
						<p class="name"><?php echo htmlspecialchars($p->title); ?></p>
						<?php
						if(!empty($p->manufacturer))
						{
							?>
							<p><?php echo htmlspecialchars(translate("Manufacturer")); ?>: <span><?php echo htmlspecialchars($p->manufacturer); ?></span></p>
							<?php
						}
						?>
					</div>
					
					<div class="price-box">
						<p><span class="price"><?php echo htmlspecialchars(displayPrice($p->price)); ?></span> <?php echo htmlspecialchars(Application::getConfigValue("default_currency")); ?></p>
						<p class="per-peace">Per Peace</p>
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