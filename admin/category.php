<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(dirname(__FILE__)) . "/init.php");
require_once(WEB_DIR . "/includes/req_admin.php");
$db = Application::getDb();
$category = Application::getCurrentCategory();

?>
<html>
<head>
<title><?php echo APP_NAME; ?></title>
<?php require_once(WEB_DIR . "/includes/html_head.php"); ?>
</head>

<body>
<?php require_once(WEB_DIR . "/includes/header.php"); ?>
<?php require_once(WEB_DIR . "/admin/includes/left.php"); ?>
<main>
<h1><?php echo translate("Categories administration"); ?></h1>
<?php require_once(WEB_DIR . "/includes/print_messages.php"); ?>
<?php require_once(WEB_DIR . "/admin/includes/breadcrumb.php"); ?>

<form action="admin/formparser/category.php?action=delete" method="post" id="frm_delete_category">
<input type="hidden" name="id_category" value="0">
</form>

<form action="admin/formparser/category.php?action=change_position" method="post" id="frm_change_category_position">
<input type="hidden" name="id_category" value="0">
<input type="hidden" name="direction" value="up">
</form>

<form action="admin/formparser/category.php?action=change_active_state" method="post" id="frm_change_category_active_state">
<input type="hidden" name="id_category" value="0">
<input type="hidden" name="active" value="1">
</form>

<form action="admin/formparser/product.php?action=delete" method="post" id="frm_delete_product">
<input type="hidden" name="id_product" value="0">
<input type="hidden" name="start" value="<?php echo htmlspecialchars(@$_GET['start']); ?>">
<input type="hidden" name="rowsPerPage" value="<?php echo htmlspecialchars(@$_GET['rowsPerPage']); ?>">
<input type="hidden" name="order_by[subcategs]" value="<?php echo htmlspecialchars(@$_GET['order_by']['subcategs']); ?>">
<input type="hidden" name="order_by[products]" value="<?php echo htmlspecialchars(@$_GET['order_by']['products']) ?>">
<input type="hidden" name="order_direction[subcategs]" value="<?php echo htmlspecialchars(@$_GET['order_direction']['subcategs']); ?>">
<input type="hidden" name="order_direction[products]" value="<?php echo htmlspecialchars(@$_GET['order_direction']['products']); ?>">
</form>

<form action="admin/formparser/product.php?action=change_position" method="post" id="frm_change_product_position">
<input type="hidden" name="id_product" value="0">
<input type="hidden" name="direction" value="up">
<input type="hidden" name="start" value="<?php echo htmlspecialchars(@$_GET['start']); ?>">
<input type="hidden" name="rowsPerPage" value="<?php echo htmlspecialchars(@$_GET['rowsPerPage']); ?>">
<input type="hidden" name="order_by[subcategs]" value="<?php echo htmlspecialchars(@$_GET['order_by']['subcategs']); ?>">
<input type="hidden" name="order_by[products]" value="<?php echo htmlspecialchars(@$_GET['order_by']['products']) ?>">
<input type="hidden" name="order_direction[subcategs]" value="<?php echo htmlspecialchars(@$_GET['order_direction']['subcategs']); ?>">
<input type="hidden" name="order_direction[products]" value="<?php echo htmlspecialchars(@$_GET['order_direction']['products']); ?>">
</form>

<form action="admin/formparser/product.php?action=change_active_state" method="post" id="frm_change_product_active_state">
<input type="hidden" name="id_product" value="0">
<input type="hidden" name="active" value="1">
<input type="hidden" name="start" value="<?php echo htmlspecialchars(@$_GET['start']); ?>">
<input type="hidden" name="rowsPerPage" value="<?php echo htmlspecialchars(@$_GET['rowsPerPage']); ?>">
<input type="hidden" name="order_by[subcategs]" value="<?php echo htmlspecialchars(@$_GET['order_by']['subcategs']); ?>">
<input type="hidden" name="order_by[products]" value="<?php echo htmlspecialchars(@$_GET['order_by']['products']) ?>">
<input type="hidden" name="order_direction[subcategs]" value="<?php echo htmlspecialchars(@$_GET['order_direction']['subcategs']); ?>">
<input type="hidden" name="order_direction[products]" value="<?php echo htmlspecialchars(@$_GET['order_direction']['products']); ?>">
</form>
<?php
if($category->id == 0)
{
	$category->title = APP_NAME;
	$category->description = translate("Root category for products in your store");
}
?>
<h2><?php echo htmlspecialchars($category->title); ?></h2>
<?php
if(!empty($category->picture) && is_file(WEB_DIR . "/img/categories/{$category->picture}"))
{
	?>
	<img src="img/categories/<?php echo htmlspecialchars($category->picture); ?>" style="float: left; ">
	<?php
}
echo nl2br(htmlspecialchars($category->description));
?>

