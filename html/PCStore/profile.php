<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

?>
<html>
<head>
<title><?php echo htmlspecialchars(APP_NAME); ?></title>
<?php require_once(dirname(__FILE__) . "/includes/html_head.php"); ?>
</head>

<body>
	<!-- Begin Wrapper -->
	<div id="wrapper">
	
		<?php require_once(dirname(__FILE__) . "/includes/header.php"); ?>
		<!-- Begin Main -->
		<div id="main">
			<!-- Begin Inner -->
			<div class="inner">
				<div class="shell">
				
					<?php require_once(dirname(__FILE__) . "/includes/left.php"); ?>
					<!-- Begin Content -->
					<div id="content">
<main>

<form action="formparser/user.php?action=profile" method="post">

<h2><?php echo htmlspecialchars(translate("Profile")); ?><span class="title-bottom">&nbsp;</span></h2>

<?php
require_once(dirname(__FILE__) . "/includes/print_messages.php");

if($user->isCompanyLoggedIn() || $user->isPersonLoggedIn())
{
	if($addressesCount == 0)
	{
		?>
		<p><?php echo htmlspecialchars(translate("You have no addresses.")); ?> <a href="address.php?detail=true&id=0"><?php echo htmlspecialchars(translate("Click here to add a new address")); ?></a></p>
		<?php
	}
	else
	{
		?>
		<p><a href="address.php"><?php echo htmlspecialchars(translate("Click here to see the list of addresses")); ?> &raquo; </a></p>
		<?php
	}
}
?>
<div style="width: 250px; float: left; margin-right: 3em; overflow: hidden; ">
	<h2><?php echo htmlspecialchars(translate("Login info")); ?><span class="title-bottom">&nbsp;</span></h2>
	<ul class="properties">
	<li><?php echo htmlspecialchars(translate("Username")); ?>: <span class="value"><?php echo htmlspecialchars(@$updateUser->username); ?></span></li>
	<li>
		<p id="tbl_change_password"><?php echo htmlspecialchars(translate("Password")); ?>: <a href="javascript:changePassword(); "><?php echo htmlspecialchars(translate("Click here to change the password")); ?></a></p>

		<p id="tbl_new_password" style="display: none; ">
		<label><?php echo htmlspecialchars(translate("Old password")); ?>: <input type="password" name="old_password" class="text"></label>
		<label><?php echo htmlspecialchars(translate("New password")); ?>: <input type="password" name="password" minlength="5" maxlength="255" class="text"></label>
		<label><?php echo htmlspecialchars(translate("Confirm password")); ?>: <input type="password" name="confirm_password" minlength="5" maxlength="255" class="text"></label>
		<input type="submit" value="<?php echo htmlspecialchars(translate("Change the password")); ?>" class="button">
		</p>
	</li>
	<li><?php echo htmlspecialchars(translate("Email")); ?>: <span class="value"><?php echo htmlspecialchars(@$updateUser->email2); ?></span></li>
	<li><?php echo htmlspecialchars(translate("Account type")); ?>: <span class="value"><?php echo htmlspecialchars(ucfirst(@$updateUser->acc_type)); ?></span></li>
	<li><?php echo htmlspecialchars(translate("Registered date")); ?>: <span class="value"><time datetime="<?php echo htmlspecialchars($updateUser->date_registered); ?>"><?php echo htmlspecialchars(@$updateUser->displayDateTime('date_registered')); ?></time></span></li>
</div>

<div id="div_person" style="display: none; width: 250px; float: left; overflow: hidden; ">
	<h2><?php echo htmlspecialchars(translate("Personal info")); ?><span class="title-bottom">&nbsp;</span></h2>
	<p><?php echo htmlspecialchars(translate("Gender")); ?>:
		<?php
		$chkFemale = (@$updateUser->gender == "female") ? "checked" : "";
		$chkMale = (@$updateUser->gender == "male") ? "checked" : "";
		?>
		<label style="display: inline; "><input type="radio" name="gender" value="female" required <?php echo $chkFemale; ?>> <?php echo htmlspecialchars(translate("Miss")); ?></label>
		<label style="display: inline; "><input type="radio" name="gender" value="male" <?php echo $chkMale; ?>> <?php echo htmlspecialchars(translate("Mister")); ?></label>
	</p>
	<label><?php echo htmlspecialchars(translate("First name")); ?>: <input type="text" name="first_name" required minlength="3" maxlength="20" value="<?php echo htmlspecialchars(@$updateUser->first_name); ?>" class="text"></label>
	<label><?php echo htmlspecialchars(translate("Last name")); ?>: <input type="text" name="last_name" required minlength="3" maxlength="20" value="<?php echo htmlspecialchars(@$updateUser->last_name); ?>" class="text"></label>
	<label><?php echo htmlspecialchars(translate("Birth date")); ?>: <input type="date" name="birth_date" value="<?php echo htmlspecialchars(@$updateUser->birth_date); ?>" class="text"></label>
	<label><?php echo htmlspecialchars(translate("Phone")); ?>: <input type="tel" name="phone" maxlength="20" value="<?php echo htmlspecialchars(@$updateUser->phone); ?>" class="text"></label>
</div>

<br clear="all">

<div id="div_company" style="display: none; ">
	<h2><?php echo htmlspecialchars(translate("Company info")); ?><span class="title-bottom">&nbsp;</span></h2>
	<label><?php echo htmlspecialchars(translate("Company name")); ?>: <input type="text" id="company_name" name="company_name" maxlength="177" value="<?php echo htmlspecialchars(@$updateUser->company_name); ?>" class="text"></label>
	<label><?php echo htmlspecialchars(translate("Tax code")); ?>: <input type="text" name="tax_code" maxlength="177" value="<?php echo htmlspecialchars(@$updateUser->tax_code); ?>" class="text"></label>
	<label><?php echo htmlspecialchars(translate("Bank")); ?>: <input type="text" name="bank" maxlength="177" value="<?php echo htmlspecialchars(@$updateUser->bank); ?>" class="text"></label>
	<label><?php echo htmlspecialchars(translate("IBAN")); ?>: <input type="text" name="iban" maxlength="177" value="<?php echo htmlspecialchars(@$updateUser->iban); ?>" class="text"></label>
	<label><?php echo htmlspecialchars(translate("Phone")); ?>: <input type="tel" name="comp_phone" maxlength="177" value="<?php echo htmlspecialchars(@$updateUser->comp_phone); ?>" class="text"></label>
	<label><?php echo htmlspecialchars(translate("Fax")); ?>: <input type="tel" name="comp_fax" maxlength="177" value="<?php echo htmlspecialchars(@$updateUser->comp_fax); ?>" class="text"></label>
	<label><?php echo htmlspecialchars(translate("Email")); ?>: <input type="email" name="comp_email" maxlength="177" value="<?php echo htmlspecialchars(@$updateUser->comp_email); ?>" class="text"></label>
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
<input type="submit" value="<?php echo htmlspecialchars(translate("Update")); ?>" class="button">
</form>

</main>
					</div>
					<!-- End Content -->
					<?php require_once(dirname(__FILE__) . "/includes/right.php"); ?>
					<div class="cl">&nbsp;</div>
				</div>
			</div>
			<!-- End Inner -->
		</div>
		<!-- End Main -->
		<?php require_once(dirname(__FILE__) . "/includes/footer.php"); ?>
	</div>
	<!-- End Wrapper -->
</body>
</html>