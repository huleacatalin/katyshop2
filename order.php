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
<?php
$db = Application::getDb();
$user = Application::getUser();
$order = $db->tbOrder->getRecordById(@$_GET["id"]);
?>
<h1><?php echo ($order->id == 0) ? translate('Step 4: sending the order') : translate('View order'); ?></h1>
<?php require_once(WEB_DIR . "/includes/print_messages.php"); ?>

<a href="orders_list.php">&laquo; <?php echo translate("Click here to return to the list of orders"); ?></a> <br>
<?php
if($order->id == 0)
{
	$order = Application::getShoppingCart();
}
elseif($order->id_user != $user->id)
{
	Application::addError("Selected order cannot be displayed because it doesn't belong to you");
	Tools::redirect("index.php");
	exit();
}

if($order->getProductsCount() == 0)
{
	?>
	<p><?php echo translate("The order is empty"); ?></p>
	<?php
}
else
{
	$order->computeValue();
	$df = new DateFormat();
	$cfgDf = Application::getConfigValue("date_format");
	$lang_code = Application::getConfigValue("lang_code");
	if(array_key_exists($lang_code, $cfgDf))
		$cfgDf = $cfgDf[$lang_code];
	
	if($order->id == 0)
	{
		?>
		<form action="formparser/order.php?action=finalize" method="post">
		<input type="submit" value="<?php echo translate("Send the order"); ?>" class="button" style="font-weight: bold; ">
		</form>
		<br>
		<?php
	}
	else
	{
		?>
		<?php echo translate("Order code"); ?>: <?php echo htmlspecialchars($order->code); ?> <a href="proforma.php?code=<?php echo htmlspecialchars($order->code); ?>" target="_blank"><?php echo translate("click here to view proforma invoice"); ?></a><br>
		<?php
	}
	?>

	<?php echo translate("Title"); ?>: <big><b><?php echo $order->title; ?></b></big> <br>
	<?php echo translate("Date ordered"); ?>: <?php echo htmlspecialchars($df->displayDate($cfgDf["date"], $cfgDf["separator_date"])); ?> <br>
	<?php
	if($order->id > 0)
	{
		$df->readDateTime($order->date_updated);
		?>
		<?php echo translate("Status updated date"); ?>: <?php echo htmlspecialchars($df->displayDate($cfgDf["date"], $cfgDf["separator_date"])); ?> <br>
		<?php
	}
	?>
	<?php echo translate("Status"); ?>: <big><b><?php echo htmlspecialchars($order->status); ?></b></big> <br>

	<h2><?php echo translate("Order products"); ?></h2>
	<table style="text-align: right; " cellpadding="2" cellspacing="0" class="cuborder">
	<tr align="center">
	<th><?php echo translate("No."); ?></th>
	<th><?php echo translate("Product"); ?></th>
	<th><?php echo translate("M. U."); ?></th>
	<th><?php echo translate("Quantity"); ?></th>
	<th><nobr><?php echo translate("Unit price"); ?><nobr><br><nobr>- <?php echo htmlspecialchars(Application::getConfigValue("default_currency")); ?> -</nobr></th>
	<th><nobr><?php echo translate("Value"); ?><nobr><br><nobr>- <?php echo htmlspecialchars(Application::getConfigValue("default_currency")); ?> -</nobr></th>
	</tr>
	<?php
	for($i = 0; $i < $order->getProductsCount(); $i++)
	{
		$op = $order->getOrderProduct($i + 1);
		?>
		<tr>
		<td>
			<?php echo htmlspecialchars($op->line_number); ?>
		</td>
		<td align="center">
			<a href="product.php?id_product=<?php echo htmlspecialchars($op->id_product); ?>"><?php echo htmlspecialchars($op->product_name); ?></a>
		</td>
		<td><?php echo htmlspecialchars(translate($op->measuring_unit)); ?>&nbsp;</td>
		<td><?php echo htmlspecialchars(displayPrice($op->quantity)); ?>&nbsp;</td>
		<td><?php echo htmlspecialchars(displayPrice($op->price)); ?></td>
		<td><?php echo htmlspecialchars(displayPrice($op->total)); ?></td>
		</tr>
		<?php
	}
	?>
	<tr align="center" style="font-weight: bold; ">
	<td colspan="4" align="right">&nbsp;</td>
	<th><?php echo translate("TOTAL"); ?>: </th>
	<td><?php echo htmlspecialchars(displayPrice($order->total)); ?></td>
	</tr>

	<?php
	if($order->id == 0)
	{
		?>
		<tr>
		<td colspan="8" align="right">
			<input type="button" value="<?php echo translate("Update products"); ?>" onclick="window.open('shopping_cart.php', '_self'); " class="button">
		</td>
		</tr>
		<?php
	}
	?>
	</table>
	<?php
}

if($order->id == 0)
{
	?>
	<h3><a href="shopping_cart_address.php?action=select_delivery_address"><?php echo translate("Delivery address"); ?></a></h3>
	<p><?php echo nl2br(htmlspecialchars($order->delivery_address)); ?></p>
	<input type="button" value="Change delivery address" onclick="window.open('shopping_cart_address.php?action=select_delivery_address', '_self'); " class="button">

	<h3><a href="shopping_cart_address.php?action=select_invoice_address"><?php echo translate("Invoicing address"); ?></a></h3>
	<p><?php echo nl2br(htmlspecialchars($order->invoice_address)); ?></p>
	<input type="button" value="<?php echo translate("Change invoicing address"); ?>" onclick="window.open('shopping_cart_address.php?action=select_invoice_address', '_self'); " class="button">
	<?php
}
else {
	?>
	<h3><?php echo translate("Delivery address"); ?></h3>
	<p><?php echo nl2br(htmlspecialchars($order->delivery_address)); ?></p>

	<h3><?php echo translate("Invoicing address"); ?></h3>
	<p><?php echo nl2br(htmlspecialchars($order->invoice_address)); ?></p>
	<?php
}

if($order->id == 0)
{
	?>
	<h2><?php echo translate("Send the order"); ?></h2>
	<form action="formparser/order.php?action=finalize" method="post">
	<p><input type="submit" value="<?php echo translate("Send the order"); ?>" class="button" style="font-weight: bold; "> <?php echo translate("Click here to send the order to the shop"); ?></p>
	<p><input type="button" value="&laquo; <?php echo translate("Back"); ?>" onclick="window.open('shopping_cart_address.php?action=select_invoice_address', '_self'); " class="button"> <?php echo translate("Click here to change the invoicing address"); ?></p>
	</form>
	<?php
}
?>

</div>
<?php require_once(WEB_DIR . "/includes/right.php"); ?>
<?php require_once(WEB_DIR . "/includes/footer.php"); ?>
</body>
</html>