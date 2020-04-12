<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(__FILE__) . "/init.php");

$user = Visitor::getInstance();
if($user->isAdminLoggedIn()) {
	Application::addError('Admin accounts cannot send orders');
	Tools::redirect('admin');
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
<h1><?php echo translate("Processing order: step 1"); ?></h1>
<?php require_once(WEB_DIR . "/includes/print_messages.php"); ?>

<h2><?php echo translate("Shopping cart"); ?></h2>

<?php
$basket = Application::getShoppingCart();
if($basket->getProductsCount() == 0)
{
	?>
	<p><?php echo translate("The cart is empty"); ?></p>
	<?php
}
else
{
	$basket->computeValue();
	$df = new DateFormat();
	$cfgDf = Application::getConfigValue("date_format");
	$lang_code = Application::getConfigValue("lang_code");
	if(array_key_exists($lang_code, $cfgDf))
		$cfgDf = $cfgDf[$lang_code];
	?>
	<form action="formparser/order.php?action=update_basket" method="post" id="frm_update_basket">
	<?php echo translate("Date"); ?>: <?php echo htmlspecialchars($df->displayDate($cfgDf["date"], $cfgDf["separator_date"])); ?> <br>
	<?php echo translate("Title"); ?>: <input type="text" name="title" required minlength="3" maxlength="255" value="<?php echo htmlspecialchars($basket->title); ?>" class="text">

	<table style="text-align: right; " cellpadding="2" cellspacing="0" class="cuborder">
	<tr align="center">
	<th>&nbsp;</th>
	<th><?php echo translate("No."); ?></th>
	<th><?php echo translate("Product"); ?></th>
	<th><?php echo translate("M. U."); ?></th>
	<th><?php echo translate("Quantity"); ?></th>
	<th><nobr><?php echo translate("Unit price"); ?><nobr><br><nobr>- <?php echo htmlspecialchars(Application::getConfigValue("default_currency")); ?> -</nobr></th>
	<th><nobr><?php echo translate("Value"); ?><nobr><br><nobr>- <?php echo htmlspecialchars(Application::getConfigValue("default_currency")); ?> -</nobr></th>
	</tr>
	<?php
	for($i = 0; $i < $basket->getProductsCount(); $i++)
	{
		$op = $basket->getOrderProduct($i + 1);
		?>
		<tr>
		<td><a href="javascript:removeProduct('<?php echo intval($op->line_number); ?>'); " title="remove product"><img src="img/icons/delete.png" alt="remove product"></a></td>
		<td>
			<input type="hidden" name="line_number[]" value="<?php echo htmlspecialchars($op->line_number); ?>">
			<?php echo htmlspecialchars($op->line_number); ?>
		</td>
		<td align="center">
			<input type="hidden" name="id_product[]" value="<?php echo htmlspecialchars($op->id_product); ?>">
			<a href="product.php?id_product=<?php echo htmlspecialchars($op->id_product); ?>"><?php echo htmlspecialchars($op->product_name); ?></a>
		</td>
		<td><?php echo htmlspecialchars(translate($op->measuring_unit)); ?>&nbsp;</td>
		<td><input type="number" name="quantity[]" min="0.01" step="0.01" value="<?php echo htmlspecialchars(displayPrice($op->quantity)); ?>" style="width: 50px; text-align: right; " onfocus="this.select(); "></td>
		<td><?php echo htmlspecialchars(displayPrice($op->price)); ?></td>
		<td><?php echo htmlspecialchars(displayPrice($op->total)); ?></td>
		</tr>
		<?php
	}
	?>
	<tr align="center" style="font-weight: bold; ">
	<td colspan="5" align="right"><input type="submit" value="<?php echo translate("Update"); ?>" class="button" style="font-weight: normal; "></td>
	<th><?php echo translate("TOTAL"); ?>: </th>
	<td><?php echo htmlspecialchars(displayPrice($basket->total)); ?></td>
	</tr>

	<tr>
	<td colspan="9" align="right">
		<input type="hidden" name="next_step" value="0">
		<input type="button" value="<?php echo translate("Send the order"); ?>" onclick="sendOrder(); " class="button" style="font-weight: bold; ">
	</td>
	</tr>
	</table>
	</form>
	<?php
}
?>

</main>
<?php require_once(WEB_DIR . "/includes/right.php"); ?>
<?php require_once(WEB_DIR . "/includes/footer.php"); ?>
</body>
</html>