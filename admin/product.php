<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(__FILE__) . "/init.php");
require_once(dirname(__FILE__) . "/includes/req_admin.php");
?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo htmlspecialchars(APP_NAME); ?></title>
<?php require_once(dirname(__FILE__) . "/includes/html_head.php"); ?>
<script src="admin/js/tinymce/tinymce.min.js" referrerpolicy="origin"></script>
<script src="admin/js/tinymce/init.js?<?php echo time(); ?>"></script>

</head>

<body>
<?php require_once(dirname(__FILE__) . "/includes/header.php"); ?>
<?php require_once(dirname(__FILE__) . "/includes/left.php"); ?>
<main>
<h1><?php echo translate("Products admin"); ?></h1>
<?php require_once(dirname(__FILE__) . "/includes/print_messages.php"); ?>
<?php require_once(dirname(__FILE__) . "/includes/breadcrumb.php"); ?>

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

<article>
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
		<img src="img/products/medium/<?php echo htmlspecialchars($p->picture); ?>" style="float: left; margin-right: 20px; "><br>
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
		<li style="font-size: 12pt; color: #555555; font-weight: bold; "><?php echo htmlspecialchars(translate("Manufacturer")); ?>: <?php echo htmlspecialchars($p->manufacturer); ?></li>
		<?php
	}
	?>
	<li style="font-size: 14pt; color: red; font-weight: bold; "><big><?php echo htmlspecialchars(displayPrice($p->price)); ?> <?php echo htmlspecialchars(Application::getConfigValue("default_currency")); ?></big></li>
	<li class="up"><a href="admin/category.php?id_category=<?php echo intval(@$p->id_category); ?>"><?php echo htmlspecialchars(translate("Parent category")); ?></a></li>
	<?php
	if(intval($p->id) > 0)
	{
		?>
		<li class="edit"><a href="admin/product.php?action=edit&id_product=<?php echo intval(@$p->id); ?>"><?php echo htmlspecialchars(translate("Edit product")); ?> <?php echo htmlspecialchars($p->title); ?></a></li>
		<li class="delete"><a href="javascript:deleteProduct('<?php echo intval($p->id); ?>'); " style="color: red; "><?php echo htmlspecialchars(translate("Delete product")); ?> <?php echo htmlspecialchars($p->title); ?></a></li>
		<?php
		if($p->active == 1)
		{
			?>
			<li><img src="admin/img/icons/bullet_green.gif"> <?php echo htmlspecialchars(translate("Product is active")); ?></a></li>
			<li><a href="product.php?id_product=<?php echo htmlspecialchars($p->id); ?>"><?php echo htmlspecialchars(translate("View the product on the public site")); ?></a></li>
			<?php
		}
		else
		{
			?>
			<li><img src="admin/img/icons/bullet_red.gif"> <?php echo htmlspecialchars(translate("Product is not active")); ?></a></li>
			<?php
		}
		?>
		<li><a href="admin/product.php?action=view_comments&id_product=<?php echo intval($p->id); ?>"><?php echo htmlspecialchars(translate('View comments')); ?></a></li>
		<?php
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
	<h2><?php echo (intval($p->id) > 0) ? htmlspecialchars(translate("Edit product ")) . htmlspecialchars($p->title) : htmlspecialchars(translate("Add a new product")); ?></h2>
	<form action="admin/formparser/product.php?action=save" method="post" enctype="multipart/form-data">
	<input type="hidden" name="MAX_FILE_SIZE" value="8000000">
	<input type="hidden" name="id" value="<?php echo htmlspecialchars($p->id); ?>">
	<label><?php echo htmlspecialchars(translate("Title")); ?>: <input type="text" name="title" required minlength="3" maxlength="255" value="<?php echo htmlspecialchars($p->title); ?>" class="text"></label>
	<label><?php echo htmlspecialchars(translate("Price")); ?>: <input type="number" name="price" required min="0" step="0.01" value="<?php echo $p->price; ?>" class="text"></label>
	<label><?php echo htmlspecialchars(translate("Measuring unit")); ?>:
		<select name="measuring_unit" required class="select">
		<option value="">-- <?php echo htmlspecialchars(translate("Choose")); ?> --</option>
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
	<label><?php echo htmlspecialchars(translate("Parent category")); ?>:
		<select name="id_category" class="select">
		<?php
		$tree = $db->tbCategory->getTree(false);
		displayCategoriesSelect($tree, $p->id_category);
		?>
		</select>
	</label>
	<label><?php echo htmlspecialchars(translate("Manufacturer")); ?>:
	<select name="id_manufacturer" class="select">
	<option value="0">-- <?php echo htmlspecialchars(translate("Choose")); ?> --</option>
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
	<label><?php echo htmlspecialchars(translate("Position")); ?>: <input type="number" name="pos" required min="1" value="<?php echo htmlspecialchars($p->pos); ?>" class="text"></label>
	<label><?php echo htmlspecialchars(translate("Short description (appeares to the list of products)")); ?>: <textarea name="description" maxlength="1000" style="width: 500px; height: 100px; "><?php echo htmlspecialchars($p->description); ?></textarea></label>
	<label><?php echo htmlspecialchars(translate("Content (detailed description, appeares to the product details page)")); ?>:
		<textarea name="content" maxlength="1000000" id="editor"><?php echo htmlspecialchars($p->content); ?></textarea>
	</label>
	<label><?php echo htmlspecialchars(translate("Technical details")); ?>: <textarea name="technical_details" maxlength="1000" style="width: 500px; height: 100px; "><?php echo htmlspecialchars($p->technical_details); ?></textarea></label>
	<?php
	if(count($p->images) > 0) {
		?>
		<p>
		<a name="images">
		<label><?php echo htmlspecialchars(translate("Images")); ?></label>
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
			<a href="javascript:deleteProductImage('<?php echo intval($pi->id); ?>'); " style="margin-left: 5px; margin-right: 5px; "><img src="admin/img/icons/delete.png" valign="bottom"></a>
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
	<p><?php echo htmlspecialchars(translate("New images (click to upload pictures)")); ?>:
		<input type="file" name="product_image[]" style="display: block; margin: 10px; ">
		<input type="file" name="product_image[]" style="display: block; margin: 10px; ">
		<input type="file" name="product_image[]" style="display: block; margin: 10px; ">
		<input type="file" name="product_image[]" style="display: block; margin: 10px; ">
		<input type="file" name="product_image[]" style="display: block; margin: 10px; ">
	</p>
	<p><?php echo htmlspecialchars(translate("Active")); ?>:
		<label style="display: inline; "><input type="radio" name="active" value="0" <?php echo $p->active == 1 ? "" : "checked"; ?>> <?php echo htmlspecialchars(translate("No")); ?></label>
		<label style="display: inline; "><input type="radio" name="active" value="1" <?php echo $p->active == 1 ? "checked" : ""; ?>> <?php echo htmlspecialchars(translate("Yes")); ?></label>
	</p>
	<p>
		<input type="submit" value="<?php echo htmlspecialchars(translate("Save")); ?>" class="button">
		<input type="button" value="<?php echo htmlspecialchars(translate("Cancel")); ?>" class="button" onclick="redirect('admin/category.php?id_category=<?php echo intval($p->id_category); ?>'); ">
	</p>
	</form>
	</article>
	<?php
}
elseif(@$_GET['action'] == 'view_comments') {
	?>
	</article>
	<h3><?php echo htmlspecialchars(translate('Comments')); ?></h3>
	<?php
	$db = Application::getDb();
	$arr = $db->tbComment->getCommentsByProductId(@$p->id);
	foreach($arr as $comment) {
		?>
		<div class="comment">
		<span class="username"><?php echo htmlspecialchars($comment->username); ?>:</span>
		<span class="delete">
		<form action="admin/formparser/comment.php?action=delete" method="post" id="frm_del_comment_<?php echo intval($comment->id); ?>">
		<input type="hidden" name="id" value="<?php echo intval($comment->id); ?>">
		<input type="hidden" name="id_product" value="<?php echo intval($p->id); ?>">
		<a href="javascript:if(confirm('<?php echo htmlspecialchars(translate('Are you sure you want to delete this comment?')) ?>')) {document.getElementById('frm_del_comment_<?php echo intval($comment->id); ?>').submit()} " title="<?php echo htmlspecialchars(translate('delete')); ?>"><img src="admin/img/icons/delete.png" alt="<?php echo htmlspecialchars(translate('delete')); ?>"><?php echo htmlspecialchars(translate('delete')); ?></a>
		</form>
		</span>
		<span class="date"><time datetime="<?php echo htmlspecialchars($comment->date_created); ?>"><?php echo htmlspecialchars($comment->displayDateTime('date_created')); ?></time></span>
		<p><?php echo nl2br(htmlspecialchars($comment->content)); ?></p>
		</div>
		<?php
	}
	
}
?>

</main>
<?php require_once(dirname(__FILE__) . "/includes/right.php"); ?>
<?php require_once(dirname(__FILE__) . "/includes/footer.php"); ?>

</body>
</html>