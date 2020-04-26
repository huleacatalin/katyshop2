<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(__FILE__) . "/init.php");

if(empty($_GET["order_by"]["products"]))
	$_GET["order_by"]["products"] = "pos";
if(empty($_GET["order_direction"]["products"]))
	$_GET["order_direction"]["products"] = "asc";

$db = Application::getDb();
$id_category = 0;
$arr = Compat::array_clone($_GET);
$arr["active"] = 1;
$arr["min_price"] = readPrice(@$_GET["min_price"]);
$arr["max_price"] = readPrice(@$_GET["max_price"]);
$pageTitle = translate("Search results");
$page = "search.php";

$productsCount = $db->tbProduct->advancedGetCount($arr, @$_GET["start"], @$_GET["rowsPerPage"], @$_GET["order_by"]["products"], @$_GET["order_direction"]["products"]);
$products = $db->tbProduct->advancedSearch($arr, @$_GET["start"], @$_GET["rowsPerPage"], @$_GET["order_by"]["products"], @$_GET["order_direction"]["products"]);

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
<?php require_once(WEB_DIR . "/includes/print_messages.php"); ?>

<?php
require_once(WEB_DIR . "/includes/products_list.php");
?>

</main>
<?php require_once(WEB_DIR . "/includes/right.php"); ?>
<?php require_once(WEB_DIR . "/includes/footer.php"); ?>
</body>
</html>