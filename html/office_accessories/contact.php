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
	<!-- Wrapper -->
	<div id="wrapper">
		<div id="wrapper-bottom">
			<div class="shell">
				<?php require_once(dirname(__FILE__) . "/includes/header.php"); ?>
				<!-- Main -->
				<div id="main">
					
						<!-- Featured Products -->
						<div class="products-holder" style="margin-left: 5px; ">
							<div class="top"></div>
							<div class="middle">
								<div class="cl"></div>

<h1><?php echo htmlspecialchars(translate("Contact")); ?></h1>
<?php require_once(dirname(__FILE__) . "/includes/print_messages.php"); ?>

<h2><?php echo htmlspecialchars(translate("Address")); ?></h2>
<p>Our shop offers a lot of products, making sure our customers are satisfied :) Our address is:
<address>
Ty Coon<br>
New York, Freeware street 19<br>
Phone/Fax: 555-555-555
</address>
</p>

<h2><?php echo htmlspecialchars(translate("Send a message")); ?></h2>
<form action="formparser/contact_message.php?action=send" method="post">
<label><?php echo htmlspecialchars(translate("Name")); ?>: <input type="text" name="sender_name" required minlength="3" maxlength="177" value="<?php echo htmlspecialchars($message->sender_name); ?>" class="text"></label>
<label><?php echo htmlspecialchars(translate("Email")); ?>: <input type="email" name="sender_email" required value="<?php echo htmlspecialchars($message->sender_email); ?>" class="text"></label>
<label><?php echo htmlspecialchars(translate("Subject")); ?>: <input type="text" name="subject" required minlength="3" maxlength="255" value="<?php echo htmlspecialchars($message->subject); ?>" class="text"></label>
<label><?php echo htmlspecialchars(translate("Message")); ?>: <textarea name="message" required minlength="3" maxlength="1000" style="height: 100px; "><?php echo htmlspecialchars($message->message); ?></textarea></label>
<input type="submit" value="<?php echo htmlspecialchars(translate("Send")); ?>" class="button">
</form>

								<div class="cl"></div>
							</div>
							<div class="bottom"></div>									
						</div>
						<!-- END Featured Products -->
						
				</div>
				<!-- END Main -->
			</div>
		</div>
		<div id="footer-push"></div>
	</div>
	<!-- END Wrapper -->
	<?php require_once(dirname(__FILE__) . "/includes/footer.php"); ?>
</body>
</html>