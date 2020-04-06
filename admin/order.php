<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(dirname(__FILE__)) . "/init.php");
require_once(WEB_DIR . "/includes/req_admin.php");
?>
<html>
<head>
<title><?php echo APP_NAME; ?></title>
<?php require_once(WEB_DIR . "/includes/html_head.php"); ?>
</head>

<body>
<?php require_once(WEB_DIR . "/includes/header.php"); ?>

<?php require_once(WEB_DIR . "/admin/includes/left.php"); ?>
<div id="content">
<h1><?php echo translate("Orders admin"); ?></h1>
<?php require_once(WEB_DIR . "/includes/print_messages.php"); ?>

<?php
if(@$_GET["action"] == "detail")
{
	?>
	<a href="admin/order.php">&laquo; <?php echo translate("Click here to return to the list of orders"); ?></a> <br>
	<?php
	$db = Application::getDb();
	$order = $db->tbOrder->getRecordById(@$_GET["id"]);

	if($order->getProductsCount() == 0)
	{
		?>
		<p><?php echo translate("Order is empty"); ?></p>
		<?php
	}
	else
	{
		$order->computeValue();
		?>
		<?php echo translate("Order code"); ?>: <?php echo htmlspecialchars($order->code); ?> <a href="admin/proforma.php?code=<?php echo htmlspecialchars($order->code); ?>" target="_blank"><?php echo translate("click here to see proforma invoice"); ?></a> <br>
		<?php echo translate("Title"); ?>: <big><b><?php echo $order->title; ?></b></big> <br>
		<?php echo translate("Date sent"); ?>: <?php echo htmlspecialchars($order->displayDateTime("date_ordered")); ?> <br>
		<?php echo translate("Date updated"); ?>: <?php echo htmlspecialchars($order->displayDateTime("date_updated")); ?> <br>
		<?php echo translate("Status"); ?>: <big><b><?php echo htmlspecialchars($order->status); ?></b></big> <a href="javascript:showHide('change_status_container'); "><?php echo translate("click here to change status"); ?></a> <br>
		<form action="admin/formparser/order.php?action=change_status" method="post" id="change_status_container" style="display: none; ">
		<input type="hidden" name="id_order" value="<?php echo htmlspecialchars($order->id); ?>">
		<select name="status" class="select">
		<option value="">-- <?php echo translate("Choose"); ?> --</option>
		<?php
		$list = Order::getPossibleStatuses();
		for($i = 0; $i < count($list); $i++)
		{
			if($list[$i] == "in cart")
				continue;
			$selected = ($list[$i] == $order->status) ? "selected" : "";
			?>
			<option value="<?php echo htmlspecialchars($list[$i]); ?>" <?php echo $selected; ?>><?php echo htmlspecialchars($list[$i]); ?></option>
			<?php
		}
		?>
		</select>
		<input type="submit" value="Change" class="button">
		</form>

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

		</table>
		<?php
	}
	?>

	<div>
	<p><?php echo translate("Warning! Delivery address, invoicing address and users details have been registered at the moment when he sent the order. It is possible that in the mean time he changed his addresses or his users details using the profile page."); ?></p>

	<p><?php echo translate("However, even he changed his data, these are the original informations we knew about him at the moment he sent the order."); ?></p>
	</div>

	<div id="first_page">
		<h2><?php echo translate("Delivery address"); ?></h2>
		<?php echo nl2br(htmlspecialchars($order->delivery_address)); ?>

		<h2><?php echo translate("Invoicing address"); ?></h2>
		<?php echo nl2br(htmlspecialchars($order->invoice_address)); ?>
	</div>

	<h2><?php echo translate("User details"); ?></h2>
	<p><?php echo nl2br(htmlspecialchars($order->user_details)); ?></p>
	<?php
}
else
{
	?>
	<form action="admin/order.php" method="get">
	<?php echo Tools::http_build_hidden_inputs($_GET, array("title", "username")); ?>
	<label style="float: left; margin-right: 20px; "><?php echo translate("ID"); ?>: <input type="text" name="id" value="<?php echo htmlspecialchars(@$_GET["id"]); ?>" class="text"></label>
	<label style="float: left; margin-right: 20px; "><?php echo translate("Code"); ?>: <input type="text" name="code" value="<?php echo htmlspecialchars(@$_GET["code"]); ?>" class="text"></label>
	<label style="float: left; margin-right: 20px; "><?php echo translate("Title"); ?>: <input type="text" name="title" value="<?php echo htmlspecialchars(@$_GET["title"]); ?>" class="text"></label>
	<label style="float: left; margin-right: 20px; "><?php echo translate("Username"); ?>: <input type="text" name="username" value="<?php echo htmlspecialchars(@$_GET["username"]); ?>" class="text"></label>
	<label style="float: left; margin-right: 20px; "><?php echo translate("Status"); ?>: <input type="text" name="status" value="<?php echo htmlspecialchars(@$_GET["status"]); ?>" class="text"></label>
	<br>
	<input type="submit" value="Search" class="button">
	<br clear="all">
	</form>

	<h2><?php echo translate("Orders list"); ?></h2>
	<p>
	<?php echo translate("Select by status"); ?>:
	<a href="admin/order.php"><?php echo translate("All"); ?></a>
	<?php
	$list = Order::getPossibleStatuses();
	for($i = 0; $i < count($list); $i++)
	{
		if($list[$i] != "in cart")
		{
			?>
			| <a href="admin/order.php?status=<?php echo rawurlencode($list[$i]); ?>"><?php echo htmlspecialchars(translate($list[$i])); ?></a>
			<?php
		}
	}
	?>
	</p>

	<?php
	$db = Application::getDb();
	$list = $db->tbOrder->search($_GET, @$_GET["start"], @$_GET["rowsPerPage"], @$_GET["order_by"], @$_GET["order_direction"]);
	$ordersCount = $db->tbOrder->getCount($_GET, @$_GET["start"], @$_GET["rowsPerPage"], @$_GET["order_by"], @$_GET["order_direction"]);
	if($ordersCount > 0)
	{
		?>
		<table cellpadding="2" cellspacing="0" class="cuborder">
		<tr>
		<th nowrap><?php echo pagination_columnHead(translate("ID"), "id"); ?></th>
		<th nowrap><?php echo pagination_columnHead(translate("Title"), "title"); ?></th>
		<th nowrap><?php echo pagination_columnHead(translate("Code"), "code"); ?></th>
		<th nowrap><?php echo pagination_columnHead(translate("User"), "username"); ?></th>
		<th nowrap><?php echo pagination_columnHead(translate("Status"), "status"); ?></th>
		<th nowrap><?php echo pagination_columnHead(translate("Date ordered"), "date_ordered"); ?></th>
		<th nowrap><?php echo pagination_columnHead(translate("Value"), "total"); ?></th>
		</tr>
		<?php
		for($i = 0; $i < count($list); $i++)
		{
			$o = $list[$i];
			?>
			<tr onmouseover="this.style.backgroundColor='#ddeeff'; " onmouseout="this.style.backgroundColor='#ffffff'; ">
			<td><?php echo htmlspecialchars($o->id); ?></td>
			<td onclick="redirect('admin/order.php?action=detail&id=<?php echo htmlspecialchars($o->id); ?>'); ">
				<a href="admin/order.php?action=detail&id=<?php echo htmlspecialchars($o->id); ?>"><?php echo htmlspecialchars($o->title); ?></a>
				&nbsp;
			</td>
			<td onclick="redirect('admin/order.php?action=detail&id=<?php echo htmlspecialchars($o->id); ?>'); ">
				<a href="admin/order.php?action=detail&id=<?php echo htmlspecialchars($o->id); ?>"><?php echo htmlspecialchars($o->code); ?></a>
				&nbsp;
			</td>
			<td><?php echo htmlspecialchars($o->username); ?></td>
			<td><?php echo htmlspecialchars($o->status); ?></td>
			<td><?php echo htmlspecialchars($o->displayDateTime('date_ordered')); ?></td>
			<td align="right" style="font-weight: bold; "><?php echo htmlspecialchars(displayPrice($o->total)); ?></td>
			</tr>
			<?php
		}
		?>
		<tr>
		<td colspan="7" align="right">
		<?php
		echo pagination_listPages($ordersCount);
		echo pagination_rowsPerPage();
		?>
		</td>
		</tr>
		</table>
		<?php
	}
	else
	{
		?>
		<p><?php echo translate("Could not find any order for your search criteria."); ?></p>
		<?php
	}
}
?>
</div>
<?php require_once(WEB_DIR . "/includes/right.php"); ?>
<?php require_once(WEB_DIR . "/includes/footer.php"); ?>
</body>
</html>