<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(__FILE__) . "/init.php");
require_once(WEB_DIR . "/includes/req_person_company.php");
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
<h1>Step <?php echo (@$_GET['action'] == 'select_delivery_address') ? 2 : 3; ?></h1>
<?php require_once(WEB_DIR . "/includes/print_messages.php"); ?>

<?php
$db = Application::getDb();
$user = Application::getUser();
$pageTitle = "";
$noAddressText = "";
$list = array();
if(@$_GET["action"] == "select_delivery_address")
{
	$pageTitle = "Select delivery address";
	$noAddressText = "delivery";
	$list = $db->tbAddress->getRecordsByUserId($user->id, "delivery");
}
elseif(@$_GET["action"] == "select_invoice_address")
{
	$pageTitle = "Select invoicing address";
	$noAddressText = "invoicing";
	$list = $db->tbAddress->getRecordsByUserId($user->id, "invoicing");
}
?>
<h2><?php echo $pageTitle; ?>:</h2>
<?php

if(count($list) > 0)
{
	?>
	<form action="formparser/order.php?action=<?php echo htmlspecialchars(@$_GET["action"]); ?>" method="post" id="frm_select_address">
	<input type="hidden" name="id_address" value="0">
	</form>
	<?php
	for($i = 0; $i < count($list); $i++)
	{
		$a = $list[$i];
		?>
		<table>
		<tr valign="top">
		<td>
			<input type="checkbox" <?php echo ($a->primary_addr == 1) ? "checked" : ""; ?> disabled> Primary address<br>
			<input type="checkbox" <?php echo ($a->delivery == 1) ? "checked" : ""; ?> disabled> Delivery<br>
			<input type="checkbox" <?php echo ($a->invoicing == 1) ? "checked" : ""; ?> disabled> Invoicing<br>

			<form action="formparser/order.php?action=<?php echo htmlspecialchars(@$_GET["action"]); ?>" method="post">
			<input type="hidden" name="id_address" value="<?php echo intval($a->id); ?>">
			<input type="submit" value="Select" class="button">
			</form>
		</td>
		<td>
			<a href="javascript:selectOrderAddress('<?php echo $a->id; ?>'); ">County <?php echo $a->county; ?><br>
			City <?php echo $a->city; ?><br>
			<?php echo $a->address; ?></a>
		</td>
		</tr>
		</table>
		<?php
	}
	if(@$_GET["action"] == "select_delivery_address")
	{
		?>
		<input type="button" value="&laquo; Back" onclick="window.open('shopping_cart.php', '_self'); " class="button">
		<?php
	}
	elseif (@$_GET["action"] == "select_invoice_address")
	{
		?>
		<input type="button" value="&laquo; Back" onclick="window.open('shopping_cart_address.php?action=select_delivery_address', '_self'); " class="button">
		<?php
	}
}
else
{
	?>
	<p>
	No <?php echo $noAddressText; ?> address could be found.
	<a href="address.php?detail=true&id=0">Click here</a>
	to add a new <?php echo $noAddressText; ?> address in your address book.
	</p>
	<?php
}
?>

</div>
<?php require_once(WEB_DIR . "/includes/right.php"); ?>
<?php require_once(WEB_DIR . "/includes/footer.php"); ?>
</body>
</html>