<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(dirname(__FILE__)) . "/init.php");
require_once(WEB_DIR . "/includes/req_admin.php");
?>
<html>
<head>
<title><?php echo APP_NAME; ?></title>
<?php require_once(WEB_DIR . "/includes/html_head.php"); ?>

<script type="text/javascript">
_editor_url = "admin/js/htmlarea/";
_editor_lang = "en";
</script>
<script type="text/javascript" src="admin/js/htmlarea/htmlarea.js"></script>
<script type="text/javascript">
HTMLArea.loadPlugin("ContextMenu");
HTMLArea.onload = function() {
	var editor = new HTMLArea("editor");
	editor.registerPlugin(ContextMenu);
	editor.generate();
};
HTMLArea.init();
</script>
</head>

<body>
<?php require_once(WEB_DIR . "/includes/header.php"); ?>

<?php require_once(WEB_DIR . "/admin/includes/left.php"); ?>
<div id="content">
<h1><?php echo translate("Products admin"); ?></h1>
<?php require_once(WEB_DIR . "/includes/print_messages.php"); ?>
<?php require_once(WEB_DIR . "/admin/includes/breadcrumb.php"); ?>

<form action="admin/formparser/product.php?action=delete" method="post" id="frm_delete_product">
<input type="hidden" name="id_product" value="0">
</form>

<form action="admin/formparser/product_image.php?action=delete" method="post" id="frm_delete_product_image">
<input type="hidden" name="id_product_image" value="0">
</form>

<form action="admin/formparser/product_image.php?action=change_position" method="post" id="frm_change_image_position">
<input type="hidden" name="id_product_image" value="0">
<input type="hidden" name="direction" value="up">
</form>

<?php
$p = Application::getCurrentProduct();
if($p->id > 0)
{
	?>
	<h2><?php echo htmlspecialchars($p->title); ?></h2>
	<p>
	<?php
	if(!empty($p->picture) && is_file(WEB_DIR . "/img/products/medium/{$p->picture}"))
	{
		?>
		<a href="javascript:popupImage('popupimage.php?img_src=img/products/large/<?php echo htmlspecialchars($p->picture); ?>'); "><img src="img/products/medium/<?php echo htmlspecialchars($p->picture); ?>" style="float: left; margin-right: 20px; "></a><br>
		<?php
	}
	echo nl2br(htmlspecialchars($p->description));
	?>
	</p>

	<ul class="actions">
	<?php
	if($p->id_manufacturer > 0)
	{
		?>
		<li style="font-size: 12pt; color: #555555; font-weight: bold; "><?php echo translate("Manufacturer"); ?>: <?php echo htmlspecialchars($p->manufacturer); ?></li>
		<?php
	}
	?>
	<li style="font-size: 14pt; color: red; font-weight: bold; "><big><?php echo displayPrice($p->price); ?> <?php echo htmlspecialchars(Application::getConfigValue("default_currency")); ?></big></li>
	<li class="up"><a href="admin/category.php?id_category=<?php echo intval(@$p->id_category); ?>"><?php echo translate("Parent category"); ?></a></li>
	<?php
	if(intval($p->id) > 0)
	{
		?>
		<li class="edit"><a href="admin/product.php?action=edit&id_product=<?php echo intval(@$p->id); ?>"><?php echo translate("Edit product"); ?> <?php echo htmlspecialchars($p->title); ?></a></li>
		<li class="delete"><a href="javascript:deleteProduct('<?php echo intval($p->id); ?>'); " style="color: red; "><?php echo translate("Delete product"); ?> <?php echo htmlspecialchars($p->title); ?></a></li>
		<?php
		if($p->active == 1)
		{
			?>
			<li><img src="img/icons/bullet_green.gif"> <?php echo translate("Product is active"); ?></a></li>
			<li><a href="product.php?id_product=<?php echo htmlspecialchars($p->id); ?>"><?php echo translate("See the product on the public site"); ?></a></li>
			<?php
		}
		else
		{
			?>
			<li><img src="img/icons/bullet_red.gif"> <?php echo translate("Product is not active"); ?></a></li>
			<?php
		}
	}
	?>
	</ul>

	<br clear="all">
	<?php
}

