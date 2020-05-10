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

<h1><?php echo htmlspecialchars(translate("Advanced search")); ?></h1>
<?php require_once(dirname(__FILE__) . "/includes/print_messages.php"); ?>

<h2><?php echo htmlspecialchars(translate("Informations about the product")); ?></h2>

<form action="search.php" method="get">
<?php echo Tools::http_build_hidden_inputs($_GET, array("keywords", "min_price", "max_price", "id_manufacturer", "only_current_category")); ?>
<label><?php echo htmlspecialchars(translate("Keywords")); ?>: <input type="text" name="keywords" required value="<?php echo htmlspecialchars(@$_GET["keywords"]) ?>" class="text"></label>
<label><?php echo htmlspecialchars(translate("Manufacturer")); ?>: 
	<select name="id_manufacturer" class="select">
	<option value="0">-- <?php echo htmlspecialchars(translate("Choose")); ?> --</option>
	<?php
	for($i = 0; $i < count($manufacturers); $i++)
	{
		$selected = ($manufacturers[$i]->id == @$_GET["id_manufacturer"]) ? "selected" : "";
		?>
		<option value="<?php echo htmlspecialchars($manufacturers[$i]->id); ?>" <?php echo $selected; ?>><?php echo htmlspecialchars($manufacturers[$i]->title); ?></option>
		<?php
	}
	?>
	</select>
</label>
<label><?php echo htmlspecialchars(translate("Minimal price")); ?>: <input type="number" name="min_price" min="0" step="0.01" value="<?php echo htmlspecialchars(@$_GET["min_price"]); ?>" class="text"></label>
<label><?php echo htmlspecialchars(translate("Maximum price")); ?>: <input type="number" name="max_price" min="0" step="0.01" value="<?php echo htmlspecialchars(@$_GET["max_price"]); ?>" class="text"></label>
<label><input type="checkbox" name="only_current_category" value="1" style="display: inline; " <?php echo (@$_GET["only_current_category"] == "1") ? "checked" : ""; ?>> <?php echo htmlspecialchars(translate("Search only in current category and all subcategories")); ?></label>
<input type="submit" value="<?php echo htmlspecialchars(translate("Search")); ?>!" class="button">
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