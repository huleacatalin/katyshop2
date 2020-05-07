<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(__FILE__) . "/init.php");
require_once(dirname(__FILE__) . "/includes/req_admin.php");
?>
<html>
<head>
<title><?php echo htmlspecialchars(APP_NAME); ?></title>
<?php require_once(dirname(__FILE__) . "/includes/html_head.php"); ?>
</head>

<body>
<?php require_once(dirname(__FILE__) . "/includes/header.php"); ?>
<?php require_once(dirname(__FILE__) . "/includes/left.php"); ?>
<main>
<h1><?php echo htmlspecialchars(translate("View users addresses")); ?></h1>
<?php require_once(dirname(__FILE__) . "/includes/print_messages.php"); ?>

<?php
// show list of addresses
$db = Application::getDb();
$u = $db->tbUser->getUserById(@$_GET["id_user"]);
$u = Factory::instantiateUser($u);
?>
<h2><a href="admin/user.php?action=detail&id=<?php echo intval($u->id); ?>"><?php echo htmlspecialchars($u->username); ?></a>
(<?php echo htmlspecialchars(@$u->first_name . " " . @$u->last_name); ?>)</h2>
<?php
$list = $db->tbAddress->getRecordsByUserId(@$_GET["id_user"], @$_GET["condition"]);
if(count($list) > 0)
{
	?>
	<?php
	for($i = 0; $i < count($list); $i++)
	{
		$a = $list[$i];
		?>
		<table style="border-bottom: 1px solid #000000; width: 375px; ">
		<tr valign="top">
		<td width="150">
			<input type="checkbox" <?php echo ($a->primary_addr == 1) ? "checked" : ""; ?> onclick="this.form.submit(); "> <?php echo htmlspecialchars(translate("Primary address")); ?><br>
			<input type="checkbox" <?php echo ($a->delivery == 1) ? "checked" : ""; ?> onclick="this.form.submit(); "> <?php echo htmlspecialchars(translate("Delivery")); ?><br>
			<input type="checkbox" <?php echo ($a->invoicing == 1) ? "checked" : ""; ?> onclick="this.form.submit(); "><?php echo htmlspecialchars(translate("Invoicing")); ?><br>
		</td>
		<td>
			<?php echo htmlspecialchars(translate("County")); ?> <?php echo htmlspecialchars($a->county); ?><br>
			<?php echo htmlspecialchars(translate("City")); ?> <?php echo htmlspecialchars($a->city); ?><br>
			<?php echo htmlspecialchars($a->address); ?>
		</td>
		</tr>
		</table>
		<?php
	}
}
else
{
	?>
	<p><?php echo htmlspecialchars(translate("No address has been found")); ?></p>
	<?php
}
?>
</main>
<?php require_once(dirname(__FILE__) . "/includes/right.php"); ?>
<?php require_once(dirname(__FILE__) . "/includes/footer.php"); ?>
</body>
</html>