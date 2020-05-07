<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(__FILE__) . "/init.php");
$db = Application::getDb();
$childCategories = $db->tbCategory->getChildCategories(0, "pos", "asc", true);

if(empty($_GET["order_by"]["products"]))
	$_GET["order_by"]["products"] = "pos";
if(empty($_GET["order_direction"]["products"]))
	$_GET["order_direction"]["products"] = "asc";

$category = new Category();
$id_category = $category->id;
$arr = array("id_category" => intval($id_category), "active" => 1, "only_current_category" => 1);
$pageTitle = translate("Products");
$page = "index.php";

$productsCount = $db->tbProduct->getCount($arr, @$_GET["start"], @$_GET["rowsPerPage"], @$_GET["order_by"]["products"], @$_GET["order_direction"]["products"]);
$products = $db->tbProduct->search($arr, @$_GET["start"], @$_GET["rowsPerPage"], @$_GET["order_by"]["products"], @$_GET["order_direction"]["products"]);

$theme = SessionWrapper::get('html_theme');
require_once(dirname(__FILE__) . "/html/$theme/index.php");
?>