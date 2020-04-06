<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(__FILE__) . "/init.php");

$user = Visitor::getInstance();
if($user->isAdminLoggedIn()) {
	Application::addError('Admin accounts cannot have addresses');
	Tools::redirect('profile.php');
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
<h1><?php echo translate("My addresses"); ?></h1>
<ul id="my_addresses_actions">
<li><a href="address.php"><?php echo translate("All addresses"); ?></a></li>
<li><a href="address.php?condition=primary_addr"><?php echo translate("Primary"); ?></a></li>
<li><a href="address.php?condition=delivery"><?php echo translate("Delivery"); ?></a></li>
<li><a href="address.php?condition=invoicing"><?php echo translate("Invoicing"); ?></a></li>
<li class="add_new_address"><a href="address.php?detail=true&id=0"><?php echo translate("Add new address"); ?></a></li>
</ul>
<?php require_once(WEB_DIR . "/includes/print_messages.php"); ?>
<?php
$user = Application::getUser();
$db = Application::getDb();
if(@$_GET["detail"] == "true")
{
	if(!array_key_exists("id", $_GET))
	{
		$a = SessionWrapper::get("editAddress");
		if(!is_a($a, "Address"))
			$a = new Address();
	}
	else
	{
		$a = $db->tbAddress->getRecordById(@$_GET["id"]);
	}
	?>
	<form id="frm_delete_address" action="formparser/address.php?action=delete" method="post">
	<input type="hidden" name="id" value="<?php echo intval($a->id); ?>">
	</form>

	<form action="formparser/address.php?action=save" method="post">
	<input type="hidden" name="id" value="<?php echo $a->id; ?>">
	<h2><?php echo ($a->id == 0) ? 'Add new address' : 'Edit address'; ?></h2>
	<label style="margin: 0px; "><input type="checkbox" name="primary_addr" value="1" <?php echo ($a->primary_addr == 1) ? "checked" : ""; ?>> <?php echo translate("Primary address"); ?></label>
	<label style="margin: 0px; "><input type="checkbox" name="delivery" value="1" <?php echo ($a->delivery == 1) ? "checked" : ""; ?>> <?php echo translate("Delivery"); ?></label>
	<label><input type="checkbox" name="invoicing" value="1" <?php echo ($a->invoicing == 1) ? "checked" : ""; ?>> <?php echo translate("Invoicing"); ?></label>
	<label> <?php echo translate("County"); ?>:
	<select name="county" class="select">
	<option value="">-- <?php echo translate("Please choose"); ?> --</option>
	<?php
	$list = Application::getConfigValue("counties");
	for($i = 0; $i < count($list); $i++)
	{
		$selected = ($a->county == $list[$i]) ? "selected" : "";
		?>
		<option value="<?php echo htmlspecialchars($list[$i]); ?>" <?php echo $selected; ?>><?php echo htmlspecialchars($list[$i]); ?></option>
		<?php
	}
	?>
	</select></label>

	<label><?php echo translate("City"); ?>: <input type="text" name="city" value="<?php echo htmlspecialchars($a->city); ?>" class="text"></label>
	<label><?php echo translate("Address"); ?>: <textarea name="address" style="height: 100px; "><?php echo htmlspecialchars($a->address); ?></textarea></label>

	<input type="submit" value="<?php echo translate("Save"); ?>" class="button">
	<?php
	if($a->id > 0) {
		?>
		<input type="button" value="Delete" style="color: red; " onclick="deleteAddress(); " class="button">
		<?php
	}
	?>
	</form>
	<?php
}
else
{
	// show list of addresses
	$list = $db->tbAddress->getRecordsByUserId($user->id, @$_GET["condition"]);
	if(count($list) > 0)
	{
		for($i = 0; $i < count($list); $i++)
		{
			$a = $list[$i];
			?>
			<table>
			<tr valign="top">
			<td>
				<form action="formparser/address.php?action=toggle_checkbox" method="post" style="display: inline; ">
				<input type="hidden" name="id" value="<?php echo intval($a->id); ?>">
				<input type="hidden" name="field" value="primary_addr">
				<input type="checkbox" <?php echo ($a->primary_addr == 1) ? "checked" : ""; ?> onclick="this.form.submit(); "> <?php echo translate("Primary address"); ?><br>
				</form>

				<form action="formparser/address.php?action=toggle_checkbox" method="post" style="display: inline; ">
				<input type="hidden" name="id" value="<?php echo intval($a->id); ?>">
				<input type="hidden" name="field" value="delivery">
				<input type="checkbox" <?php echo ($a->delivery == 1) ? "checked" : ""; ?> onclick="this.form.submit(); "> <?php echo translate("Delivery"); ?><br>
				</form>

				<form action="formparser/address.php?action=toggle_checkbox" method="post" style="display: inline; ">
				<input type="hidden" name="id" value="<?php echo intval($a->id); ?>">
				<input type="hidden" name="field" value="invoicing">
				<input type="checkbox" <?php echo ($a->invoicing == 1) ? "checked" : ""; ?> onclick="this.form.submit(); "> <?php echo translate("Invoicing"); ?><br>
				</form>

				<form action="formparser/address.php?action=delete" method="post" onsubmit="return confirm('<?php echo translate("Are you sure you want to delete this address?"); ?>'); ">
				<input type="hidden" name="id" value="<?php echo intval($a->id); ?>">
				<input type="submit" value="Delete" style="color: red; " class="button">
				</form>
			</td>
			<td>
				<a href="address.php?detail=true&id=<?php echo $a->id; ?>"><?php echo translate("County"); ?> <?php echo $a->county; ?></a><br>
				<a href="address.php?detail=true&id=<?php echo $a->id; ?>"><?php echo translate("City"); ?> <?php echo $a->city; ?></a><br>
				<a href="address.php?detail=true&id=<?php echo $a->id; ?>"><?php echo $a->address; ?></a>
			</td>
			</tr>
			</table>
			<?php
		}
	}
	else
	{
		?>
		<p><?php echo translate("No address has been found"); ?></p>
		<?php
	}
}
?>
</div>
<?php require_once(WEB_DIR . "/includes/right.php"); ?>
<?php require_once(WEB_DIR . "/includes/footer.php"); ?>
</body>
</html>