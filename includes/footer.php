<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

?>
<br clear="all">

<div id="footer">

<div id="footer_menu">
<ul>
<li><a href="terms.php">Terms and conditions</a></li>
<li><a href="how_to_buy.php">How to buy</a></li>
<li><a href="payment_and_delivery.php">Payment and delivery</a></li>
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
		?><li><a href="address.php">My addresses</a></li><?php
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
</div>

<a href="https://sourceforge.net/projects/katyshop2" target="_blank" id="copyleft">Copyleft 2020 Katyshop2</a>

<br clear="all">
</div>
<?php
$db = Application::getDb();
$db->close();
?>