<ul class="actions">
<li class="up"><a href="admin/category.php?id_category=<?php echo intval(@$category->id_parent); ?>"><?php echo translate("Parent category"); ?></a></li>
<li class="add_category"><a href="admin/category.php?action=edit&id_category=0&id_parent=<?php echo intval(@$category->id); ?>"><?php echo translate("Add a new category"); ?></a></li>
<li class="add_product"><a href="admin/product.php?action=edit&id_product=0&id_category=<?php echo intval(@$category->id); ?>"><?php echo translate("Add a new product"); ?></a></li>
<?php
if(intval($category->id) > 0)
{
	?>
	<li class="edit"><a href="admin/category.php?action=edit&id_category=<?php echo intval(@$category->id); ?>"><?php echo translate("Edit category"); ?> <?php echo htmlspecialchars($category->title); ?></a></li>
	<li class="delete"><a href="javascript:deleteCategory('<?php echo intval($category->id); ?>'); " style="color: red; "><?php echo translate("Delete category"); ?> <?php echo htmlspecialchars($category->title); ?></a></li>
	<?php
	if($category->active == 1)
	{
		?>
		<li><img src="img/icons/bullet_green.gif"> <?php echo translate("Category is active"); ?></a></li>
		<li><a href="category.php?id_category=<?php echo htmlspecialchars($category->id); ?>"><?php echo translate("View category on the public site"); ?></a></li>
		<?php
	}
	else
	{
		?>
		<li><img src="img/icons/bullet_red.gif"> <?php echo translate("Category is not active"); ?></a></li>
		<?php
	}
}
?>
</ul>
<br clear="all">

