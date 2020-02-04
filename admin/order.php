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
<h1>Orders admin</h1>
<?php require_once(WEB_DIR . "/includes/print_messages.php"); ?>

<?php
if(@$_GET["action"] == "detail")
{
	?>
	<a href="admin/order.php">&laquo; Click here to return to the list of orders</a> <br>
	<?php
	$db = Application::getDb();
	$order = $db->tbOrder->getRecordById(@$_GET["id"]);

	if($order->getProductsCount() == 0)
	{
		?>
		<p>Order is empty</p>
		<?php
	}
	else
	{
		$order->computeValue();
		$df = new DateFormat();
		$cfgDf = Application::getConfigValue("date_format");
		?>
		Order code: <?php echo htmlspecialchars($order->code); ?> <a href="admin/proforma.php?code=<?php echo htmlspecialchars($order->code); ?>" target="_blank">click here to see proforma invoice</a> <br>
		Title: <big><b><?php echo $order->title; ?></b></big> <br>
		Date sent: <?php echo htmlspecialchars($order->displayDateTime("date_ordered")); ?> <br>
		Date updated: <?php echo htmlspecialchars($order->displayDateTime("date_updated")); ?> <br>
		Status: <big><b><?php echo htmlspecialchars($order->status); ?></b></big> <a href="javascript:showHide('change_status_container'); ">click here to change status</a> <br>
		<form action="admin/formparser/order.php?action=change_status" method="post" id="change_status_container" style="display: none; ">
		<input type="hidden" name="id_order" value="<?php echo htmlspecialchars($order->id); ?>">
		<select name="status" class="select">
		<option value="">-- Choose --</option>
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

		</table>
		<?php
	}
	?>

	<div>
	<p><b>Warning!</b> Delivery address, invoicing address and users details
	have been registered at the moment when he sent the order. It is possible that in the mean time
	he changed his addresses or his users details using the profile page.</p>

	<p>However, even he changed his data, these are the original informations we knew
	about him at the moment he sent the order.</p>
	</div>

	<div id="first_page">
		<h2>Delivery address</h2>
		<?php echo nl2br(htmlspecialchars($order->delivery_address)); ?>

		<h2>Invoicing address</h2>
		<?php echo nl2br(htmlspecialchars($order->invoice_address)); ?>
	</div>

	<h2>User details</h2>
	<p><?php echo nl2br(htmlspecialchars($order->user_details)); ?></p>
	<?php
}
else
{
	?>
	<form action="admin/order.php" method="get">
	<?php echo Tools::http_build_hidden_inputs($_GET, array("title", "username")); ?>
	<label style="float: left; margin-right: 20px; ">ID: <input type="text" name="id" value="<?php echo htmlspecialchars(@$_GET["id"]); ?>" class="text"></label>
	<label style="float: left; margin-right: 20px; ">Code: <input type="text" name="code" value="<?php echo htmlspecialchars(@$_GET["code"]); ?>" class="text"></label>
	<label style="float: left; margin-right: 20px; ">Title: <input type="text" name="title" value="<?php echo htmlspecialchars(@$_GET["title"]); ?>" class="text"></label>
	<label style="float: left; margin-right: 20px; ">Username: <input type="text" name="username" value="<?php echo htmlspecialchars(@$_GET["username"]); ?>" class="text"></label>
	<label style="float: left; margin-right: 20px; ">Status: <input type="text" name="status" value="<?php echo htmlspecialchars(@$_GET["status"]); ?>" class="text"></label>
	<br>
	<input type="submit" value="Search" class="button">
	<br clear="all">
	</form>

	<h2>Orders list</h2>
	<p>
	Select by status:
	<a href="admin/order.php">All</a>
	<?php
	$list = Order::getPossibleStatuses();
	for($i = 0; $i < count($list); $i++)
	{
		if($list[$i] != "in cart")
		{
			?>
			| <a href="admin/order.php?status=<?php echo rawurlencode($list[$i]); ?>"><?php echo htmlspecialchars($list[$i]); ?></a>
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
		<th nowrap><?php echo pagination_columnHead("ID", "id"); ?></th>
		<th nowrap><?php echo pagination_columnHead("Title", "title"); ?></th>
		<th nowrap><?php echo pagination_columnHead("Code", "code"); ?></th>
		<th nowrap><?php echo pagination_columnHead("User", "username"); ?></th>
		<th nowrap><?php echo pagination_columnHead("Status", "status"); ?></th>
		<th nowrap><?php echo pagination_columnHead("Date ordered", "date_ordered"); ?></th>
		<th nowrap><?php echo pagination_columnHead("Value", "total"); ?></th>
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
		<p>Could not find any order for your search criteria.</p>
		<?php
	}
}
?>
</div>
<?php require_once(WEB_DIR . "/includes/right.php"); ?>
<?php require_once(WEB_DIR . "/includes/footer.php"); ?>
</body>
</html>