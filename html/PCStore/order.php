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
<h2><?php echo ($order->id == 0) ? htmlspecialchars(translate('Step 4: sending the order')) : htmlspecialchars(translate('View order')); ?><span class="title-bottom">&nbsp;</span></h2>
<?php require_once(dirname(__FILE__) . "/includes/print_messages.php"); ?>

<a href="orders_list.php">&laquo; <?php echo htmlspecialchars(translate("Click here to return to the list of orders")); ?></a> <br>
<?php
if($order->getProductsCount() == 0)
{
	?>
	<p><?php echo htmlspecialchars(translate("The order is empty")); ?></p>
	<?php
}
else
{
	if($order->id == 0)
	{
		?>
		<form action="formparser/order.php?action=finalize" method="post">
		<input type="submit" value="<?php echo htmlspecialchars(translate("Send the order")); ?>" class="button" style="font-weight: bold; ">
		</form>
		<br>
		<?php
	}
	else
	{
		?>
		<?php echo htmlspecialchars(translate("Order code")); ?>: <?php echo htmlspecialchars($order->code); ?> <a href="proforma.php?code=<?php echo htmlspecialchars($order->code); ?>" target="_blank"><?php echo htmlspecialchars(translate("click here to view proforma invoice")); ?></a><br>
		<?php
	}
	?>

	<?php echo htmlspecialchars(translate("Title")); ?>: <big><b><?php echo htmlspecialchars($order->title); ?></b></big> <br>
	<?php echo htmlspecialchars(translate("Date ordered")); ?>: <?php echo htmlspecialchars($order->displayDateTime('date_ordered')); ?> <br>
	<?php
	if($order->id > 0)
	{
		?>
		<?php echo htmlspecialchars(translate("Status updated date")); ?>: <?php echo htmlspecialchars($order->displayDateTime('date_updated')); ?> <br>
		<?php
	}
	?>
	<?php echo htmlspecialchars(translate("Status")); ?>: <big><b><?php echo htmlspecialchars($order->status); ?></b></big> <br>

	<h2><?php echo htmlspecialchars(translate("Order products")); ?><span class="title-bottom">&nbsp;</span></h2>
	<table style="text-align: right; " cellpadding="2" cellspacing="0" class="cuborder">
	<tr align="center">
	<th><?php echo htmlspecialchars(translate("No.")); ?></th>
	<th><?php echo htmlspecialchars(translate("Product")); ?></th>
	<th><?php echo htmlspecialchars(translate("M. U.")); ?></th>
	<th><?php echo htmlspecialchars(translate("Quantity")); ?></th>
	<th><nobr><?php echo htmlspecialchars(translate("Unit price")); ?><nobr><br><nobr>- <?php echo htmlspecialchars(Application::getConfigValue("default_currency")); ?> -</nobr></th>
	<th><nobr><?php echo htmlspecialchars(translate("Value")); ?><nobr><br><nobr>- <?php echo htmlspecialchars(Application::getConfigValue("default_currency")); ?> -</nobr></th>
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
	<th><?php echo htmlspecialchars(translate("TOTAL")); ?>: </th>
	<td><?php echo htmlspecialchars(displayPrice($order->total)); ?></td>
	</tr>

	<?php
	if($order->id == 0)
	{
		?>
		<tr>
		<td colspan="8" align="right">
			<input type="button" value="<?php echo htmlspecialchars(translate("Update products")); ?>" onclick="window.open('shopping_cart.php', '_self'); " class="button">
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
	<h2><a href="shopping_cart_address.php?action=select_delivery_address"><?php echo htmlspecialchars(translate("Delivery address")); ?></a><span class="title-bottom">&nbsp;</span></h2>
	<p><?php echo nl2br(htmlspecialchars($order->delivery_address)); ?></p>
	<input type="button" value="Change delivery address" onclick="window.open('shopping_cart_address.php?action=select_delivery_address', '_self'); " class="button">

	<h2><a href="shopping_cart_address.php?action=select_invoice_address"><?php echo htmlspecialchars(translate("Invoicing address")); ?></a><span class="title-bottom">&nbsp;</span></h2>
	<p><?php echo nl2br(htmlspecialchars($order->invoice_address)); ?></p>
	<input type="button" value="<?php echo htmlspecialchars(translate("Change invoicing address")); ?>" onclick="window.open('shopping_cart_address.php?action=select_invoice_address', '_self'); " class="button">
	<?php
}
else {
	?>
	<h2><?php echo htmlspecialchars(translate("Delivery address")); ?><span class="title-bottom">&nbsp;</span></h2>
	<p><?php echo nl2br(htmlspecialchars($order->delivery_address)); ?></p>

	<h2><?php echo htmlspecialchars(translate("Invoicing address")); ?><span class="title-bottom">&nbsp;</span></h2>
	<p><?php echo nl2br(htmlspecialchars($order->invoice_address)); ?></p>
	<?php
}

if($order->id == 0)
{
	?>
	<h2><?php echo htmlspecialchars(translate("Send the order")); ?><span class="title-bottom">&nbsp;</span></h2>
	<form action="formparser/order.php?action=finalize" method="post">
	<p><input type="submit" value="<?php echo htmlspecialchars(translate("Send the order")); ?>" class="button" style="font-weight: bold; "> <?php echo htmlspecialchars(translate("Click here to send the order to the shop")); ?></p>
	<p><input type="button" value="&laquo; <?php echo htmlspecialchars(translate("Back")); ?>" onclick="window.open('shopping_cart_address.php?action=select_invoice_address', '_self'); " class="button"> <?php echo htmlspecialchars(translate("Click here to change the invoicing address")); ?></p>
	</form>
	<?php
}
?>

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