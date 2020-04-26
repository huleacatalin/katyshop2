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
$db = Application::getDb();
$addressesCount = $db->tbAddress->getCount(array("id_user" => $user->id));
?>
<html>
<head>
<title><?php echo APP_NAME; ?></title>
<?php require_once(WEB_DIR . "/includes/html_head.php"); ?>
</head>

<body>
<?php require_once(WEB_DIR . "/includes/header.php"); ?>
<?php require_once(WEB_DIR . "/includes/left.php"); ?>
<main>

<form action="formparser/user.php?action=profile" method="post">

<h1><?php echo translate("Profile"); ?></h1>

<?php
require_once(WEB_DIR . "/includes/print_messages.php");

if($user->isCompanyLoggedIn() || $user->isPersonLoggedIn())
{
	if($addressesCount == 0)
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
		<label><?php echo translate("New password"); ?>: <input type="password" name="password" minlength="5" maxlength="255" class="text"></label>
		<label><?php echo translate("Confirm password"); ?>: <input type="password" name="confirm_password" minlength="5" maxlength="255" class="text"></label>
		<input type="submit" value="<?php echo translate("Change the password"); ?>" class="button">
		</p>
	</li>
	<li><?php echo translate("Email"); ?>: <span class="value"><?php echo htmlspecialchars(@$updateUser->email2); ?></span></li>
	<li><?php echo translate("Account type"); ?>: <span class="value"><?php echo ucfirst(@$updateUser->acc_type); ?></span></li>
	<li><?php echo translate("Registered date"); ?>: <span class="value"><time datetime="<?php echo htmlspecialchars($updateUser->date_registered); ?>"><?php echo @$updateUser->displayDateTime('date_registered'); ?></time></span></li>
</div>

<div id="div_person" style="display: none; width: 350px; float: left; ">
	<h2><?php echo translate("Personal info"); ?></h2>
	<p><?php echo translate("Gender"); ?>:
		<?php
		$chkFemale = (@$updateUser->gender == "female") ? "checked" : "";
		$chkMale = (@$updateUser->gender == "male") ? "checked" : "";
		?>
		<label style="display: inline; "><input type="radio" name="gender" value="female" required <?php echo $chkFemale; ?>> <?php echo translate("Miss"); ?></label>
		<label style="display: inline; "><input type="radio" name="gender" value="male" <?php echo $chkMale; ?>> <?php echo translate("Mister"); ?></label>
	</p>
	<label><?php echo translate("First name"); ?>: <input type="text" name="first_name" required minlength="3" maxlength="20" value="<?php echo htmlspecialchars(@$updateUser->first_name); ?>" class="text"></label>
	<label><?php echo translate("Last name"); ?>: <input type="text" name="last_name" required minlength="3" maxlength="20" value="<?php echo htmlspecialchars(@$updateUser->last_name); ?>" class="text"></label>
	<label><?php echo translate("Birth date"); ?>: <input type="date" name="birth_date" value="<?php echo htmlspecialchars(@$updateUser->birth_date); ?>" class="text"></label>
	<label><?php echo translate("Phone"); ?>: <input type="tel" name="phone" maxlength="20" value="<?php echo htmlspecialchars(@$updateUser->phone); ?>" class="text"></label>
</div>

<br clear="all">

<div id="div_company" style="display: none; ">
	<h2><?php echo translate("Company info"); ?></h2>
	<label><?php echo translate("Company name"); ?>: <input type="text" id="company_name" name="company_name" maxlength="177" value="<?php echo htmlspecialchars(@$updateUser->company_name); ?>" class="text"></label>
	<label><?php echo translate("Tax code"); ?>: <input type="text" name="tax_code" maxlength="177" value="<?php echo htmlspecialchars(@$updateUser->tax_code); ?>" class="text"></label>
	<label><?php echo translate("Bank"); ?>: <input type="text" name="bank" maxlength="177" value="<?php echo htmlspecialchars(@$updateUser->bank); ?>" class="text"></label>
	<label><?php echo translate("IBAN"); ?>: <input type="text" name="iban" maxlength="177" value="<?php echo htmlspecialchars(@$updateUser->iban); ?>" class="text"></label>
	<label><?php echo translate("Phone"); ?>: <input type="tel" name="comp_phone" maxlength="177" value="<?php echo htmlspecialchars(@$updateUser->comp_phone); ?>" class="text"></label>
	<label><?php echo translate("Fax"); ?>: <input type="tel" name="comp_fax" maxlength="177" value="<?php echo htmlspecialchars(@$updateUser->comp_fax); ?>" class="text"></label>
	<label><?php echo translate("Email"); ?>: <input type="email" name="comp_email" maxlength="177" value="<?php echo htmlspecialchars(@$updateUser->comp_email); ?>" class="text"></label>
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

</main>
<?php require_once(WEB_DIR . "/includes/right.php"); ?>
<?php require_once(WEB_DIR . "/includes/footer.php"); ?>
</body>
</html>