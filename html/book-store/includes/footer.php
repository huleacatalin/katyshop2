<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

function template_include_footer() {
	// local variables scope so they don't conflict with the global ones
	$user = Application::getUser();
	?>
	
    <div id="templatemo_footer">
    
	<div style="float: right; ">
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
	<input type="hidden" name="cmd" value="_s-xclick" />
	<input type="hidden" name="hosted_button_id" value="PTECD6QEKB5LY" />
	<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
	<img alt="" border="0" src="https://www.paypal.com/en_RO/i/scr/pixel.gif" width="1" height="1" />
	</form>
	</div>

	<nav>
	<a href="terms.php"><?php echo htmlspecialchars(translate("Terms and conditions")); ?></a> <span class="bar">|</span>
	<a href="how_to_buy.php"><?php echo htmlspecialchars(translate("How to buy")); ?></a> <span class="bar">|</span>
	<a href="payment_and_delivery.php"><?php echo htmlspecialchars(translate("Payment and delivery")); ?></a> <span class="bar">|</span>
	<?php
	if($user->isAdminLoggedIn())
	{
		?><a href="admin/index.php"><?php echo htmlspecialchars(translate("Admin")); ?></a> <span class="bar">|</span><?php
	}
	if($user->isUserLoggedIn())
	{
		?>
		<a href="profile.php"><?php echo htmlspecialchars(translate("Profile")); ?></a> <span class="bar">|</span>
		<?php
		if(!$user->isAdminLoggedIn())
		{
			?><a href="address.php"><?php echo htmlspecialchars(translate("My addresses")); ?></a> <span class="bar">|</span><?php
		}
		?>
		<a href="javascript:logout(); " class="right_item"><?php echo htmlspecialchars(translate("Logout")); ?></a>
		<?php
	}
	else
	{
		?>
		<a href="register.php"><?php echo htmlspecialchars(translate("New account")); ?></a> <span class="bar">|</span>
		<a href="login.php" class="right_item"><?php echo htmlspecialchars(translate("Login")); ?></a>
		<?php
	}
	?>
	</nav>

	<a href="https://katyshop2.sourceforge.io" target="_blank" id="copyleft">Powered by Katyshop2 2020</a>

        Design by <a href="https://www.templatemo.com"><strong>www.templatemo.com</strong></a> 
        <!-- Credit: www.templatemo.com -->	</div> 
    <!-- end of footer -->
	<?php
}
template_include_footer();
$db = Application::getDb();
$db->close();
?>