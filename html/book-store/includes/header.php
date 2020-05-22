<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

function template_include_header() {
	// local variables scope so they don't conflict with the global ones
	$user = Application::getUser();
	?>
	
	<form id="logout_form" action="formparser/user.php?action=logout" method="post" style="display: none; ">
	<input type="hidden" name="logout" value="1">
	</form>

	<a id="responsive_menu" href="javascript:responsive_menu(); "></a>
	<div id="templatemo_menu">
	<ul>
	<li><a href="index.php"><?php echo htmlspecialchars(translate("Home")); ?></a></li>
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
	
	<div id="search_box">
	<form action="search.php" method="get">
	<input type="search" name="keywords" value="<?php echo htmlspecialchars(@$_GET["keywords"]); ?>" class="search" onfocus="this.select(); "><input type="submit" value="Search!" class="button">
	<a href="advanced_search.php?<?php echo Tools::http_build_query2($_GET); ?>"><?php echo htmlspecialchars(translate("advanced")); ?> &raquo;</a>
	</form>
	</div>
    
    </div> <!-- end of menu -->

	<form action="index.php" method="get" id="choose_html_theme">
	<?php echo translate("Choose theme"); ?>: 
	<select name="html_theme" onchange="this.form.submit(); ">
	<option value="default">Default</option>
	<option value="office_accessories">Office Accessories</option>
	<option value="PCStore">PC Store</option>
	<option value="book-store" selected>Book Store</option>
	</select>
	</form>
	
	<form action="formparser/order.php?action=remove_product" method="post" id="frm_remove_product">
	<input type="hidden" name="line_number" value="0">
	</form>

    <div id="templatemo_header">
    	<div id="templatemo_special_offers">
        	<p>
                <span>25%</span> discounts for
        purchase over $80
        	</p>
			<a href="#" style="margin-left: 50px;">Read more...</a>
        </div>
        
        
        <div id="templatemo_new_books">
        	<ul>
                <li>Suspen disse</li>
                <li>Maece nas metus</li>
                <li>In sed risus ac feli</li>
            </ul>
            <a href="#" style="margin-left: 50px;">Read more...</a>
        </div>
    </div> <!-- end of header -->
    

	<?php
}
template_include_header();
?>