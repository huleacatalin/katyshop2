<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

$user = Application::getUser();
?>
<br clear="all">

<footer>

<nav>
<ul>
<li><a href="terms.php"><?php echo translate("Terms and conditions"); ?></a></li>
<li><a href="how_to_buy.php"><?php echo translate("How to buy"); ?></a></li>
<li><a href="payment_and_delivery.php"><?php echo translate("Payment and delivery"); ?></a></li>
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
		?><li><a href="address.php"><?php echo translate("My addresses"); ?></a></li><?php
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

<div style="float: right; margin-top: 10px; ">
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick" />
<input type="hidden" name="hosted_button_id" value="PTECD6QEKB5LY" />
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
<img alt="" border="0" src="https://www.paypal.com/en_RO/i/scr/pixel.gif" width="1" height="1" />
</form>
</div>

<a href="https://katyshop2.sourceforge.io" target="_blank" id="copyleft">Copyleft 2020 Katyshop2</a>

<br clear="all">
</footer>
<?php
$db = Application::getDb();
$db->close();
?>