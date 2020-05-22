<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

function template_include_header() {
	// local variables scope so they don't conflict with the global ones
	$user = Application::getUser();
	?>
	<a href="javascript:responsive_menu(); " id="responsive_menu"></a>
	<header id="HEADER">
	<a href="index.php"><img src="html/default/img/design/logo.jpg" id="logo"></a>
	<form id="logout_form" action="formparser/user.php?action=logout" method="post" style="display: none; ">
	<input type="hidden" name="logout" value="1">
	</form>

	<nav>
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
	</nav>

	<form action="index.php" method="get" id="choose_html_theme">
	<?php echo translate("Choose theme"); ?>: 
	<select name="html_theme" onchange="this.form.submit(); ">
	<option value="default" selected>Default</option>
	<option value="office_accessories">Office Accessories</option>
	<option value="PCStore">PC Store</option>
	<option value="book-store">Book Store</option>
	</select>
	</form>
	
	<form action="formparser/order.php?action=remove_product" method="post" id="frm_remove_product">
	<input type="hidden" name="line_number" value="0">
	</form>

	<div id="search_box">
	<form action="search.php" method="get">
	<input type="search" name="keywords" value="<?php echo htmlspecialchars(@$_GET["keywords"]); ?>" class="search" onfocus="this.select(); "><input type="submit" value="Search!" class="button">
	<a href="advanced_search.php?<?php echo Tools::http_build_query2($_GET); ?>"><?php echo htmlspecialchars(translate("advanced")); ?> &raquo;</a>
	</form>
	</div>

	<br clear="all">
	</header>
	<?php
}
template_include_header();
?>