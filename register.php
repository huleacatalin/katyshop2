<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(__FILE__) . "/init.php");

$user = Application::getUser();
if($user->isUserLoggedIn())
	Tools::redirect("index.php");

$registerUser = SessionWrapper::get("registerUser");
if(!is_a($registerUser, "User"))
	$registerUser = new User();
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

<form action="formparser/user.php?action=register" method="post">

<h1><?php echo translate("New account registration"); ?></h1>

<?php require_once(WEB_DIR . "/includes/print_messages.php"); ?>

<div style="width: 350px; float: left; margin-right: 30px;">
<h2><?php echo translate("Login info"); ?></h2>
<label><span style="color:red">*</span> <?php echo translate("Username"); ?>: <input type="text" name="username" value="<?php echo htmlspecialchars(@$registerUser->username); ?>" class="text"></label>
<label><span style="color:red">*</span> <?php echo translate("Password"); ?>: <input type="password" name="password" class="text"></label>
<label><span style="color:red">*</span> <?php echo translate("Confirm password"); ?>: <input type="password" name="confirm_password" class="text"></label>
<label><span style="color:red">*</span> <?php echo translate("Email"); ?>: <input type="text" name="email" value="<?php echo htmlspecialchars(@$registerUser->email2); ?>" class="text"></label>
<p><span style="color:red">*</span> <?php echo translate("Account type"); ?>: 
	<?php
	$chkPerson = (in_array(@$registerUser->acc_type, array("person", ""))) ? "checked" : "";
	$chkCompany = (@$registerUser->acc_type == "company") ? "checked" : "";
	?>
	<label style="display: inline; "><input type="radio" name="acc_type" value="person" onclick="hideCompanyForm(); " <?php echo $chkPerson; ?>> <?php echo translate("Person"); ?></label>
	<label style="display: inline; "><input type="radio" name="acc_type" value="company" onclick="showCompanyForm(); " <?php echo $chkCompany; ?>> <?php echo translate("Company"); ?></label>
</p>
</div>

<div style="width: 350px; float: left; ">
<h2><?php echo translate("Personal info"); ?></h2>
<p><span style="color:red">*</span> <?php echo translate("Gender"); ?>:
	<?php
	$chkFemale = (@$registerUser->gender == "female") ? "checked" : "";
	$chkMale = (@$registerUser->gender == "female") ? "" : "checked";
	?>
	<label style="display: inline; "><input type="radio" name="gender" value="female" <?php echo $chkFemale; ?>> <?php echo translate("Miss"); ?></label>
	<label style="display: inline; "><input type="radio" name="gender" value="male" <?php echo $chkMale; ?>> <?php echo translate("Mister"); ?></label>
</p>

<label><span style="color:red">*</span> <?php echo translate("First name"); ?>: <input type="text" name="first_name" value="<?php echo htmlspecialchars(@$registerUser->first_name); ?>" class="text"></label>
<label><span style="color:red">*</span> <?php echo translate("Last name"); ?>: <input type="text" name="last_name" value="<?php echo htmlspecialchars(@$registerUser->last_name); ?>" class="text"></label>
<label><?php echo translate("Birth date (mm/dd/yyyy)"); ?>: <input type="text" name="birth_date" value="<?php echo htmlspecialchars(@$registerUser->displayDate("birth_date")); ?>" class="text"></label>
<label><?php echo translate("Phone"); ?>: <input type="text" name="phone" value="<?php echo htmlspecialchars(@$registerUser->phone); ?>" class="text"></label>
</div>

<br clear="all">

<div id="div_company" style="display: none; ">
	<h2><?php echo translate("Company info"); ?></h2>
	<label><span style="color:red">*</span> <?php echo translate("Company name"); ?>: <input type="text" name="company_name" value="<?php echo htmlspecialchars(@$registerUser->company_name); ?>" class="text"></label>
	<label><?php echo translate("Tax code"); ?>: <input type="text" name="tax_code" value="<?php echo htmlspecialchars(@$registerUser->tax_code); ?>" class="text"></label>
	<label><?php echo translate("Bank"); ?>: <input type="text" name="bank" value="<?php echo htmlspecialchars(@$registerUser->bank); ?>" class="text"></label>
	<label><?php echo translate("IBAN"); ?>: <input type="text" name="iban" value="<?php echo htmlspecialchars(@$registerUser->iban); ?>" class="text"></label>
	<label><?php echo translate("Phone"); ?>: <input type="text" name="comp_phone" value="<?php echo htmlspecialchars(@$registerUser->comp_phone); ?>" class="text"></label>
	<label><?php echo translate("Fax"); ?>: <input type="text" name="comp_fax" value="<?php echo htmlspecialchars(@$registerUser->comp_fax); ?>" class="text"></label>
	<label><?php echo translate("Email"); ?>: <input type="text" name="comp_email" value="<?php echo htmlspecialchars(@$registerUser->comp_email); ?>" class="text"></label>
</div>

<?php
if(!is_a($registerUser, "UserCompany"))
{
	?>
	<script language="javascript">
	hideCompanyForm();
	</script>
	<?php
}
elseif (is_a($registerUser, "UserCompany"))
{
	?>
	<script language="javascript">
	showCompanyForm();
	</script>
	<?php
}
?>
<input type="submit" value="<?php echo translate("Register"); ?>" class="button">
</form>

</div>
<?php require_once(WEB_DIR . "/includes/right.php"); ?>
<?php require_once(WEB_DIR . "/includes/footer.php"); ?>
</body>
</html>