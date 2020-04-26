<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

$user = Application::getUser();
?>
<header id="HEADER">
<a href="index.php"><img src="img/design/logo.jpg" id="logo"></a>
<form id="logout_form" action="formparser/user.php?action=logout" method="post" style="display: none; ">
<input type="hidden" name="logout" value="1">
</form>

<nav>
<ul>
<li><a href="how_to_buy.php"><?php echo translate("How to buy"); ?></a></li>
<li><a href="payment_and_delivery.php"><?php echo translate("Payment"); ?></a></li>
<li><a href="contact.php"><?php echo translate("Contact"); ?></a></li>
<?php
if($user->isAdminLoggedIn())
{
	?><li><a href="admin/index.php"><?php echo translate("Admin"); ?></a></li><?php
}
if($user->isUserLoggedIn())
{
	?>
	<li><a href="profile.php"><?php echo translate("Profile"); ?></a></li>
	<?php
	if(!$user->isAdminLoggedIn())
	{
		?>
		<li><a href="address.php"><?php echo translate("My addresses"); ?></a></li>
		<li><a href="orders_list.php"><?php echo translate("My orders"); ?></a></li>
		<?php
	}
	?>
	<li><a href="javascript:logout(); " class="right_item"><?php echo translate("Logout"); ?></a></li>
	<?php
}
else
{
	?>
	<li><a href="register.php"><?php echo translate("New account"); ?></a></li>
	<li><a href="login.php" class="right_item"><?php echo translate("Login"); ?></a></li>
	<?php
}
?>
</ul>
</nav>

<form action="formparser/order.php?action=remove_product" method="post" id="frm_remove_product">
<input type="hidden" name="line_number" value="0">
</form>

<div id="search_box">
<form action="search.php" method="get">
<input type="search" name="keywords" value="<?php echo htmlspecialchars(@$_GET["keywords"]); ?>" class="search" onfocus="this.select(); ">
<input type="submit" value="Search!" class="button">
<a href="advanced_search.php?<?php echo Tools::http_build_query2($_GET); ?>"><?php echo translate("advanced"); ?> &raquo;</a>
</form>
</div>

<br clear="all">
</header>