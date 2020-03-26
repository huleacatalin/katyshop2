<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(__FILE__) . "/init.php");
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
<h1><?php echo translate("Contact"); ?></h1>
<?php require_once(WEB_DIR . "/includes/print_messages.php"); ?>

<h2><?php echo translate("Address"); ?></h2>
<p>Our shop offers a lot of products, making sure our customers are satisfied :) Our address is:
<address>
Ty Coon<br>
New York, Freeware street 19<br>
Phone/Fax: 555-555-555
</address>
</p>

<?php
$m = SessionWrapper::get("editContactMessage");
if(!is_a($m, "ContactMessage"))
	$m = new ContactMessage();
?>

<h2><?php echo translate("Send a message"); ?></h2>
<form action="formparser/contact_message.php?action=send" method="post">
<label><?php echo translate("Name"); ?>: <input type="text" name="sender_name" value="<?php echo htmlspecialchars($m->sender_name); ?>" class="text"></label>
<label><?php echo translate("Email"); ?>: <input type="text" name="sender_email" value="<?php echo htmlspecialchars($m->sender_email); ?>" class="text"></label>
<label><?php echo translate("Subject"); ?>: <input type="text" name="subject" value="<?php echo htmlspecialchars($m->subject); ?>" class="text"></label>
<label><?php echo translate("Message"); ?>: <textarea name="message" style="height: 100px; "><?php echo htmlspecialchars($m->message); ?></textarea></label>
<input type="submit" value="<?php echo translate("Send"); ?>" class="button">
</form>

</div>
<?php require_once(WEB_DIR . "/includes/right.php"); ?>
<?php require_once(WEB_DIR . "/includes/footer.php"); ?>
</div>
</div>
</div>
</body>
</html>