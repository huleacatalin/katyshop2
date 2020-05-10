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

<h1><?php echo htmlspecialchars(translate("Terms and conditions")); ?></h1>
<?php require_once(dirname(__FILE__) . "/includes/print_messages.php"); ?>
<article>
<h2>1. Introductions</h2>

<p>Add here your introductory paragraph about terms and conditions.</p>

<h2>2. Security and confidentiality personal informations</h2>

<p>Add here your legal text about...</p>

<h2>3. Partners</h2>

<p>text here....</p>

<h2>4. Waranty</h2>

<p>text here...</p>

<h2>5. Promotions and contests</h2>

<p>text here...</p>

<h2>6. Typos</h2>

<p>text here...</p>

<h2>7. Taxes</h2>

<p>text here...</p>

<h2>8. Conflicts</h2>

<p>oh no no no...</p>

</article>
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