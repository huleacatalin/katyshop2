<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

function template_include_header() {
	// local variables scope so they don't conflict with the global ones
	$user = Application::getUser();
	$basket = Application::getShoppingCart();
	$db = Application::getDb();
	$currentCategory = Application::getCurrentCategory();
	$categoriesTree = $db->tbCategory->getTree();
	?>
	<a id="responsive_menu" href="javascript:responsive_menu(); "></a>
	<!-- Header -->
	<div id="header">
		<!-- Logo -->
		<h1 id="logo"><a title="Home" href="index.php">accessories store</a></h1>
		
		<form action="index.php" method="get" id="choose_html_theme">
		<?php echo translate("Choose theme"); ?>: 
		<select name="html_theme" onchange="this.form.submit(); ">
		<option value="default">Default</option>
		<option value="office_accessories" selected>Office Accessories</option>
		<option value="PCStore">PC Store</option>
		<option value="book-store">Book Store</option>
		</select>
		</form>
		
		<p class="shopping-cart"><a class="cart" href="shopping_cart.php" title="Your Shopping Cart"><?php echo translate("Shopping cart"); ?></a><span><?php echo translate("Articles"); ?>:</span>&nbsp;<?php echo htmlspecialchars($basket->getProductsCount()); ?><span><?php echo translate("Cost"); ?>:</span>&nbsp;<?php echo htmlspecialchars(displayPrice($basket->total)); ?></p>

		<form action="formparser/order.php?action=remove_product" method="post" id="frm_remove_product">
		<input type="hidden" name="line_number" value="0">
		</form>

		<!-- Search -->
		<div class="search-expand"></div>
		<div id="search">
			<div class="retract-button">
				<p>retract</p>
			</div>
			<form action="search.php" method="get">
				<input type="search" name="keywords" value="<?php echo htmlspecialchars(@$_GET["keywords"]); ?>" class="field" onfocus="this.select(); ">
				<input type="submit" value="" class="submit-button" />
			</form>						
		</div>
		<!-- END Search -->
		<div class="cl"></div>
		
		<!-- Navigation -->
		<form id="logout_form" action="formparser/user.php?action=logout" method="post" style="display: none; ">
		<input type="hidden" name="logout" value="1">
		</form>
		
		<div id="navigation">
			<ul>
			<li><a href="how_to_buy.php"><?php echo htmlspecialchars(translate("How to buy")); ?></a></li>
			<li><a href="payment_and_delivery.php"><?php echo htmlspecialchars(translate("Payment")); ?></a></li>
			<li><a href="contact.php"><?php echo htmlspecialchars(translate("Contact")); ?></a></li>
			<?php
			if($user->isAdminLoggedIn())
			{
				?><li><a href="admin/index.php"><?php echo htmlspecialchars(translate("Admin")); ?></a></li><?php
			}
			if($user->isUserLoggedIn())
			{
				?>
				<li><a href="profile.php"><?php echo htmlspecialchars(translate("Profile")); ?></a></li>
				<?php
				if(!$user->isAdminLoggedIn())
				{
					?>
					<li><a href="address.php"><?php echo htmlspecialchars(translate("My addresses")); ?></a></li>
					<li><a href="orders_list.php"><?php echo htmlspecialchars(translate("My orders")); ?></a></li>
					<?php
				}
				?>
				<li><a href="javascript:logout(); " class="right_item"><?php echo htmlspecialchars(translate("Logout")); ?></a></li>
				<?php
			}
			else
			{
				?>
				<li><a href="register.php"><?php echo htmlspecialchars(translate("New account")); ?></a></li>
				<li><a href="login.php" class="right_item"><?php echo htmlspecialchars(translate("Login")); ?></a></li>
				<?php
			}
			?>
			</ul>						
		</div>	
		<div class="cl"></div>				
		<!-- END Navigation -->
		<!-- Dropdown Navigation -->
		<div id="sort-nav">						
			<span class="label-left"></span>
				<div class="label-bg">						
				<ul>
					<li>
						<a title="Categories" href="#"><?php echo htmlspecialchars(translate('Categories')); ?></a>							
						<div class="dd">
							<nav id="categories">
							<?php
							displayCategoriesTree($categoriesTree, 'category.php', $currentCategory);
							?>
							<br clear="all">
							</nav>
						</div>
					</li>
				</ul>
			</div>
			<span class="label-right"></span>									
		</div>					
		<!-- END Dropdown Navigation -->
		<div class="cl"></div>
	</div>
	<!-- END Header -->
	<?php
}
template_include_header();
?>