if(@$_GET["action"] == "edit")
{
	if(isset($_GET["id_product"]))
	{
		$p = $db->tbProduct->getRecordById(@$_GET["id_product"]);
	}
	else
	{
		$p = SessionWrapper::get("editProduct");
		if(!is_a($p, "Product"))
			$p = new Product();
	}
	if(!empty($_GET["id_category"]))
		$p->id_category = intval($_GET["id_category"]);

	if($p->pos == 0)
	{
		$temp = $db->tbProduct->getMaxPos($p->id_category);
		$p->pos = $temp + 1;
	}
	?>
	<h2><?php echo (intval($p->id) > 0) ? translate("Edit product ") . htmlspecialchars($p->title) : translate("Add a new product"); ?></h2>
	<form action="admin/formparser/product.php?action=save" method="post" enctype="multipart/form-data">
	<input type="hidden" name="MAX_FILE_SIZE" value="8000000">
	<input type="hidden" name="id" value="<?php echo htmlspecialchars($p->id); ?>">
	<label><?php echo translate("Title"); ?>: <input type="text" name="title" value="<?php echo htmlspecialchars($p->title); ?>" class="text"></label>
	<label><?php echo translate("Price"); ?>: <input type="text" name="price" value="<?php echo displayPrice($p->price); ?>" class="text"></label>
	<label><?php echo translate("Measuring unit"); ?>:
		<select name="measuring_unit" class="select">
		<option value="">-- <?php echo translate("Choose"); ?> --</option>
		<?php
		$list = Product::getPossibleMeasuringUnits();
		for($i = 0; $i < count($list); $i++)
		{
			$selected = ($p->measuring_unit == $list[$i]) ? "selected" : "";
			?>
			<option value="<?php echo htmlspecialchars($list[$i]); ?>" <?php echo $selected; ?>><?php echo htmlspecialchars(translate($list[$i])); ?></option>
			<?php
		}
		?>
		</select>
	</label>
	<label><?php echo translate("Parent category"); ?>:
		<select name="id_category" class="select">
		<?php
		$tree = $db->tbCategory->getTree(false);
		displayCategoriesSelect($tree, $p->id_category);
		?>
		</select>
	</label>
	<label><?php echo translate("Manufacturer"); ?>:
	<select name="id_manufacturer" class="select">
	<option value="0">-- <?php echo translate("Choose"); ?> --</option>
	<?php
	$list = $db->tbManufacturer->search(array(), 0, 500, "title");
	for($i = 0; $i < count($list); $i++)
	{
		$selected = ($list[$i]->id == $p->id_manufacturer) ? "selected" : "";
		?>
		<option value="<?php echo htmlspecialchars($list[$i]->id); ?>" <?php echo $selected; ?>><?php echo htmlspecialchars($list[$i]->title); ?></option>
		<?php
	}
	?>
	</select>
	</label>
	<label><?php echo translate("Position"); ?>: <input type="text" name="pos" value="<?php echo htmlspecialchars($p->pos); ?>" class="text"></label>
	<label><?php echo translate("Short description (appeares to the list of products)"); ?>: <textarea name="description" style="width: 500px; height: 100px; "><?php echo htmlspecialchars($p->description); ?></textarea></label>
	<label><?php echo translate("Content (detailed description, appeares to the product details page)"); ?>:
		<textarea name="content" id="editor"><?php echo $p->content; ?></textarea>
	</label>
	<label><?php echo translate("Technical details"); ?>: <textarea name="technical_details" style="width: 500px; height: 100px; "><?php echo htmlspecialchars($p->technical_details); ?></textarea></label>
	<?php
	if(count($p->images) > 0) {
		?>
		<p>
		<a name="images">
		<label><?php echo translate("Images"); ?></label>
		<?php
		foreach($p->images as $pi) {
			?>
			<div style="width: 75px; height: 95px; float: left; border: 1px solid black; margin: 5px; text-align: center; ">
			<table cellpadding="0" cellspacing="0">
			<tr>
			<td width="75" height="75" align="center">
			<img src="img/products/xsmall/<?php echo htmlspecialchars($pi->filename); ?>" style="display: block; ">
			</td>
			</tr>
			</table>
			<a href="javascript:product_image_moveUp('<?php echo intval($pi->id); ?>')">&laquo;</a>
			<a href="javascript:deleteProductImage('<?php echo intval($pi->id); ?>'); " style="margin-left: 5px; margin-right: 5px; "><img src="img/icons/delete.png" valign="bottom"></a>
			<a href="javascript:product_image_moveDown('<?php echo intval($pi->id); ?>')">&raquo;</a>
			</div>
			<?php
		}
		?>
		</p>
		<br clear="all">
		<?php
	}
	?>
	<p><?php echo translate("New images (click to upload pictures)"); ?>:
		<input type="file" name="product_image[]" style="display: block; margin: 10px; ">
		<input type="file" name="product_image[]" style="display: block; margin: 10px; ">
		<input type="file" name="product_image[]" style="display: block; margin: 10px; ">
		<input type="file" name="product_image[]" style="display: block; margin: 10px; ">
		<input type="file" name="product_image[]" style="display: block; margin: 10px; ">
	</p>
	<p><?php echo translate("Active"); ?>:
		<label style="display: inline; "><input type="radio" name="active" value="0" <?php echo $p->active == 1 ? "" : "checked"; ?>> <?php echo translate("No"); ?></label>
		<label style="display: inline; "><input type="radio" name="active" value="1" <?php echo $p->active == 1 ? "checked" : ""; ?>> <?php echo translate("Yes"); ?></label>
	</p>
	<p>
		<input type="submit" value="<?php echo translate("Save"); ?>" class="button">
		<input type="button" value="<?php echo translate("Cancel"); ?>" class="button" onclick="redirect('admin/category.php?id_category=<?php echo intval($p->id_category); ?>'); ">
	</p>
	</form>
	<?php
}
?>

</div>
<?php require_once(WEB_DIR . "/includes/right.php"); ?>
<?php require_once(WEB_DIR . "/includes/footer.php"); ?>

</body>
</html>