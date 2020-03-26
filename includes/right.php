<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

?>
<div id="right">

<div id="login_form">
<?php
$user = Visitor::getInstance();
if(!$user->isUserLoggedIn())
{
	?>
	<form action="formparser/user.php?action=login" method="post">
	<h3><a href="login.php"><?php echo translate("Login"); ?></a></h3>
	<label><?php echo translate("Username"); ?> <input type="text" name="username" class="text"></label>
	<label><?php echo translate("Password"); ?> <input type="password" name="password" class="text"></label>
	<label><input type="checkbox" name="remember_password" value="1" id="remember_password2"> <?php echo translate("Remember my password"); ?></label>
	<input type="submit" value="<?php echo translate("Login"); ?>" class="button">
	</form>
	<?php
}
elseif (!$user->isAdminLoggedIn())
{
	$title = ($user->gender == "female") ? translate("Miss") : translate("Mister");
	?>
	<h3><a href="profile.php"><?php echo translate("Welcome"); ?>,</a></h3>
	<p><a href="profile.php"><?php echo htmlspecialchars($title . " " . $user->first_name . " " . $user->last_name); ?> (<?php echo translate("my account"); ?>)</a></p>
	<p><a href="javascript:logout(); "><?php echo translate("Logout"); ?></a></p>
	<p><a href="orders_list.php" style="font-weight: bold; "><?php echo translate("My orders"); ?></a></p>
	<?php
}
else
{
	?>
	<h3><a href="profile.php"><?php echo translate("Welcome"); ?>,</a></h3>
	<p><a href="profile.php"><?php echo htmlspecialchars($user->username); ?> (<?php echo translate("my account"); ?>)</a></p>
	<p><a href="javascript:logout(); "><?php echo translate("Logout"); ?></a></p>
	<?php
}
?>
</div>

<?php require_once(WEB_DIR . "/includes/shopping_cart_box.php"); ?>

<p><a href="https://www.github.com/huleacatalin/katyshop2" target="_blank"><img src="img/design/octocat.jpg"></a></p>
<p><a href="http://www.sourceforge.net/p/katyshop2" target="_blank"><img src="img/design/sourceforge.jpg"></a></p>
<p><a href="http://www.softpedia.com" target="_blank"><img src="img/design/softpedia.jpg"></a></p>
</div>