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
<h1>View users addresses</h1>
<?php require_once(WEB_DIR . "/includes/print_messages.php"); ?>

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
			<input type="checkbox" <?php echo ($a->primary_addr == 1) ? "checked" : ""; ?> onclick="this.form.submit(); "> Primary address<br>
			<input type="checkbox" <?php echo ($a->delivery == 1) ? "checked" : ""; ?> onclick="this.form.submit(); "> Delivery<br>
			<input type="checkbox" <?php echo ($a->invoicing == 1) ? "checked" : ""; ?> onclick="this.form.submit(); ">Invoicing<br>
		</td>
		<td>
			County <?php echo $a->county; ?><br>
			City <?php echo $a->city; ?><br>
			<?php echo $a->address; ?>
		</td>
		</tr>
		</table>
		<?php
	}
}
else
{
	?>
	<p>No address has been found</p>
	<?php
}
?>
</div>
<?php require_once(WEB_DIR . "/includes/right.php"); ?>
<?php require_once(WEB_DIR . "/includes/footer.php"); ?>
</body>
</html>