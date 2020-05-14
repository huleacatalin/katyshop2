<?php

function template_include_login_box() {
	// local variables scope so they don't conflict with the global ones
	$user = Visitor::getInstance();
	?>
	<div id="login_form">
		<ul>
			<li class="widget products-box">
	<?php
	if(!$user->isUserLoggedIn())
	{
		?>
				<form action="formparser/user.php?action=login" method="post">
					<h2><a href="login.php"><?php echo htmlspecialchars(translate("Login")); ?></a></h2>
					<label><?php echo htmlspecialchars(translate("Username")); ?> <input type="text" name="username" required class="text" style="width: 173px; "></label>
					<label><?php echo htmlspecialchars(translate("Password")); ?> <input type="password" name="password" required class="text" style="width: 173px; "></label>
					<label><input type="checkbox" name="remember_password" value="1" id="remember_password2"> <?php echo htmlspecialchars(translate("Remember my password")); ?></label>
					<input type="submit" value="<?php echo htmlspecialchars(translate("Login")); ?>" class="button">
				</form>
				<div class="cl"></div>
				<a href="register.php" style="font-weight: bold; font-size: 1.2em; display: block; color: #7af502; margin-top: 1em; "><?php echo htmlspecialchars(translate("Register new account")); ?></a>
		<?php
	}
	elseif (!$user->isAdminLoggedIn())
	{
		$title = ($user->gender == "female") ? translate("Miss") : translate("Mister");
		?>
		<h2><a href="profile.php"><?php echo htmlspecialchars(translate("Welcome")); ?>,</a></h2>
		<p><a href="profile.php"><?php echo htmlspecialchars($title . " " . $user->first_name . " " . $user->last_name); ?> (<?php echo htmlspecialchars(translate("my account")); ?>)</a></p>
		<p><a href="orders_list.php" style="font-weight: bold; "><?php echo htmlspecialchars(translate("My orders")); ?></a></p>
		<p><a href="javascript:logout(); "><?php echo htmlspecialchars(translate("Logout")); ?></a></p>
		<?php
	}
	else
	{
		?>
		<h2><a href="profile.php"><?php echo htmlspecialchars(translate("Welcome")); ?>,</a></h2>
		<p><a href="profile.php"><?php echo htmlspecialchars($user->username); ?> (<?php echo htmlspecialchars(translate("my account")); ?>)</a></p>
		<p><a href="javascript:logout(); "><?php echo htmlspecialchars(translate("Logout")); ?></a></p>
		<?php
	}
	?>
			</li>
		</ul>
	</div>
	<?php
}
template_include_login_box();
?>