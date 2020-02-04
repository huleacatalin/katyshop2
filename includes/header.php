<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

?>
<div id="header">
<a href="index.php"><img src="img/design/logo.jpg" id="logo"></a>
<form id="logout_form" action="formparser/user.php?action=logout" method="post" style="display: none; ">
<input type="hidden" name="logout" value="1">
</form>

<div id="menu">
<ul>
<li><a href="how_to_buy.php">How to buy</a></li>
<li><a href="payment_and_delivery.php">Payment</a></li>
<li><a href="contact.php">Contact</a></li>
<?php
$user = Application::getUser();
if($user->isAdminLoggedIn())
{
	?><li><a href="admin/index.php">Admin</a></li><?php
}
if($user->isUserLoggedIn())
{
	?>
	<li><a href="profile.php">Profile</a></li>
	<?php
	if(!$user->isAdminLoggedIn())
	{
		?>
		<li><a href="address.php">My addresses</a></li>
		<li><a href="orders_list.php">My orders</a></li>
		<?php
	}
	?>
	<li><a href="javascript:logout(); " class="right_item">Logout</a></li>
	<?php
}
else
{
	?>
	<li><a href="register.php">New account</a></li>
	<li><a href="login.php" class="right_item">Login</a></li>
	<?php
}
?>
</ul>

<form action="formparser/order.php?action=remove_product" method="post" id="frm_remove_product">
<input type="hidden" name="line_number" value="0">
</form>

</div>

<div id="search_box">
<form action="search.php" method="get">
<input type="text" name="keywords" value="<?php echo htmlspecialchars(@$_GET["keywords"]); ?>" class="text" onfocus="this.select(); ">
<input type="submit" value="Search!" class="button">
<a href="advanced_search.php?<?php echo Tools::http_build_query2($_GET); ?>">advanced &raquo;</a>
</form>
</div>

<br clear="all">
</div>