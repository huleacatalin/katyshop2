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
<link rel="stylesheet" href="html/default/css/lightbox.min.css">
</head>

<body>
<?php require_once(dirname(__FILE__) . "/includes/header.php"); ?>
<?php require_once(dirname(__FILE__) . "/includes/left.php"); ?>
<main>

<?php
if($product->id > 0 && $product->canBeDisplayed())
{
	?>
	<article>
	<h1><?php echo htmlspecialchars($product->title); ?></h1>
	<?php require_once(dirname(__FILE__) . "/includes/print_messages.php"); ?>
	<?php require_once(dirname(__FILE__) . "/includes/breadcrumb.php"); ?>
	<figure id="product_image_box">
	<?php
	if(!empty($product->picture) && is_file(WEB_DIR . "/img/products/medium/{$product->picture}"))
	{
		?>
		<a href="img/products/large/<?php echo htmlspecialchars($product->picture); ?>" data-lightbox="example-set"><img src="img/products/medium/<?php echo htmlspecialchars($product->picture); ?>"></a>
		<br>
		<?php
	}
	$product->getImagesFromDb();
	foreach($product->images as $pi) {
		?>
		<a href="img/products/large/<?php echo htmlspecialchars($pi->filename); ?>" data-lightbox="example-set"><img src="img/products/xsmall/<?php echo htmlspecialchars($pi->filename); ?>"></a>
		<?php
	}
	?>
	</figure>
	<p><?php echo nl2br(htmlspecialchars($product->description)); ?></p>

	<ul class="actions public_site">
	<?php
	if($product->id_manufacturer > 0)
	{
		?>
		<li style="font-size: 12pt; color: #555555; font-weight: bold; "><?php echo htmlspecialchars(translate("Manufacturer")); ?>: <?php echo htmlspecialchars($product->manufacturer); ?></li>
		<?php
	}
	?>
	<li style="font-size: 14pt; color: red; font-weight: bold; "><big><?php echo htmlspecialchars(displayPrice($product->price)); ?> <?php echo htmlspecialchars(Application::getConfigValue("default_currency")); ?></big></li>
	<?php
	$user = Application::getUser();
	if($user->isAdminLoggedIn())
	{
		?>
		<li><a href="admin/product.php?action=edit&id_product=<?php echo htmlspecialchars($product->id); ?>"><?php echo htmlspecialchars(translate("Edit product")); ?></a></li>
		<?php
	}
	?>
	<li>
		<form action="formparser/order.php?action=add_to_cart" method="post">
		<input type="hidden" name="id_product" value="<?php echo htmlspecialchars(@$product->id); ?>">
		<input type="submit" value="<?php echo htmlspecialchars(translate("Add to the cart")); ?>" class="button">
		</form>
	</li>
	</ul>
	
	<p><?php echo $product->content; ?></p>
	
	<?php
	if(!empty($product->technical_details)) {
		?>
		<h3><?php echo htmlspecialchars(translate("Technical details")); ?></h3>
		<?php
		echo nl2br(htmlspecialchars($product->technical_details));
	}
	?>
	</article>
	<br clear="all">
	<?php require_once(dirname(__FILE__) . "/includes/comments.php"); ?>
	<?php
}
?>

</main>
<?php require_once(dirname(__FILE__) . "/includes/right.php"); ?>
<?php require_once(dirname(__FILE__) . "/includes/footer.php"); ?>
<script src="html/default/js/lightbox-plus-jquery.min.js"></script>
</body>
</html>