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
<main>
<h1><?php echo translate("Messages received from visitors"); ?></h1>
<?php require_once(WEB_DIR . "/includes/print_messages.php"); ?>

<?php
if(@$_GET["action"] == "detail")
{
	$db = Application::getDb();
	$m = $db->tbContactMessage->getRecordById(@$_GET["id"]);

	if($m->id == 0)
	{
		?>
		<p><?php echo translate("Message could not be found"); ?></p>
		<?php
	}
	else
	{
		?>
		<h2><?php echo translate("View message"); ?></h2>
		<p><a href="admin/contact_message.php">&laquo; <?php echo translate("Back to the list of messages"); ?></a></p>

		<ul class="properties">
		<li><?php echo translate("Visitor name"); ?>: <span class="value"><?php echo htmlspecialchars($m->sender_name); ?></span></li>
		<li><?php echo translate("Visitor email"); ?>: <span class="value"><a href="mailto:<?php echo htmlspecialchars($m->sender_email); ?>"><?php echo htmlspecialchars($m->sender_email); ?></a></span></li>
		<li><?php echo translate("Date sent"); ?>: <span class="value"><time datetime="<?php echo htmlspecialchars($m->date_sent); ?>"><?php echo htmlspecialchars($m->displayDateTime('date_sent')); ?></time></span></li>
		<li><?php echo translate("Subject"); ?>: <span class="value"><?php echo htmlspecialchars($m->subject); ?></span></li>
		<li><?php echo translate("Message"); ?>: <span class="value" style="width: 500px; "><?php echo htmlspecialchars($m->message); ?></span></li>
		</ul>

		<div>
		<p><?php echo translate("Warning! User details have been registered at the moment when the message has been sent. It is possible that in the mean time he changed these informations using the profile form."); ?></p>

		<p><?php echo translate("However, even he changed these data, these are the original informations we knew about him at the moment he sent the message."); ?></p>
		</div>

		<h3><?php echo translate("User details"); ?></h3>
		<?php
		echo nl2br(htmlspecialchars($m->user_details));
	}
}
else
{
	?>
	<form action="admin/contact_message.php" method="get">
	<?php echo Tools::http_build_hidden_inputs($_GET, array("subject")); ?>
	<label style="float: left; margin-right: 20px; "><?php echo translate("Subject"); ?>: <input type="text" name="subject" value="<?php echo htmlspecialchars(@$_GET["subject"]); ?>" class="text"></label>
	<br>
	<input type="submit" value="<?php echo translate("Search"); ?>" class="button">
	<br clear="all">
	</form>

	<?php
	if(empty($_GET["order_by"]))
	{
		$_GET["order_by"] = "id";
		$_GET["order_by"] = "desc";
	}
	$db = Application::getDb();
	$list = $db->tbContactMessage->search($_GET, @$_GET["start"], @$_GET["rowsPerPage"], @$_GET["order_by"], @$_GET["order_direction"]);
	$messagesCount = $db->tbContactMessage->getCount($_GET, @$_GET["start"], @$_GET["rowsPerPage"], @$_GET["order_by"], @$_GET["order_direction"]);
	if($messagesCount > 0)
	{
		?>
		<table class="cuborder" cellpadding="2" cellspacing="0">
		<tr>
		<th nowrap><?php echo pagination_columnHead("ID", "id"); ?></th>
		<th nowrap><?php echo translate("Visitor"); ?></th>
		<th nowrap><?php echo translate("Email"); ?></th>
		<th nowrap><?php echo pagination_columnHead(translate("Subject"), "subject"); ?></th>
		<th nowrap><?php echo pagination_columnHead(translate("Date"), "date_sent"); ?></th>
		</tr>
		<?php
		for($i = 0; $i < count($list); $i++)
		{
			$m = $list[$i];
			?>
			<tr onmouseover="this.style.backgroundColor='#ddeeff'; " onmouseout="this.style.backgroundColor='#ffffff'; ">
			<td><?php echo htmlspecialchars($m->id); ?></td>
			<td><?php echo htmlspecialchars($m->sender_name); ?></td>
			<td><?php echo htmlspecialchars($m->sender_email); ?></td>
			<td onclick="redirect('admin/contact_message.php?action=detail&id=<?php echo htmlspecialchars($m->id); ?>'); ">
				<a href="admin/contact_message.php?action=detail&id=<?php echo htmlspecialchars($m->id); ?>"><?php echo htmlspecialchars($m->subject); ?></a>
				&nbsp;
			</td>
			<td><time datetime="<?php echo htmlspecialchars($m->date_sent); ?>"><?php echo htmlspecialchars($m->displayDateTime('date_sent')); ?></time></td>
			</tr>
			<?php
		}
		?>
		<tr>
		<td colspan="5" align="right">
		<?php
		echo pagination_listPages($messagesCount);
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
		<p><?php echo translate("No message has been found for your search criteria."); ?></p>
		<?php
	}
}
?>

</main>
<?php require_once(WEB_DIR . "/includes/right.php"); ?>
<?php require_once(WEB_DIR . "/includes/footer.php"); ?>
</body>
</html>