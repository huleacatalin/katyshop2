<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(__FILE__) . "/init.php");
require_once(WEB_DIR . "/includes/req_person_company.php");

$user = Application::getUser();
$db = Application::getDb();
$counties = Application::getConfigValue("counties");

if(@$_GET["detail"] == "true")
{
	if(!array_key_exists("id", $_GET))
	{
		$address = SessionWrapper::get("editAddress");
		if(!is_a($address, "Address"))
			$address = new Address();
	}
	else
	{
		$address = $db->tbAddress->getRecordById(@$_GET["id"]);
		if($address->id_user != $user->id)
			$address = new Address();
	}
}
else {
	$addresses = $db->tbAddress->getRecordsByUserId($user->id, @$_GET["condition"]);
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
<main>
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
if(@$_GET["detail"] == "true")
{
	?>
	<form id="frm_delete_address" action="formparser/address.php?action=delete" method="post">
	<input type="hidden" name="id" value="<?php echo intval($address->id); ?>">
	</form>

	<form action="formparser/address.php?action=save" method="post">
	<input type="hidden" name="id" value="<?php echo $address->id; ?>">
	<h2><?php echo ($address->id == 0) ? 'Add new address' : 'Edit address'; ?></h2>
	<label style="margin: 0px; "><input type="checkbox" name="primary_addr" value="1" <?php echo ($address->primary_addr == 1) ? "checked" : ""; ?>> <?php echo translate("Primary address"); ?></label>
	<label style="margin: 0px; "><input type="checkbox" name="delivery" value="1" <?php echo ($address->delivery == 1) ? "checked" : ""; ?>> <?php echo translate("Delivery"); ?></label>
	<label><input type="checkbox" name="invoicing" value="1" <?php echo ($address->invoicing == 1) ? "checked" : ""; ?>> <?php echo translate("Invoicing"); ?></label>
	<label> <?php echo translate("County"); ?>:
	<select name="county" class="select" required>
	<option value="">-- <?php echo translate("Please choose"); ?> --</option>
	<?php
	for($i = 0; $i < count($counties); $i++)
	{
		$selected = ($address->county == $counties[$i]) ? "selected" : "";
		?>
		<option value="<?php echo htmlspecialchars($counties[$i]); ?>" <?php echo $selected; ?>><?php echo htmlspecialchars($counties[$i]); ?></option>
		<?php
	}
	?>
	</select></label>

	<label><?php echo translate("City"); ?>: <input type="text" name="city" value="<?php echo htmlspecialchars($address->city); ?>" required minlength="3" maxlength="177" class="text"></label>
	<label><?php echo translate("Address"); ?>: <textarea name="address" style="height: 100px; " required minlength="3" maxlength="1000"><?php echo htmlspecialchars($address->address); ?></textarea></label>

	<input type="submit" value="<?php echo translate("Save"); ?>" class="button">
	<?php
	if($address->id > 0) {
		?>
		<input type="button" value="<?php echo translate('Delete'); ?>" style="color: red; " onclick="deleteAddress(); " class="button">
		<?php
	}
	?>
	</form>
	<?php
}
else
{
	// show list of addresses
	if(count($addresses) > 0)
	{
		for($i = 0; $i < count($addresses); $i++)
		{
			$a = $addresses[$i];
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
</main>
<?php require_once(WEB_DIR . "/includes/right.php"); ?>
<?php require_once(WEB_DIR . "/includes/footer.php"); ?>
</body>
</html>