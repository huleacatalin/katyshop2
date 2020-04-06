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

<h1><?php echo translate("Profile"); ?></h1>

<?php
require_once(WEB_DIR . "/includes/print_messages.php");

$db = Application::getDb();
if($user->isCompanyLoggedIn() || $user->isPersonLoggedIn())
{
	$x = $db->tbAddress->getCount(array("id_user" => $user->id));
	if($x == 0)
	{
		?>
		<p><?php echo translate("You have no addresses."); ?> <a href="address.php?detail=true&id=0"><?php echo translate("Click here to add a new address"); ?></a></p>
		<?php
	}
	else
	{
		?>
		<p><a href="address.php"><?php echo translate("Click here to see the list of addresses"); ?> &raquo; </a></p>
		<?php
	}
}
?>
<div style="width: 350px; float: left; margin-right: 30px; ">
	<h2><?php echo translate("Login info"); ?></h2>
	<ul class="properties">
	<li><?php echo translate("Username"); ?>: <span class="value"><?php echo htmlspecialchars(@$updateUser->username); ?></span></li>
	<li>
		<p id="tbl_change_password"><?php echo translate("Password"); ?>: <a href="javascript:changePassword(); "><?php echo translate("Click here to change the password"); ?></a></p>

		<p id="tbl_new_password" style="display: none; ">
		<label><?php echo translate("Old password"); ?>: <input type="password" name="old_password" class="text"></label>
		<label><?php echo translate("New password"); ?>: <input type="password" name="password" class="text"></label>
		<label><?php echo translate("Confirm password"); ?>: <input type="password" name="confirm_password" class="text"></label>
		<input type="submit" value="<?php echo translate("Change the password"); ?>" class="button">
		</p>
	</li>
	<li><?php echo translate("Email"); ?>: <span class="value"><?php echo htmlspecialchars(@$updateUser->email2); ?></span></li>
	<li><?php echo translate("Account type"); ?>: <span class="value"><?php echo ucfirst(@$updateUser->acc_type); ?></span></li>
	<li><?php echo translate("Registered date"); ?>: <span class="value"><?php echo @$updateUser->displayDateTime('date_registered'); ?></span></li>
</div>

<div id="div_person" style="display: none; width: 350px; float: left; ">
	<h2><?php echo translate("Personal info"); ?></h2>
	<p><?php echo translate("Gender"); ?>:
		<?php
		$chkFemale = (@$updateUser->gender == "female") ? "checked" : "";
		$chkMale = (@$updateUser->gender == "male") ? "checked" : "";
		?>
		<label style="display: inline; "><input type="radio" name="gender" value="female" <?php echo $chkFemale; ?>> <?php echo translate("Miss"); ?></label>
		<label style="display: inline; "><input type="radio" name="gender" value="male" <?php echo $chkMale; ?>> <?php echo translate("Mister"); ?></label>
	</p>
	<label><?php echo translate("First name"); ?>: <input type="text" name="first_name" value="<?php echo htmlspecialchars(@$updateUser->first_name); ?>" class="text"></label>
	<label><?php echo translate("Last name"); ?>: <input type="text" name="last_name" value="<?php echo htmlspecialchars(@$updateUser->last_name); ?>" class="text"></label>
	<label><?php echo translate("Birth date (mm/dd/yyyy)"); ?>: <input type="text" name="birth_date" value="<?php echo htmlspecialchars(@$updateUser->displayDate("birth_date")); ?>" class="text"></label>
	<label><?php echo translate("Phone"); ?>: <input type="text" name="phone" value="<?php echo htmlspecialchars(@$updateUser->phone); ?>" class="text"></label>
</div>

<br clear="all">

<div id="div_company" style="display: none; ">
	<h2><?php echo translate("Company info"); ?></h2>
	<label><?php echo translate("Company name"); ?>: <input type="text" name="company_name" value="<?php echo htmlspecialchars(@$updateUser->company_name); ?>" class="text"></label>
	<label><?php echo translate("Tax code"); ?>: <input type="text" name="tax_code" value="<?php echo htmlspecialchars(@$updateUser->tax_code); ?>" class="text"></label>
	<label><?php echo translate("Bank"); ?>: <input type="text" name="bank" value="<?php echo htmlspecialchars(@$updateUser->bank); ?>" class="text"></label>
	<label><?php echo translate("IBAN"); ?>: <input type="text" name="iban" value="<?php echo htmlspecialchars(@$updateUser->iban); ?>" class="text"></label>
	<label><?php echo translate("Phone"); ?>: <input type="text" name="comp_phone" value="<?php echo htmlspecialchars(@$updateUser->comp_phone); ?>" class="text"></label>
	<label><?php echo translate("Fax"); ?>: <input type="text" name="comp_fax" value="<?php echo htmlspecialchars(@$updateUser->comp_fax); ?>" class="text"></label>
	<label><?php echo translate("Email"); ?>: <input type="text" name="comp_email" value="<?php echo htmlspecialchars(@$updateUser->comp_email); ?>" class="text"></label>
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
<input type="submit" value="<?php echo translate("Update"); ?>" class="button">
</form>

</div>
<?php require_once(WEB_DIR . "/includes/right.php"); ?>
<?php require_once(WEB_DIR . "/includes/footer.php"); ?>
</body>
</html>