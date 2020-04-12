<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(__FILE__) . "/init.php");

$db = Application::getDb();
$category = Application::getCurrentCategory();
if($category->id == 0 || !$category->canBeDisplayed())
	Tools::redirect("index.php");
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
<?php
$category = Application::getCurrentCategory();
$hasImage = (!empty($category->picture) && is_file(WEB_DIR . "/img/categories/{$category->picture}"));
?>
<h1><?php echo htmlspecialchars($category->title); ?></h1>
<?php 
require_once(WEB_DIR . "/includes/print_messages.php");
require_once(WEB_DIR . "/includes/breadcrumb.php");

if($hasImage)
{
	?>
	<img src="img/categories/<?php echo htmlspecialchars($category->picture); ?>" style="float: left; margin-right: 20px; ">
	<?php
}
?>
<p><?php echo nl2br(htmlspecialchars($category->description)); ?></p>
<?php
$user = Application::getUser();
if($user->isAdminLoggedIn())
{
	?>
	<p><a href="admin/category.php?action=edit&id_category=<?php echo htmlspecialchars($category->id); ?>" style="font-size: 12pt; "><img src="img/icons/edit.gif"> <?php echo translate("Edit category"); ?> <?php echo htmlspecialchars($category->title); ?></a></p>
	<?php
}
?>
<br clear="all">
<?php
$list = $db->tbCategory->getChildCategories($category->id, "pos", "asc", true);

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
<?php

if(empty($_GET["order_by"]["products"]))
	$_GET["order_by"]["products"] = "pos";
if(empty($_GET["order_direction"]["products"]))
	$_GET["order_direction"]["products"] = "asc";

$id_category = $category->id;
$arr = array("id_category" => intval($id_category), "active" => 1, "only_current_category" => 1);
$pageTitle = "Products from " . htmlspecialchars($category->title);
$page = "category.php";

$productsCount = $db->tbProduct->getCount($arr, @$_GET["start"], @$_GET["rowsPerPage"], @$_GET["order_by"]["products"], @$_GET["order_direction"]["products"]);
$list = $db->tbProduct->search($arr, @$_GET["start"], @$_GET["rowsPerPage"], @$_GET["order_by"]["products"], @$_GET["order_direction"]["products"]);

require_once(WEB_DIR . "/includes/products_list.php");
?>

</main>
<?php require_once(WEB_DIR . "/includes/right.php"); ?>
<?php require_once(WEB_DIR . "/includes/footer.php"); ?>
</body>
</html>