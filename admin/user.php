<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(__FILE__) . "/init.php");
require_once(dirname(__FILE__) . "/includes/req_admin.php");
?>
<html>
<head>
<title><?php echo htmlspecialchars(APP_NAME); ?></title>
<?php require_once(dirname(__FILE__) . "/includes/html_head.php"); ?>
</head>

<body>

<?php require_once(dirname(__FILE__) . "/includes/header.php"); ?>
<?php require_once(dirname(__FILE__) . "/includes/left.php"); ?>
<main>
<h1><?php echo htmlspecialchars(translate("Users admin")); ?></h1>
<?php require_once(dirname(__FILE__) . "/includes/print_messages.php"); ?>

<?php
$db = Application::getDb();
if(@$_GET["action"] == "detail")
{
	$u = $db->tbUser->getUserById(@$_GET["id"]);
	$u = Factory::instantiateUser($u);
	?>
	<h2><?php echo htmlspecialchars(@$u->username); ?></h2>
	
	<p>
	<a href="admin/address.php?id_user=<?php echo intval($u->id); ?>"><?php echo htmlspecialchars(translate("view the addresses of this user")); ?></a>
	</p>
	
	<div style="width: 350px; float: left; margin-right: 30px; ">
	<h3><?php echo htmlspecialchars(translate("Login informations")); ?></h3>
	<ul class="properties">
	<li><?php echo htmlspecialchars(translate("Username")); ?>: <span class="value"><?php echo htmlspecialchars(@$u->username); ?></span></li>
	<li><?php echo htmlspecialchars(translate("Email")); ?>: <span class="value"><?php echo htmlspecialchars(@$u->email2); ?></span></li>
	<li><?php echo htmlspecialchars(translate("Account type")); ?>: <span class="value"><?php echo htmlspecialchars(ucfirst($u->acc_type)); ?></span></li>
	<li><?php echo htmlspecialchars(translate("Registered date")); ?>: <span class="value"><time datetime="<?php echo htmlspecialchars($u->date_registered); ?>"><?php echo $u->displayDateTime('date_registered'); ?></time></span></li>
	<li><?php echo translate("Active"); ?>: <span class="value"><?php echo (@$u->active) ? "Yes" : "No"; ?></span></li>
	<li>
		<?php
		$temp = (intval(@$u->active) == 1) ? "deactivate" : "activate";
		$action = (intval(@$u->active) == 1) ? "deactivate" : "activate";
		?>
		<form action="admin/formparser/user.php?action=<?php echo $action; ?>" method="post">
		<input type="hidden" name="id" value="<?php echo intval(@$u->id); ?>">
		<input type="hidden" name="detail" value="true">
		<input type="submit" value="<?php echo htmlspecialchars(translate($temp)); ?>" class="button">
		</form>
	</li>
	<li>
		<form action="admin/formparser/user.php?action=delete" method="post" onsubmit="return confirm('<?php echo htmlspecialchars(translate("Are you sure you want to delete this user?")); ?>'); ">
		<input type="hidden" name="id" value="<?php echo intval(@$u->id); ?>">
		<input type="hidden" name="detail" value="true">
		<input type="submit" value="Delete" style="color: red; " class="button">
		</form>
	</li>
	</ul>
	</div>

	<div id="div_person" style="display: none; width: 350px; float: left; ">
	
		<h3><?php echo htmlspecialchars(translate("Personal info")); ?></h3>

		<ul class="properties">
		<li><?php echo htmlspecialchars(translate("Gender")); ?>: <span class="value"><?php echo htmlspecialchars(ucfirst(@$u->gender)); ?></span></li>
		<li><?php echo htmlspecialchars(translate("First name")); ?>: <span class="value"><?php echo htmlspecialchars(@$u->first_name); ?></span></li>
		<li><?php echo htmlspecialchars(translate("Last name")); ?>: <span class="value"><?php echo htmlspecialchars(@$u->last_name); ?></span></li>
		<li><?php echo htmlspecialchars(translate("Birth date (mm/dd/yyyy)")); ?>: <span class="value"><?php echo htmlspecialchars(@$u->displayDate("birth_date")); ?></span></li>
		<li><?php echo htmlspecialchars(translate("Phone")); ?>: <span class="value"><?php echo htmlspecialchars(@$u->phone); ?></span></li>
		</ul>
	</div>
	<br clear="all">

	<div id="div_company" style="display: none; ">
		<h3><?php echo htmlspecialchars(translate("Company info")); ?></h3>
		
		<ul class="properties">
		<li><?php echo htmlspecialchars(translate("Company name")); ?>: <span class="value"><?php echo htmlspecialchars(@$u->company_name); ?></span></li>
		<li<?php echo htmlspecialchars(translate("Tax code")); ?>: <span class="value"><?php echo htmlspecialchars(@$u->tax_code); ?></span></li>
		<li><?php echo htmlspecialchars(translate("Bank")); ?>: <span class="value"><?php echo htmlspecialchars(@$u->bank); ?></span></li>
		<li><?php echo htmlspecialchars(translate("IBAN")); ?>: <span class="value"><?php echo htmlspecialchars(@$u->iban); ?></span></li>
		<li><?php echo htmlspecialchars(translate("Company phone")); ?>: <span class="value"><?php echo htmlspecialchars(@$u->comp_phone); ?></span></li>
		<li><?php echo htmlspecialchars(translate("Company fax")); ?>: <span class="value"><?php echo htmlspecialchars(@$u->comp_fax); ?></span></li>
		<li><?php echo htmlspecialchars(translate("Company email")); ?>: <span class="value"><?php echo htmlspecialchars(@$u->comp_email); ?></span></li>
		</ul>
	</div>

	<?php
	if(!is_a($u, "UserPerson"))
	{
		?>
		<script language="javascript">
		hidePersonForm();
		</script>
		<?php
	}
	elseif (is_a($u, "UserPerson"))
	{
		?>
		<script language="javascript">
		showPersonForm();
		</script>
		<?php
	}

	if(!is_a($u, "UserCompany"))
	{
		?>
		<script language="javascript">
		hideCompanyForm();
		</script>
		<?php
	}
	elseif (is_a($u, "UserCompany"))
	{
		?>
		<script language="javascript">
		showCompanyForm();
		</script>
		<?php
	}
}
elseif (@$_GET["action"] == "create_admin")
{
	$registerAdmin = SessionWrapper::get("registerAdmin");
	if(!is_a($registerAdmin, "User"))
		$registerAdmin = new User();
	?>
	<form action="admin/formparser/user.php?action=create_admin" method="post">
	
	<h2><?php echo htmlspecialchars(translate("Create admin account")); ?></h2>

	<h3><?php echo htmlspecialchars(translate("Login info")); ?></h3>
	<label><?php echo htmlspecialchars(translate("Username")); ?>: <input type="text" name="username" required minlength="5" maxlength="255" value="<?php echo htmlspecialchars(@$registerAdmin->username); ?>" class="text"></label>
	<label><?php echo htmlspecialchars(translate("Password")); ?>: <input type="password" name="password" minlength="5" maxlength="255" required class="text"></label>
	<label><?php echo htmlspecialchars(translate("Confirm password")); ?>: <input type="password" minlength="5" maxlength="255" name="confirm_password" required class="text"></label>
	<label><?php echo htmlspecialchars(translate("Email")); ?>: <input type="email" name="email" required value="<?php echo htmlspecialchars(@$registerAdmin->email); ?>" class="text"></label>
	<input type="submit" value="<?php echo htmlspecialchars(translate("New account")); ?>" class="button">
	</form>
	<?php
}
else
{
	?>
	<p>
	<a href="admin/user.php?action=create_admin"><?php echo htmlspecialchars(translate("Create new admin account")); ?></a>
	</p>
	<?php
	// list of users
	$list = $db->tbUser->search($_GET, @$_GET["start"], @$_GET["rowsPerPage"], @$_GET["order_by"], @$_GET["order_direction"]);
	$recordsCount = $db->tbUser->getCount($_GET, @$_GET["start"], @$_GET["rowsPerPage"], @$_GET["order_by"], @$_GET["order_direction"]);
	if($recordsCount > 0)
	{
		?>
		<table cellpadding="2" cellspacing="0" class="cuborder">
		<tr>
		<th><?php echo htmlspecialchars(translate("ID")); ?></th>
		<th><?php echo htmlspecialchars(translate("username")); ?></th>
		<th><?php echo htmlspecialchars(translate("email")); ?></th>
		<th><?php echo htmlspecialchars(translate("active")); ?></th>
		<th><?php echo htmlspecialchars(translate("account type")); ?></th>
		<th><?php echo htmlspecialchars(translate("registered date")); ?></th>
		<th><?php echo htmlspecialchars(translate("action")); ?></th>
		</tr>
		<?php
		for ($i = 0; $i < count($list); $i++)
		{
			?>
			<tr>
			<td><?php echo htmlspecialchars($list[$i]->id); ?>&nbsp;</td>
			<td><a href="admin/user.php?action=detail&id=<?php echo htmlspecialchars($list[$i]->id); ?>"><?php echo htmlspecialchars($list[$i]->username); ?></a>&nbsp;</td>
			<td><a href="mailto:<?php echo htmlspecialchars($list[$i]->email2); ?>"><?php echo htmlspecialchars($list[$i]->email2); ?></a>&nbsp;</td>
			<td><?php echo ($list[$i]->active == "1") ? translate("Yes") : translate("No"); ?>&nbsp;</td>
			<td><?php echo htmlspecialchars(ucfirst($list[$i]->acc_type)); ?></td>
			<td><time datetime="<?php echo htmlspecialchars($list[$i]->date_registered); ?>"><?php echo htmlspecialchars($list[$i]->displayDateTime('date_registered')); ?></time></td>
			<td>
			<?php
			$temp = (intval($list[$i]->active) == 1) ? "deactivate" : "activate";
			$action = (intval($list[$i]->active) == 1) ? "deactivate" : "activate";
			?>
			<form action="admin/formparser/user.php?action=<?php echo $action; ?>" method="post">
			<input type="hidden" name="id" value="<?php echo intval($list[$i]->id); ?>">
			<input type="submit" value="<?php echo htmlspecialchars(translate($temp)); ?>" class="button">
			</form>
			</td>
			</tr>
			<?php
		}
		?>
		<tr>
		<td colspan="7" align="right">
		<?php echo getListPages($recordsCount); ?>
		</td>
		</tr>
		</table>
		<?php
	}
	else
	{
		?>
		<p class="box"><?php echo htmlspecialchars(translate("Could not find any users for your search criteria")); ?>.</p>
		<?php
	}
}
?>

</main>
<?php require_once(dirname(__FILE__) . "/includes/right.php"); ?>
<?php require_once(dirname(__FILE__) . "/includes/footer.php"); ?>

</body>
</html>