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
<!--  Free CSS Templates from www.templatemo.com -->
<div id="templatemo_container">
<?php require_once(dirname(__FILE__) . "/includes/header.php"); ?>
    <div id="templatemo_content">
<?php require_once(dirname(__FILE__) . "/includes/left.php"); ?>
        <div id="templatemo_content_right">
<main>

<form action="formparser/user.php?action=register" method="post">

<h1><?php echo htmlspecialchars(translate("New account registration")); ?></h1>

<?php require_once(dirname(__FILE__) . "/includes/print_messages.php"); ?>

<div style="width: 250px; float: left; margin-right: 5em;">
<h2><?php echo htmlspecialchars(translate("Login info")); ?></h2>
<label><span style="color:red">*</span> <?php echo htmlspecialchars(translate("Username")); ?>: <input type="text" name="username" minlength="5" maxlength="20" value="<?php echo htmlspecialchars(@$registerUser->username); ?>" required class="text"></label>
<label><span style="color:red">*</span> <?php echo htmlspecialchars(translate("Password")); ?>: <input type="password" name="password" required minlength="5" maxlength="255" class="text"></label>
<label><span style="color:red">*</span> <?php echo htmlspecialchars(translate("Confirm password")); ?>: <input type="password" name="confirm_password" required minlength="5" maxlength="255" class="text"></label>
<label><span style="color:red">*</span> <?php echo htmlspecialchars(translate("Email")); ?>: <input type="email" name="email" value="<?php echo htmlspecialchars(@$registerUser->email2); ?>" required maxlength="255" class="text"></label>
<p><span style="color:red">*</span> <?php echo htmlspecialchars(translate("Account type")); ?>: 
	<?php
	$chkPerson = (in_array(@$registerUser->acc_type, array("person", ""))) ? "checked" : "";
	$chkCompany = (@$registerUser->acc_type == "company") ? "checked" : "";
	?>
	<label style="display: inline; "><input type="radio" name="acc_type" value="person" onclick="hideCompanyForm(); " required <?php echo $chkPerson; ?>> <?php echo htmlspecialchars(translate("Person")); ?></label>
	<label style="display: inline; "><input type="radio" name="acc_type" value="company" onclick="showCompanyForm(); " <?php echo $chkCompany; ?>> <?php echo htmlspecialchars(translate("Company")); ?></label>
</p>
</div>

<div style="width: 250px; float: left; ">
<h2><?php echo htmlspecialchars(translate("Personal info")); ?></h2>
<p><span style="color:red">*</span> <?php echo htmlspecialchars(translate("Gender")); ?>:
	<?php
	$chkFemale = (@$registerUser->gender == "female") ? "checked" : "";
	$chkMale = (@$registerUser->gender == "female") ? "" : "checked";
	?>
	<label style="display: inline; "><input type="radio" name="gender" value="female" required <?php echo $chkFemale; ?>> <?php echo htmlspecialchars(translate("Miss")); ?></label>
	<label style="display: inline; "><input type="radio" name="gender" value="male" <?php echo $chkMale; ?>> <?php echo htmlspecialchars(translate("Mister")); ?></label>
</p>

<label><span style="color:red">*</span> <?php echo htmlspecialchars(translate("First name")); ?>: <input type="text" name="first_name" required minlength="3" maxlength="20" value="<?php echo htmlspecialchars(@$registerUser->first_name); ?>" class="text"></label>
<label><span style="color:red">*</span> <?php echo htmlspecialchars(translate("Last name")); ?>: <input type="text" name="last_name" required minlength="3" maxlength="20" value="<?php echo htmlspecialchars(@$registerUser->last_name); ?>" class="text"></label>
<label><?php echo htmlspecialchars(translate("Birth date")); ?>: <input type="date" name="birth_date" value="<?php echo htmlspecialchars(@$registerUser->displayDate("birth_date")); ?>" class="text"></label>
<label><?php echo htmlspecialchars(translate("Phone")); ?>: <input type="tel" name="phone" maxlength="20" value="<?php echo htmlspecialchars(@$registerUser->phone); ?>" class="text"></label>
</div>

<br clear="all">

<div id="div_company" style="display: none; ">
	<h2><?php echo htmlspecialchars(translate("Company info")); ?></h2>
	<label><span style="color:red">*</span> <?php echo htmlspecialchars(translate("Company name")); ?>: <input type="text" id="company_name" name="company_name" maxlength="177" value="<?php echo htmlspecialchars(@$registerUser->company_name); ?>" class="text"></label>
	<label><?php echo htmlspecialchars(translate("Tax code")); ?>: <input type="text" name="tax_code" maxlength="177" value="<?php echo htmlspecialchars(@$registerUser->tax_code); ?>" class="text"></label>
	<label><?php echo htmlspecialchars(translate("Bank")); ?>: <input type="text" name="bank" maxlength="177" value="<?php echo htmlspecialchars(@$registerUser->bank); ?>" class="text"></label>
	<label><?php echo htmlspecialchars(translate("IBAN")); ?>: <input type="text" name="iban" maxlength="177" value="<?php echo htmlspecialchars(@$registerUser->iban); ?>" class="text"></label>
	<label><?php echo htmlspecialchars(translate("Phone")); ?>: <input type="tel" name="comp_phone" maxlength="177" value="<?php echo htmlspecialchars(@$registerUser->comp_phone); ?>" class="text"></label>
	<label><?php echo htmlspecialchars(translate("Fax")); ?>: <input type="tel" name="comp_fax" maxlength="177" value="<?php echo htmlspecialchars(@$registerUser->comp_fax); ?>" class="text"></label>
	<label><?php echo htmlspecialchars(translate("Email")); ?>: <input type="email" name="comp_email" maxlength="177" value="<?php echo htmlspecialchars(@$registerUser->comp_email); ?>" class="text"></label>
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
<input type="submit" value="<?php echo htmlspecialchars(translate("Register")); ?>" class="button">
</form>

</main>
            <div class="cleaner_with_height">&nbsp;</div>
        </div> <!-- end of content right -->
<?php /* require_once(dirname(__FILE__) . "/includes/right.php"); */ ?>

    	<div class="cleaner_with_height">&nbsp;</div>
    </div> <!-- end of content -->
    
<?php require_once(dirname(__FILE__) . "/includes/footer.php"); ?>
<!--  Free CSS Template www.templatemo.com -->
</div> <!-- end of container -->
<!-- templatemo 086 book store -->
<!-- 
Book Store Template 
http://www.templatemo.com/preview/templatemo_086_book_store 
-->
</body>
</html>