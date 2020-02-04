<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(__FILE__) . "/init.php");

$user = Application::getUser();
if(!$user->isUserLoggedIn())
	Tools::redirect("index.php");
$updateUser = SessionWrapper::get("updateUser");
if(!is_a($updateUser, "User"))
{
	$updateUser = Factory::instantiateUser($user);
}
?>
<html>
<head>
<title><?php echo APP_NAME; ?></title>
<?php require_once(WEB_DIR . "/includes/html_head.php"); ?>
</head>

<body>
<?php require_once(WEB_DIR . "/includes/header.php"); ?>
<?php require_once(WEB_DIR . "/includes/left.php"); ?>
<div id="content">

<form action="formparser/user.php?action=profile" method="post">

<h1>Profile</h1>

<?php
require_once(WEB_DIR . "/includes/print_messages.php");

$db = Application::getDb();
if($user->isCompanyLoggedIn() || $user->isPersonLoggedIn())
{
	$x = $db->tbAddress->getCount(array("id_user" => $user->id));
	if($x == 0)
	{
		?>
		<p>You have no addresses. <a href="address.php?detail=true&id=0">Click here to add a new address</a></p>
		<?php
	}
	else
	{
		?>
		<p><a href="address.php">Click here to see the list of addresses &raquo; </a></p>
		<?php
	}
}
?>
<div style="width: 350px; float: left; margin-right: 30px; ">
<h2>Login info</h2>
<p>Username: <?php echo htmlspecialchars(@$updateUser->username); ?></p>

<p id="tbl_change_password">Password: <a href="javascript:changePassword(); ">Click here to change the password</a></p>

<p id="tbl_new_password" style="display: none; ">
<label>Old password: <input type="password" name="old_password" class="text"></label>
<label>New password: <input type="password" name="password" class="text"></label>
<label>Confirm password: <input type="password" name="confirm_password" class="text"></label>
<input type="submit" value="Change the password" class="button">
</p>

<p>Email: <?php echo htmlspecialchars(@$updateUser->email2); ?></p>
<p>Account type: <?php echo ucfirst(@$updateUser->acc_type);	?></p>
</div>

<div id="div_person" style="display: none; width: 350px; float: left; ">
	<h2>Personal info</h2>
	<p>Gender:
		<?php
		$chkFemale = (@$updateUser->gender == "female") ? "checked" : "";
		$chkMale = (@$updateUser->gender == "male") ? "checked" : "";
		?>
		<label style="display: inline; "><input type="radio" name="gender" value="female" <?php echo $chkFemale; ?>> Miss</label>
		<label style="display: inline; "><input type="radio" name="gender" value="male" <?php echo $chkMale; ?>> Mister</label>
	</p>
	<label>First name: <input type="text" name="first_name" value="<?php echo htmlspecialchars(@$updateUser->first_name); ?>" class="text"></label>
	<label>Last name: <input type="text" name="last_name" value="<?php echo htmlspecialchars(@$updateUser->last_name); ?>" class="text"></label>
	<label>Birth date (mm/dd/yyyy): <input type="text" name="birth_date" value="<?php echo htmlspecialchars(@$updateUser->displayDate("birth_date")); ?>" class="text"></label>
	<label>Phone: <input type="text" name="phone" value="<?php echo htmlspecialchars(@$updateUser->phone); ?>" class="text"></label>
</div>

<br clear="all">

<div id="div_company" style="display: none; ">
	<h2>Company info</h2>
	<label>Company name: <input type="text" name="company_name" value="<?php echo htmlspecialchars(@$updateUser->company_name); ?>" class="text"></label>
	<label>Tax code: <input type="text" name="tax_code" value="<?php echo htmlspecialchars(@$updateUser->tax_code); ?>" class="text"></label>
	<label>Bank: <input type="text" name="bank" value="<?php echo htmlspecialchars(@$updateUser->bank); ?>" class="text"></label>
	<label>IBAN: <input type="text" name="iban" value="<?php echo htmlspecialchars(@$updateUser->iban); ?>" class="text"></label>
	<label>Phone: <input type="text" name="comp_phone" value="<?php echo htmlspecialchars(@$updateUser->comp_phone); ?>" class="text"></label>
	<label>Fax: <input type="text" name="comp_fax" value="<?php echo htmlspecialchars(@$updateUser->comp_fax); ?>" class="text"></label>
	<label>Email: <input type="text" name="comp_email" value="<?php echo htmlspecialchars(@$updateUser->comp_email); ?>" class="text"></label>
</div>
<?php
if(is_a($updateUser, "UserPerson"))
{
	?>
	<script language="javascript">
	showPersonForm();
	</script>
	<?php
}
if (is_a($updateUser, "UserCompany"))
{
	?>
	<script language="javascript">
	showCompanyForm();
	</script>
	<?php
}
?>
<input type="submit" value="Update" class="button">
</form>

</div>
<?php require_once(WEB_DIR . "/includes/right.php"); ?>
<?php require_once(WEB_DIR . "/includes/footer.php"); ?>
</body>
</html>