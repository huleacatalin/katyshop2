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
	<h3><a href="login.php">Login</a></h3>
	<label>Username <input type="text" name="username" class="text"></label>
	<label>Password <input type="password" name="password" class="text"></label>
	<label><input type="checkbox" name="remember_password" value="1" id="remember_password2"> Remember my password</label>
	<input type="submit" value="Login" class="button">
	</form>
	<?php
}
elseif (!$user->isAdminLoggedIn())
{
	$title = ($user->gender == "female") ? "Miss" : "Mister";
	?>
	<h3><a href="profile.php">Welcome,</a></h3>
	<p><a href="profile.php"><?php echo htmlspecialchars($title . " " . $user->first_name . " " . $user->last_name); ?> (my account)</a></p>
	<p><a href="javascript:logout(); ">Logout</a></p>
	<p><a href="orders_list.php" style="font-weight: bold; ">My orders</a></p>
	<?php
}
else
{
	?>
	<h3><a href="profile.php">Welcome,</a></h3>
	<p><a href="profile.php"><?php echo htmlspecialchars($user->username); ?> (my account)</a></p>
	<p><a href="javascript:logout(); ">Logout</a></p>
	<?php
}
?>
</div>

<?php require_once(WEB_DIR . "/includes/shopping_cart_box.php"); ?>

<p><a href="http://www.github.com" target="_blank"><img src="img/design/octocat.jpg"></a></p>
<p><a href="http://www.sourceforge.net" target="_blank"><img src="img/design/sourceforge.jpg"></a></p>
<p><a href="http://www.softpedia.com" target="_blank"><img src="img/design/softpedia.jpg"></a></p>
</div>