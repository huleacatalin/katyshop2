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
	<!-- Begin Wrapper -->
	<div id="wrapper">
	
		<?php require_once(dirname(__FILE__) . "/includes/header.php"); ?>
		<!-- Begin Main -->
		<div id="main">
			<!-- Begin Inner -->
			<div class="inner">
				<div class="shell">
				
					<?php require_once(dirname(__FILE__) . "/includes/left.php"); ?>
					<!-- Begin Content -->
					<div id="content">
						<main>
						<h2><?php echo htmlspecialchars(translate("Terms and conditions")); ?><span class="title-bottom">&nbsp;</span></h2>
						<?php require_once(dirname(__FILE__) . "/includes/print_messages.php"); ?>
						<article>
						<h2>1. Introductions</h2>

						<p>Add here your introductory paragraph about terms and conditions.</p>

						<h2>2. Security and confidentiality personal informations<span class="title-bottom">&nbsp;</span></h2>

						<p>Add here your legal text about...</p>

						<h2>3. Partners<span class="title-bottom">&nbsp;</span></h2>

						<p>text here....</p>

						<h2>4. Waranty<span class="title-bottom">&nbsp;</span></h2>

						<p>text here...</p>

						<h2>5. Promotions and contests<span class="title-bottom">&nbsp;</span></h2>

						<p>text here...</p>

						<h2>6. Typos<span class="title-bottom">&nbsp;</span></h2>

						<p>text here...</p>

						<h2>7. Taxes<span class="title-bottom">&nbsp;</span></h2>

						<p>text here...</p>

						<h2>8. Conflicts<span class="title-bottom">&nbsp;</span></h2>

						<p>oh no no no...</p>

						</article>
						</main>
					</div>
					<!-- End Content -->
					<?php require_once(dirname(__FILE__) . "/includes/right.php"); ?>
					<div class="cl">&nbsp;</div>
				</div>
			</div>
			<!-- End Inner -->
		</div>
		<!-- End Main -->
		<?php require_once(dirname(__FILE__) . "/includes/footer.php"); ?>
	</div>
	<!-- End Wrapper -->
</body>
</html>