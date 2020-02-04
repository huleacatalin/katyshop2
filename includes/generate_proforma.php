<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(dirname(__FILE__)) . "/init.php");
require_once(WEB_DIR . "/includes/req_person_company.php");

$db = Application::getDb();
$user = Application::getUser();
//$order = $db->tbOrder->getRecordByCode(@$_GET["code"]);
$order = SessionWrapper::get("generateProforma");
if(!is_a($order, "Order"))
	$order = new Order();
if($order->id == 0)
{
	die("Could not find the order to generate proforma invoice for");
}
elseif($order->id_user != $user->id)
{
	die("The selected order cannot be shown because it doesn't belong to you");
}
?>
<html>
<head>
<title><?php echo APP_NAME; ?> - proforma invoice <?php echo htmlspecialchars($order->code); ?></title>
</head>

<body>
<table width="800">
<tr valign="top">
<td width="30%">
	<?php echo nl2br(htmlspecialchars(Application::getConfigValue("shop_invoice_info"))); ?>
</td>
<td width="30%">
	<table>
	<tr>
	<td>
	Invoicing address: <br>
	<?php echo nl2br(htmlspecialchars($order->invoice_address)); ?>
	</td>
	</tr>
	<tr>
	<td style="border: 1px solid #000000; ">
	Proforma code: <?php echo htmlspecialchars($order->code); ?> <br>
	Date issued: <?php echo htmlspecialchars($order->displayDateTime("date_ordered")); ?> <br>
	</td>
	</tr>
	</table>
</td>
<td width="30%">
	Customer informations:
	<?php echo nl2br(htmlspecialchars($order->user_short_description)); ?>
</td>
</tr>
</table>
<?php
if($order->getProductsCount() > 0)
{
	$order->computeValue();
	$cfgDf = Application::getConfigValue("date_format");
	?>

	<table style="text-align: right; " cellpadding="2" cellspacing="0" border="1" width="800">
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
			<?php echo htmlspecialchars($op->product_name); ?>
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

<table width="800">
<tr>
<td width="50%">
	Delivery address: <br>
	<?php echo nl2br(htmlspecialchars($order->delivery_address)); ?>
</td>
<td width="50%">
	<?php
	$u = $db->tbUser->getUserById($order->id_user);
	$u = Factory::instantiateUser($u);
	?>
	Customer: <?php echo htmlspecialchars($u->first_name . " " . $u->last_name); ?> <br>
	Customer ID: <?php echo htmlspecialchars($u->id); ?> <br>
	Proforma code: <?php echo htmlspecialchars($order->code); ?> <br>
	Total to pay: <?php echo htmlspecialchars($order->total); ?>
</td>
</tr>
</table>
</body>
</html>