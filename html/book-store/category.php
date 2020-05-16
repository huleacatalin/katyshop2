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
<!--  Free CSS Templates from www.templatemo.com -->
<div id="templatemo_container">
<?php require_once(dirname(__FILE__) . "/includes/header.php"); ?>
    <div id="templatemo_content">
<?php require_once(dirname(__FILE__) . "/includes/left.php"); ?>
        <div id="templatemo_content_right">
<main>
<h1><?php echo htmlspecialchars($category->title); ?></h1>
<?php 
require_once(dirname(__FILE__) . "/includes/print_messages.php");
require_once(dirname(__FILE__) . "/includes/breadcrumb.php");

if($hasImage)
{
	?>
	<img src="img/categories/<?php echo htmlspecialchars($category->picture); ?>" style="float: left; margin-right: 20px; ">
	<?php
}
?>
<p><?php echo nl2br(htmlspecialchars($category->description)); ?></p>
<?php
if($user->isAdminLoggedIn())
{
	?>
	<p><a href="admin/category.php?action=edit&id_category=<?php echo htmlspecialchars($category->id); ?>" style="font-size: 12pt; "><img src="html/book-store/img/icons/edit.gif"> <?php echo htmlspecialchars(translate("Edit category")); ?> <?php echo htmlspecialchars($category->title); ?></a></p>
	<?php
}
?>
<br clear="all">
<?php
for($i = 0; $i < count($childCategories); $i++)
{
	$c = $childCategories[$i];
	?>
	<a href="category.php?id_category=<?php echo intval($c->id); ?>" class="category-button"><?php echo htmlspecialchars($c->title); ?></a>
	<?php
}
?>
<br clear="all">
<?php require_once(dirname(__FILE__) . "/includes/products_list.php"); ?>
</main>
            <div class="cleaner_with_height">&nbsp;</div>
        </div> <!-- end of content right -->
<?php /* require_once(dirname(__FILE__) . "/includes/right.php"); */ ?>

    	<div class="cleaner_with_height">&nbsp;</div>
    </div> <!-- end of content -->
    
<?php require_once(dirname(__FILE__) . "/includes/footer.php"); ?>
<!--  Free CSS Template www.templatemo.com -->
</div> <!-- end of container -->
<!-- templatemo 086 book store -->
<!-- 
Book Store Template 
http://www.templatemo.com/preview/templatemo_086_book_store 
-->
</body>
</html>