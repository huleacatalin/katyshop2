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
<?php require_once(dirname(__FILE__) . "/includes/header.php"); ?>
<?php require_once(dirname(__FILE__) . "/includes/left.php"); ?>
<main>
<h1><?php echo htmlspecialchars(APP_NAME); ?></h1>
<?php require_once(dirname(__FILE__) . "/includes/print_messages.php"); ?>

<div id="first_page">
<?php
for($i = 0; $i < count($childCategories); $i++)
{
	$c = $childCategories[$i];
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

<?php require_once(dirname(__FILE__) . "/includes/products_list.php"); ?>

</main>
<?php require_once(dirname(__FILE__) . "/includes/right.php"); ?>
<?php require_once(dirname(__FILE__) . "/includes/footer.php"); ?>
</body>
</html>