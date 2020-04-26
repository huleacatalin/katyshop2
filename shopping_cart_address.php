<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(__FILE__) . "/init.php");
require_once(WEB_DIR . "/includes/req_person_company.php");

$db = Application::getDb();
$user = Application::getUser();
$pageTitle = "";
$noAddressText = "";
$addresses = array();
if(@$_GET["action"] == "select_delivery_address")
{
	$pageTitle = translate("Select delivery address");
	$noAddressText = "delivery";
	$addresses = $db->tbAddress->getRecordsByUserId($user->id, "delivery");
}
elseif(@$_GET["action"] == "select_invoice_address")
{
	$pageTitle = translate("Select invoicing address");
	$noAddressText = "invoicing";
	$addresses = $db->tbAddress->getRecordsByUserId($user->id, "invoicing");
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
<h1><?php echo translate("Step"); ?> <?php echo (@$_GET['action'] == 'select_delivery_address') ? 2 : 3; ?></h1>
<?php require_once(WEB_DIR . "/includes/print_messages.php"); ?>

<h2><?php echo $pageTitle; ?>:</h2>
<?php

if(count($addresses) > 0)
{
	?>
	<form action="formparser/order.php?action=<?php echo htmlspecialchars(@$_GET["action"]); ?>" method="post" id="frm_select_address">
	<input type="hidden" name="id_address" value="0">
	</form>
	<?php
	for($i = 0; $i < count($addresses); $i++)
	{
		$a = $addresses[$i];
		?>
		<table>
		<tr valign="top">
		<td>
			<input type="checkbox" <?php echo ($a->primary_addr == 1) ? "checked" : ""; ?> disabled> <?php echo translate("Primary address"); ?><br>
			<input type="checkbox" <?php echo ($a->delivery == 1) ? "checked" : ""; ?> disabled> <?php echo translate("Delivery"); ?><br>
			<input type="checkbox" <?php echo ($a->invoicing == 1) ? "checked" : ""; ?> disabled> <?php echo translate("Invoicing"); ?><br>

			<form action="formparser/order.php?action=<?php echo htmlspecialchars(@$_GET["action"]); ?>" method="post">
			<input type="hidden" name="id_address" value="<?php echo intval($a->id); ?>">
			<input type="submit" value="<?php echo translate("Select"); ?>" class="button">
			</form>
		</td>
		<td>
			<a href="javascript:selectOrderAddress('<?php echo $a->id; ?>'); "><?php echo translate("County"); ?> <?php echo $a->county; ?><br>
			<?php echo translate("City"); ?> <?php echo $a->city; ?><br>
			<?php echo $a->address; ?></a>
		</td>
		</tr>
		</table>
		<?php
	}
	if(@$_GET["action"] == "select_delivery_address")
	{
		?>
		<input type="button" value="&laquo; <?php echo translate("Back"); ?>" onclick="window.open('shopping_cart.php', '_self'); " class="button">
		<?php
	}
	elseif (@$_GET["action"] == "select_invoice_address")
	{
		?>
		<input type="button" value="&laquo; <?php echo translate("Back"); ?>" onclick="window.open('shopping_cart_address.php?action=select_delivery_address', '_self'); " class="button">
		<?php
	}
}
else
{
	if($noAddressText == 'delivery') {
		?>
		<form action="formparser/order.php?action=no_address_found" method="post">
		<input type="hidden" name="address_type" value="delivery">
		<p>
		<?php echo translate("No delivery address could be found."); ?>
		<input type="submit" value="<?php echo translate("Click here"); ?>">
		<?php echo translate("to add a new delivery address in your address book."); ?>
		</p>
		</form>
		<?php
	}
	elseif($noAddressText == 'invoicing') {
		?>
		<form action="formparser/order.php?action=no_address_found" method="post">
		<input type="hidden" name="address_type" value="invoice">
		<p>
		<?php echo translate("No invoicing address could be found."); ?>
		<input type="submit" value="<?php echo translate("Click here"); ?>">
		<?php echo translate("to add a new invoicing address in your address book."); ?>
		</p>
		</form>
		<?php
	}
}
?>

</main>
<?php require_once(WEB_DIR . "/includes/right.php"); ?>
<?php require_once(WEB_DIR . "/includes/footer.php"); ?>
</body>
</html>