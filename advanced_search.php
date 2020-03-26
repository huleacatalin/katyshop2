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
<h1><?php echo translate("Advanced search"); ?></h1>
<?php require_once(WEB_DIR . "/includes/print_messages.php"); ?>

<h2><?php echo translate("Informations about the product"); ?></h2>

<form action="search.php" method="get">
<?php echo Tools::http_build_hidden_inputs($_GET, array("keywords", "min_price", "max_price", "id_manufacturer", "only_current_category")); ?>
<label><?php echo translate("Keywords"); ?>: <input type="text" name="keywords" value="<?php echo htmlspecialchars(@$_GET["keywords"]) ?>" class="text"></label>
<label><?php echo translate("Manufacturer"); ?>: 
	<select name="id_manufacturer" class="select">
	<option value="0">-- <?php echo translate("Choose"); ?> --</option>
	<?php
	$db = Application::getDb();
	$list = $db->tbManufacturer->search(array(), 0, 500, "title");
	for($i = 0; $i < count($list); $i++)
	{
		$selected = ($list[$i]->id == @$_GET["id_manufacturer"]) ? "selected" : "";
		?>
		<option value="<?php echo htmlspecialchars($list[$i]->id); ?>" <?php echo $selected; ?>><?php echo htmlspecialchars($list[$i]->title); ?></option>
		<?php
	}
	?>
	</select>
</label>
<label><?php echo translate("Minimal price"); ?>: <input type="text" name="min_price" value="<?php echo htmlspecialchars(@$_GET["min_price"]); ?>" class="text"></label>
<label><?php echo translate("Maximum price"); ?>: <input type="text" name="max_price" value="<?php echo htmlspecialchars(@$_GET["max_price"]); ?>" class="text"></label>
<label><input type="checkbox" name="only_current_category" value="1" style="display: inline; " <?php echo (@$_GET["only_current_category"] == "1") ? "checked" : ""; ?>> <?php echo translate("Search only in current category and all subcategories"); ?></label>
<input type="submit" value="<?php echo translate("Search"); ?>!" class="button">
</form>

</div>
<?php require_once(WEB_DIR . "/includes/right.php"); ?>
<?php require_once(WEB_DIR . "/includes/footer.php"); ?>
</body>
</html>