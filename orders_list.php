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
<h1><?php echo translate("My orders"); ?></h1>
<?php require_once(WEB_DIR . "/includes/print_messages.php"); ?>

<p>
<?php echo translate("Select by status"); ?>:
<a href="orders_list.php"><?php echo translate("All"); ?></a>
<?php
$list = Order::getPossibleStatuses();
for($i = 0; $i < count($list); $i++)
{
	if($list[$i] != "in cart")
	{
		?>
		| <a href="orders_list.php?status=<?php echo rawurlencode($list[$i]); ?>"><?php echo htmlspecialchars(translate($list[$i])); ?></a>
		<?php
	}
}
?>
</p>
<?php

$db = Application::getDb();
$user = Application::getUser();
$arr = Compat::array_clone(@$_GET);
$arr["id_user"] = $user->id;
$list = $db->tbOrder->search($arr, @$_GET["start"], @$_GET["rowsPerPage"], @$_GET["order_by"], @$_GET["order_direction"]);
$ordersCount = $db->tbOrder->getCount($arr, @$_GET["start"], @$_GET["rowsPerPage"], @$_GET["order_by"], @$_GET["order_direction"]);
if($ordersCount > 0)
{
	?>
	<form action="orders_list.php" method="get">
	<?php echo Tools::http_build_hidden_inputs($_GET, array("title")); ?>
	<label style="float: left; margin-right: 20px; "><?php echo translate("Title"); ?>: <input type="text" name="title" value="<?php echo htmlspecialchars(@$_GET["title"]); ?>" class="text"></label>
	<label style="float: left; margin-right: 20px; "><?php echo translate("Code"); ?>: <input type="text" name="code" value="<?php echo htmlspecialchars(@$_GET["code"]); ?>" class="text"></label>
	<label><?php echo translate("Status"); ?>: <input type="text" name="status" value="<?php echo htmlspecialchars(@$_GET["status"]); ?>" class="text"></label>
	<input type="submit" value="<?php echo translate("Search"); ?>" class="button">
	</form>

	<table class="cuborder" cellspacing="0" cellpadding="2">
	<tr>
	<th nowrap><?php echo pagination_columnHead(translate("ID"), "id"); ?></th>
	<th nowrap><?php echo pagination_columnHead(translate("Title"), "title"); ?></th>
	<th nowrap><?php echo pagination_columnHead(translate("Code"), "code"); ?></th>
	<th nowrap><?php echo pagination_columnHead(translate("Status"), "status"); ?></th>
	<th nowrap><?php echo pagination_columnHead(translate("Date ordered"), "date_ordered"); ?></th>
	<th nowrap><?php echo pagination_columnHead(translate("Total value"), "total"); ?></th>
	</tr>
	<?php
	for($i = 0; $i < count($list); $i++)
	{
		$o = $list[$i];
		?>
		<tr onmouseover="this.style.backgroundColor='#ddeeff'; " onmouseout="this.style.backgroundColor='#ffffff'; ">
		<td><?php echo htmlspecialchars($o->id); ?></td>
		<td onclick="redirect('order.php?id=<?php echo htmlspecialchars($o->id); ?>'); ">
			<a href="order.php?id=<?php echo htmlspecialchars($o->id); ?>"><?php echo htmlspecialchars($o->title); ?></a>
			&nbsp;
		</td>
		<td onclick="redirect('order.php?id=<?php echo htmlspecialchars($o->id); ?>'); ">
			<a href="order.php?id=<?php echo htmlspecialchars($o->id); ?>"><?php echo htmlspecialchars($o->code); ?></a>
			&nbsp;
		</td>
		<td><?php echo htmlspecialchars($o->status); ?></td>
		<td><?php echo htmlspecialchars($o->displayDateTime('date_ordered')); ?></td>
		<td align="right" style="font-weight: bold; "><?php echo htmlspecialchars(displayPrice($o->total)); ?></td>
		</tr>
		<?php
	}
	?>
	<tr>
	<td colspan="6" align="right">
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
?>

</div>
<?php require_once(WEB_DIR . "/includes/right.php"); ?>
<?php require_once(WEB_DIR . "/includes/footer.php"); ?>
</body>
</html>