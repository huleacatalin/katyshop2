<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

function template_include_footer() {
	// local variables scope so they don't conflict with the global ones
	$user = Application::getUser();
	?>
	<br clear="all">

	<!-- Footer -->
	<div id="footer">
		<div class="shell">
			<a class="footer-logo" href="http://css-free-templates.com/" title="Home"><img src="html/office_accessories/css/images/logo-footer.png" alt="Logo" /></a>
			
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top" style="display: block; width: 150px; float: left; ">
			<input type="hidden" name="cmd" value="_s-xclick" />
			<input type="hidden" name="hosted_button_id" value="PTECD6QEKB5LY" />
			<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
			<img alt="" border="0" src="https://www.paypal.com/en_RO/i/scr/pixel.gif" width="1" height="1" />
			</form>
			
			<p id="bottom-nav">
				<a href="terms.php"><?php echo htmlspecialchars(translate("Terms and conditions")); ?></a>
				<a href="how_to_buy.php"><?php echo htmlspecialchars(translate("How to buy")); ?></a>
				<a href="payment_and_delivery.php"><?php echo htmlspecialchars(translate("Payment and delivery")); ?></a>
				<?php
				if($user->isAdminLoggedIn())
				{
					?><a href="admin/index.php"><?php echo htmlspecialchars(translate("Admin")); ?></a><?php
				}
				if($user->isUserLoggedIn())
				{
					?>
					<a href="profile.php"><?php echo htmlspecialchars(translate("Profile")); ?></a>
					<?php
					if(!$user->isAdminLoggedIn())
					{
						?><a href="address.php"><?php echo htmlspecialchars(translate("My addresses")); ?></a><?php
					}
					?>
					<a href="javascript:logout(); " class="right_item"><?php echo htmlspecialchars(translate("Logout")); ?></a>
					<?php
				}
				else
				{
					?>
					<a href="register.php"><?php echo htmlspecialchars(translate("New account")); ?></a>
					<a href="login.php" class="right_item"><?php echo htmlspecialchars(translate("Login")); ?></a>
					<?php
				}
				?>
				<a title="Design by: CSS Free Templates" href="http://css-free-templates.com/" style="display: block; float: right; margin-top: 5px; ">Design by: CSS Free Templates</a>
				<a href="https://katyshop2.sourceforge.io" target="_blank" style="display: block; float: right; margin-top: 5px; "><img src="html/office_accessories/img/design/logo_20.jpg" width="20"> Powered by Katyshop2 2020</a>
				
			</p>
			<div class="cl"></div>
		</div>
	</div>
	<!-- END Footer -->
	<?php
}
template_include_footer();
$db = Application::getDb();
$db->close();
?>