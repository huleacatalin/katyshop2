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
<h2><?php echo htmlspecialchars(translate("Step")); ?> <?php echo (@$_GET['action'] == 'select_delivery_address') ? 2 : 3; ?><span class="title-bottom">&nbsp;</span></h2>
<?php require_once(dirname(__FILE__) . "/includes/print_messages.php"); ?>

<h2><?php echo htmlspecialchars($pageTitle); ?>:<span class="title-bottom">&nbsp;</span></h2>
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
			<input type="checkbox" <?php echo ($a->primary_addr == 1) ? "checked" : ""; ?> disabled> <?php echo htmlspecialchars(translate("Primary address")); ?><br>
			<input type="checkbox" <?php echo ($a->delivery == 1) ? "checked" : ""; ?> disabled> <?php echo htmlspecialchars(translate("Delivery")); ?><br>
			<input type="checkbox" <?php echo ($a->invoicing == 1) ? "checked" : ""; ?> disabled> <?php echo htmlspecialchars(translate("Invoicing")); ?><br>

			<form action="formparser/order.php?action=<?php echo htmlspecialchars(@$_GET["action"]); ?>" method="post">
			<input type="hidden" name="id_address" value="<?php echo intval($a->id); ?>">
			<input type="submit" value="<?php echo htmlspecialchars(translate("Select")); ?>" class="button">
			</form>
		</td>
		<td>
			<a href="javascript:selectOrderAddress('<?php echo intval($a->id); ?>'); "><?php echo htmlspecialchars(translate("County")); ?> <?php echo htmlspecialchars($a->county); ?><br>
			<?php echo htmlspecialchars(translate("City")); ?> <?php echo htmlspecialchars($a->city); ?><br>
			<?php echo htmlspecialchars($a->address); ?></a>
		</td>
		</tr>
		</table>
		<?php
	}
	if(@$_GET["action"] == "select_delivery_address")
	{
		?>
		<input type="button" value="&laquo; <?php echo htmlspecialchars(translate("Back")); ?>" onclick="window.open('shopping_cart.php', '_self'); " class="button">
		<?php
	}
	elseif (@$_GET["action"] == "select_invoice_address")
	{
		?>
		<input type="button" value="&laquo; <?php echo htmlspecialchars(translate("Back")); ?>" onclick="window.open('shopping_cart_address.php?action=select_delivery_address', '_self'); " class="button">
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
		<?php echo htmlspecialchars(translate("No delivery address could be found.")); ?>
		<input type="submit" value="<?php echo htmlspecialchars(translate("Click here")); ?>">
		<?php echo htmlspecialchars(translate("to add a new delivery address in your address book.")); ?>
		</p>
		</form>
		<?php
	}
	elseif($noAddressText == 'invoicing') {
		?>
		<form action="formparser/order.php?action=no_address_found" method="post">
		<input type="hidden" name="address_type" value="invoice">
		<p>
		<?php echo htmlspecialchars(translate("No invoicing address could be found.")); ?>
		<input type="submit" value="<?php echo htmlspecialchars(translate("Click here")); ?>">
		<?php echo htmlspecialchars(translate("to add a new invoicing address in your address book.")); ?>
		</p>
		</form>
		<?php
	}
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