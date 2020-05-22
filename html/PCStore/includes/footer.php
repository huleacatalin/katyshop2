<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

function template_include_footer() {
	// local variables scope so they don't conflict with the global ones
	$user = Application::getUser();
	?>
	
			<div class="cl">&nbsp;</div>
	<!-- Begin Footer -->
	<div id="footer" style="margin: 0; padding: 0; height: 55px; ">
		<div class="shell">
			<p class="bottom-menu" style="padding-top: 1em; ">
	
	<a href="terms.php"><?php echo htmlspecialchars(translate("Terms and conditions")); ?></a><span>|</span>
	<a href="how_to_buy.php"><?php echo htmlspecialchars(translate("How to buy")); ?></a><span>|</span>
	<a href="payment_and_delivery.php"><?php echo htmlspecialchars(translate("Payment and delivery")); ?></a><span>|</span>
	<?php
	if($user->isAdminLoggedIn())
	{
		?><a href="admin/index.php"><?php echo htmlspecialchars(translate("Admin")); ?></a><span>|</span><?php
	}
	if($user->isUserLoggedIn())
	{
		?>
		<a href="profile.php"><?php echo htmlspecialchars(translate("Profile")); ?></a><span>|</span>
		<?php
		if(!$user->isAdminLoggedIn())
		{
			?><a href="address.php"><?php echo htmlspecialchars(translate("My addresses")); ?></a><span>|</span><?php
		}
		?>
		<a href="javascript:logout(); " class="right_item"><?php echo htmlspecialchars(translate("Logout")); ?></a>
		<?php
	}
	else
	{
		?>
		<a href="register.php"><?php echo htmlspecialchars(translate("New account")); ?></a><span>|</span>
		<a href="login.php" class="right_item"><?php echo htmlspecialchars(translate("Login")); ?></a>
		<?php
	}
	?>
	</p>
	
	<div style="float: right; padding-top: 5px; width: 150px; height: 50px; ">
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
	<input type="hidden" name="cmd" value="_s-xclick" />
	<input type="hidden" name="hosted_button_id" value="PTECD6QEKB5LY" />
	<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
	<img alt="" border="0" src="https://www.paypal.com/en_RO/i/scr/pixel.gif" width="1" height="1" />
	</form>
	</div>

	<p style="float: left; padding-top: 3px; ">Copyright &copy; PC Store 2012. Design by: <a href="http://css-free-templates.com/" title="CSS Free Templates">CSS-Free-Templates</a>. All Rights Reserved. </p>

	<p id="powered_by_katyshop2" style="margin: 0; padding: 0; padding-top: 5px; "><a href="https://katyshop2.sourceforge.io" target="_blank" id="copyleft" style="margin: 0; padding: 0; ">Powered by Katyshop2 2020</a></p>

			<div class="cl" style="margin: 0; padding: 0; height: 1px; overflow: hidden; ">&nbsp;</div>
		</div>
	</div>
	<!-- End Footer -->
	<?php
}
template_include_footer();
$db = Application::getDb();
$db->close();
?>