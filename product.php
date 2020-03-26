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
<link rel="stylesheet" href="css/lightbox.min.css">
</head>

<body>
<?php require_once(WEB_DIR . "/includes/header.php"); ?>
<?php require_once(WEB_DIR . "/includes/left.php"); ?>
<div id="content">

<?php
$p = Application::getCurrentProduct();
if($p->id > 0 && $p->canBeDisplayed())
{
	?>
	<h1><?php echo htmlspecialchars($p->title); ?></h1>
	<?php require_once(WEB_DIR . "/includes/print_messages.php"); ?>
	<?php require_once(WEB_DIR . "/includes/breadcrumb.php"); ?>
	<div id="product_image_box">
	<?php
	if(!empty($p->picture) && is_file(WEB_DIR . "/img/products/medium/{$p->picture}"))
	{
		?>
		<a href="img/products/large/<?php echo htmlspecialchars($p->picture); ?>" data-lightbox="example-set"><img src="img/products/medium/<?php echo htmlspecialchars($p->picture); ?>"></a>
		<?php
	}
	$p->getImagesFromDb();
	foreach($p->images as $pi) {
		?>
		<a href="img/products/large/<?php echo htmlspecialchars($pi->filename); ?>" data-lightbox="example-set"><img src="img/products/xsmall/<?php echo htmlspecialchars($pi->filename); ?>"></a>
		<?php
	}
	?>
	</div>
	<p><?php echo nl2br(htmlspecialchars($p->description)); ?></p>

	<ul class="actions public_site">
	<?php
	if($p->id_manufacturer > 0)
	{
		?>
		<li style="font-size: 12pt; color: #555555; font-weight: bold; "><?php echo translate("Manufacturer"); ?>: <?php echo htmlspecialchars($p->manufacturer); ?></li>
		<?php
	}
	?>
	<li style="font-size: 14pt; color: red; font-weight: bold; "><big><?php echo displayPrice($p->price); ?> <?php echo htmlspecialchars(Application::getConfigValue("default_currency")); ?></big></li>
	<?php
	$user = Application::getUser();
	if($user->isAdminLoggedIn())
	{
		?>
		<li><a href="admin/product.php?action=edit&id_product=<?php echo htmlspecialchars($p->id); ?>"><?php echo translate("Edit product"); ?></a></li>
		<?php
	}
	?>
	<li>
		<form action="formparser/order.php?action=add_to_cart" method="post">
		<input type="hidden" name="id_product" value="<?php echo htmlspecialchars(@$p->id); ?>">
		<input type="submit" value="<?php echo translate("Add to the cart"); ?>" class="button">
		</form>
	</li>
	</ul>
	
	<h3><?php echo translate("Description"); ?></h3>
	<p><?php echo $p->content; ?></p>
	
	<?php
	if(!empty($p->technical_details)) {
		?>
		<h3><?php echo translate("Technical details"); ?></h3>
		<?php
		echo nl2br(htmlspecialchars($p->technical_details));
	}
}
?>

</div>
<?php require_once(WEB_DIR . "/includes/right.php"); ?>
<?php require_once(WEB_DIR . "/includes/footer.php"); ?>
<script src="js/lightbox-plus-jquery.min.js"></script>
</body>
</html>