<?php
if(@$_GET["action"] == "edit")
{
	if(isset($_GET["id_category"]))
	{
		$c = $db->tbCategory->getRecordById(@$_GET["id_category"]);
	}
	else
	{
		$c = SessionWrapper::get("editCategory");
		if(!is_a($c, "Category"))
			$c = new Category();
	}
	if(!empty($_GET["id_parent"]))
		$c->id_parent = intval($_GET["id_parent"]);

	if($c->pos == 0)
	{
		$temp = $db->tbCategory->getMaxPos($c->id_parent);
		$c->pos = $temp + 1;
	}
	?>
	<h2><?php echo (intval($c->id) > 0) ? translate("Edit category") . " " . htmlspecialchars($c->title) : translate("Add a new category"); ?></h2>
	<form action="admin/formparser/category.php?action=save" method="post" enctype="multipart/form-data">
	<input type="hidden" name="MAX_FILE_SIZE" value="8000000">
	<input type="hidden" name="id" value="<?php echo htmlspecialchars($c->id); ?>">
	<label><?php echo translate("Title"); ?>: <input type="text" name="title" required minlength="3" maxlength="255" value="<?php echo htmlspecialchars($c->title); ?>" class="text"></label>
	<label><?php echo translate("Parent category"); ?>:
		<select name="id_parent" class="select">
		<?php
		$tree = $db->tbCategory->getTree(false);
		displayCategoriesSelect($tree, $c->id_parent);
		?>
		</select>
	</label>
	<label><?php echo translate("Position"); ?>: <input type="number" name="pos" required min="1" value="<?php echo htmlspecialchars($c->pos); ?>" class="text"></label>
	<label><?php echo translate("Description"); ?>: <textarea name="description" maxlength="1000" style="height: 100px; "><?php echo htmlspecialchars($c->description); ?></textarea></label>
	<p><?php echo translate("Picture"); ?> <br>
		<?php
		if(!empty($c->picture))
		{
			?>
			<a href="img/categories/<?php echo htmlspecialchars($c->picture); ?>" target="_blank"><?php echo htmlspecialchars($c->picture); ?></a>
			<br>
			<?php
		}
		?>
		<a href="javascript:changeCategoryPicture(); " id="the_picture_link"><?php echo translate("click here to change picture"); ?></a>
		<br>
		<input type="file" name="picture" disabled style="display: none; " id="the_picture">
	</p>
	<p><?php echo translate("Active"); ?>:
		<label style="display: inline; "><input type="radio" name="active" value="0" <?php echo $c->active == 1 ? "" : "checked"; ?>> <?php echo translate("No"); ?></label>
		<label style="display: inline; "><input type="radio" name="active" value="1" <?php echo $c->active == 1 ? "checked" : ""; ?>> <?php echo translate("Yes"); ?></label>
	</p>
	<p>
		<input type="submit" value="Save" class="button">
		<input type="button" value="Cancel" class="button" onclick="redirect('admin/category.php?id_category=<?php echo (intval($c->id) > 0) ? intval($c->id) : intval($c->id_parent); ?>'); ">
	</p>
	</form>
	<?php
}
else
{
	if(empty($_GET["order_by"]["subcategs"]))
		$_GET["order_by"]["subcategs"] = "pos";
	if(empty($_GET["order_direction"]["subcategs"]))
		$_GET["order_direction"]["subcategs"] = "asc";
	// subcategories list
	$list = $db->tbCategory->getChildCategories($category->id, @$_GET["order_by"]["subcategs"], @$_GET["order_direction"]["subcategs"]);
	if(count($list) > 0)
	{
		?>
		<a name="subcategs"></a>
		<h3><?php echo translate("Subcategories from"); ?> <?php echo htmlspecialchars($category->title); ?></h3>
		<table cellpadding="2" cellspacing="0" class="cuborder">
		<tr>
		<th><?php echo translate("Position"); ?>
			<?php
			displayOrderBy($category->id, "pos", "asc", "admin/category.php", "subcategs");
			displayOrderBy($category->id, "pos", "desc", "admin/category.php", "subcategs");
			?>
		</th>
		<th><?php echo translate("Picture"); ?></th>
		<th><?php echo translate("Title"); ?>
			<?php
			displayOrderBy($category->id, "title", "asc", "admin/category.php", "subcategs");
			displayOrderBy($category->id, "title", "desc", "admin/category.php", "subcategs");
			?>
		</th>
		<th><?php echo translate("Active"); ?>
			<?php
			displayOrderBy($category->id, "active", "asc", "admin/category.php", "subcategs");
			displayOrderBy($category->id, "active", "desc", "admin/category.php", "subcategs");
			?>
		</th>
		<th><?php echo translate("Actions"); ?></th>
		<th><?php echo translate("Created date"); ?>
			<?php
			displayOrderBy($category->id, "date_created", "asc", "admin/category.php", "subcategs");
			displayOrderBy($category->id, "date_created", "desc", "admin/category.php", "subcategs");
			?>
		</th>
		</tr>
		<?php
		for($i = 0; $i < count($list); $i++)
		{
			$c = $list[$i];
			?>
			<tr valign="top">
			<td>
				<table cellpadding="0" cellspacing="0" style="margin: 0px;">
				<tr>
				<td style="font-size: 20pt; "><?php echo htmlspecialchars($c->pos); ?></td>
				<td>
					<a href="javascript:category_moveUp('<?php echo intval($c->id); ?>'); " title="move up" style="display: block; "><img src="img/icons/bullet_arrow_up_blue.gif" alt="move up"></a>
					<a href="javascript:category_moveDown('<?php echo intval($c->id); ?>'); " title="move down"><img src="img/icons/bullet_arrow_down_blue.gif" alt="move down"></a>
				</td>
				</tr>
				</table>
			</td>
			<td align="center">
			<?php
			if(!empty($c->picture) && is_file(WEB_DIR . "/img/categories/{$c->picture}"))
			{
				?>
				<a href="admin/category.php?id_category=<?php echo intval($c->id); ?>">
				<img src="img/categories/<?php echo htmlspecialchars($c->picture); ?>">
				</a>
				<?php
			}
			?>
			</td>
			<td>
			<a href="admin/category.php?id_category=<?php echo intval($c->id); ?>"><?php echo htmlspecialchars($c->title); ?></a>
			<br>
			<?php echo nl2br(htmlspecialchars(Tools::limitString($c->description, 100))); ?>
			</td>
			<td>
			<?php
			if(intval($c->active) == 1)
			{
				?>
				<a href="javascript:deactivateCategory('<?php echo intval($c->id); ?>'); " title="deactivate"><img src="img/icons/bullet_red_blur.gif" alt="deactivate"></a>
				<img src="img/icons/bullet_green.gif" alt="<?php echo translate("category is active on the public site"); ?>">
				<?php
			}
			else
			{
				?>
				<img src="img/icons/bullet_red.gif" alt="category is not active on the public site">
				<a href="javascript:activateCategory('<?php echo intval($c->id); ?>'); " title="activate"><img src="img/icons/bullet_green_blur.gif" alt="activate"></a>
				<?php
			}
			?>
			</td>
			<td>
			<a href="admin/category.php?action=edit&id_category=<?php echo intval($c->id); ?>" title="edit"><img src="img/icons/edit.gif" alt="edit"></a>
			<a href="javascript:deleteCategory('<?php echo intval($c->id); ?>'); " title="delete"><img src="img/icons/delete.png" alt="delete"></a>
			</td>
			<td>
			<time datetime="<?php echo htmlspecialchars($c->date_created); ?>"><?php echo htmlspecialchars($c->displayDateTime('date_created')); ?></time>
			</td>
			</tr>
			<?php
		}
		?>
		</table>
		<?php
	}
	require_once(WEB_DIR . "/admin/includes/products_list.php");
}
?>

</main>
<?php require_once(WEB_DIR . "/includes/right.php"); ?>
<?php require_once(WEB_DIR . "/includes/footer.php"); ?>
</body>
</html>