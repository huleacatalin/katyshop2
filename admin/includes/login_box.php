<?php

function template_include_login_box() {
	// local variables scope so they don't conflict with the global ones
	$user = Visitor::getInstance();
	?>
	<div id="login_form">
		<h3><a href="profile.php"><?php echo htmlspecialchars(translate("Welcome")); ?>,</a></h3>
		<p><a href="profile.php"><?php echo htmlspecialchars($user->username); ?> (<?php echo htmlspecialchars(translate("my account")); ?>)</a></p>
		<p><a href="javascript:logout(); "><?php echo htmlspecialchars(translate("Logout")); ?></a></p>
	</div>
	<?php
}
template_include_login_box();
?>