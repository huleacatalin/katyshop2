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
<h1><?php echo ($order->id == 0) ? 'Step 4: sending the order' : 'View order'; ?></h1>
<?php require_once(WEB_DIR . "/includes/print_messages.php"); ?>

<a href="orders_list.php">&laquo; Click here to return to the list of orders</a> <br>
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
	<p>The order is empty</p>
	<?php
}
else
{
	$order->computeValue();
	$df = new DateFormat();
	$cfgDf = Application::getConfigValue("date_format");

	if($order->id == 0)
	{
		?>
		<form action="formparser/order.php?action=finalize" method="post">
		<input type="submit" value="Send the order" class="button" style="font-weight: bold; ">
		</form>
		<br>
		<?php
	}
	else
	{
		?>
		Order code: <?php echo htmlspecialchars($order->code); ?> <a href="proforma.php?code=<?php echo htmlspecialchars($order->code); ?>" target="_blank">click here to view proforma invoice</a><br>
		<?php
	}
	?>

	Title: <big><b><?php echo $order->title; ?></b></big> <br>
	Date ordered: <?php echo htmlspecialchars($df->displayDate($cfgDf["date"], $cfgDf["separator_date"])); ?> <br>
	<?php
	if($order->id > 0)
	{
		$df->readDateTime($order->date_updated);
		?>
		Status updated date: <?php echo htmlspecialchars($df->displayDate($cfgDf["date"], $cfgDf["separator_date"])); ?> <br>
		<?php
	}
	?>
	Status: <big><b><?php echo htmlspecialchars($order->status); ?></b></big> <br>

	<h2>Order products</h2>
	<table style="text-align: right; " cellpadding="2" cellspacing="0" class="cuborder">
	<tr align="center">
	<th>No.</th>
	<th>Product</th>
	<th>M. U.</th>
	<th>Quantity</th>
	<th><nobr>Unit price<nobr><br><nobr>- <?php echo htmlspecialchars(Application::getConfigValue("default_currency")); ?> -</nobr></th>
	<th><nobr>Value<nobr><br><nobr>- <?php echo htmlspecialchars(Application::getConfigValue("default_currency")); ?> -</nobr></th>
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
		<td><?php echo htmlspecialchars($op->measuring_unit); ?>&nbsp;</td>
		<td><?php echo htmlspecialchars(displayPrice($op->quantity)); ?>&nbsp;</td>
		<td><?php echo htmlspecialchars(displayPrice($op->price)); ?></td>
		<td><?php echo htmlspecialchars(displayPrice($op->total)); ?></td>
		</tr>
		<?php
	}
	?>
	<tr align="center" style="font-weight: bold; ">
	<td colspan="4" align="right">&nbsp;</td>
	<th>TOTAL: </th>
	<td><?php echo htmlspecialchars(displayPrice($order->total)); ?></td>
	</tr>

	<?php
	if($order->id == 0)
	{
		?>
		<tr>
		<td colspan="8" align="right">
			<input type="button" value="Update products" onclick="window.open('shopping_cart.php', '_self'); " class="button">
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
	<h3><a href="shopping_cart_address.php?action=select_delivery_address">Delivery address</a></h3>
	<p><?php echo nl2br(htmlspecialchars($order->delivery_address)); ?></p>
	<input type="button" value="Change delivery address" onclick="window.open('shopping_cart_address.php?action=select_delivery_address', '_self'); " class="button">

	<h3><a href="shopping_cart_address.php?action=select_invoice_address">Invoicing address</a></h3>
	<p><?php echo nl2br(htmlspecialchars($order->invoice_address)); ?></p>
	<input type="button" value="Change invoicing address" onclick="window.open('shopping_cart_address.php?action=select_invoice_address', '_self'); " class="button">
	<?php
}
else {
	?>
	<h3>Delivery address</h3>
	<p><?php echo nl2br(htmlspecialchars($order->delivery_address)); ?></p>

	<h3>Invoicing address</h3>
	<p><?php echo nl2br(htmlspecialchars($order->invoice_address)); ?></p>
	<?php
}

if($order->id == 0)
{
	?>
	<h2>Send the order</h2>
	<form action="formparser/order.php?action=finalize" method="post">
	<p><input type="submit" value="Send the order" class="button" style="font-weight: bold; "> Click here to send the order to the shop</p>
	<p><input type="button" value="&laquo; Back" onclick="window.open('shopping_cart_address.php?action=select_invoice_address', '_self'); " class="button"> Click here to change the invoicing address</p>
	</form>
	<?php
}
?>

</div>
<?php require_once(WEB_DIR . "/includes/right.php"); ?>
<?php require_once(WEB_DIR . "/includes/footer.php"); ?>
</body>
</html>