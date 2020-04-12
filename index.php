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
<main>
<h1><?php echo htmlspecialchars(APP_NAME); ?></h1>
<?php require_once(WEB_DIR . "/includes/print_messages.php"); ?>

<div id="first_page">
<?php
$db = Application::getDb();
$list = $db->tbCategory->getChildCategories(0, "pos", "asc", true);
for($i = 0; $i < count($list); $i++)
{
	$c = $list[$i];
	?>
	<div class="category_box">
	<h2><a href="category.php?id_category=<?php echo intval($c->id); ?>"><?php echo htmlspecialchars($c->title); ?></a></h2>
	<p class="pic">
	<?php
	if(!empty($c->picture) && is_file(WEB_DIR . "/img/categories/{$c->picture}"))
	{
		?>
		<a class="img_href" href="category.php?id_category=<?php echo intval($c->id); ?>"><img src="img/categories/<?php echo htmlspecialchars($c->picture); ?>"></a>
		<?php
	}
	else {
		echo htmlspecialchars($c->description);
	}
	?>
	</p>
	</div>
	<?php
}
?>
<br clear="all">
</div>

<?php
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
$list = $db->tbProduct->search($arr, @$_GET["start"], @$_GET["rowsPerPage"], @$_GET["order_by"]["products"], @$_GET["order_direction"]["products"]);

require_once(WEB_DIR . "/includes/products_list.php");
?>

</main>
<?php require_once(WEB_DIR . "/includes/right.php"); ?>
<?php require_once(WEB_DIR . "/includes/footer.php"); ?>
</body>
</html>