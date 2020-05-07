<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

$category = Application::getCurrentCategory();
if(empty($_GET["order_by"]["products"]))
	$_GET["order_by"]["products"] = "pos";
if(empty($_GET["order_direction"]["products"]))
	$_GET["order_direction"]["products"] = "asc";
$productsCount = $db->tbProduct->getCount(array("id_category" => intval($category->id)), @$_GET["start"], @$_GET["rowsPerPage"], @$_GET["order_by"]["products"], @$_GET["order_direction"]["products"]);
$list = $db->tbProduct->search(array("id_category" => intval($category->id)), @$_GET["start"], @$_GET["rowsPerPage"], @$_GET["order_by"]["products"], @$_GET["order_direction"]["products"]);
if($productsCount > 0)
{
	?>
	<a name="products"></a>
	<h3><?php echo htmlspecialchars(translate("Products from")); ?> <?php echo htmlspecialchars($category->title); ?></h3>
	<table cellpadding="2" cellspacing="0" class="cuborder">
	<tr>
	<th><?php echo htmlspecialchars(translate("Position")); ?>
		<?php
		displayOrderBy($category->id, "pos", "asc", "admin/category.php", "products");
		displayOrderBy($category->id, "pos", "desc", "admin/category.php", "products");
		?>
	</th>
	<th><?php echo htmlspecialchars(translate("Image")); ?></th>
	<th><?php echo htmlspecialchars(translate("Title")); ?>
		<?php
		displayOrderBy($category->id, "title", "asc", "admin/category.php", "products");
		displayOrderBy($category->id, "title", "desc", "admin/category.php", "products");
		?>
	</th>
	<th><?php echo htmlspecialchars(translate("Active")); ?>
		<?php
		displayOrderBy($category->id, "active", "asc", "admin/category.php", "products");
		displayOrderBy($category->id, "active", "desc", "admin/category.php", "products");
		?>
	</th>
	<th><?php echo htmlspecialchars(translate("Actions")); ?></th>
	<th><?php echo htmlspecialchars(translate("Created date")); ?>
		<?php
		displayOrderBy($category->id, "date_created", "asc", "admin/category.php", "products");
		displayOrderBy($category->id, "date_created", "desc", "admin/category.php", "products");
		?>
	</th>
	</tr>
	<?php
	for($i = 0; $i < count($list); $i++)
	{
		$p = $list[$i];
		?>
		<article>
		<header>
		<tr valign="top">
		<td>
			<table cellpadding="0" cellspacing="0" style="margin: 0px;">
			<tr>
			<td style="font-size: 20pt; "><?php echo htmlspecialchars($p->pos); ?></td>
			<td>
				<a href="javascript:product_moveUp('<?php echo intval($p->id); ?>'); " title="move up" style="display: block; "><img src="admin/img/icons/bullet_arrow_up_blue.gif" alt="move up"></a>
				<a href="javascript:product_moveDown('<?php echo intval($p->id); ?>'); " title="move down"><img src="admin/img/icons/bullet_arrow_down_blue.gif" alt="move down"></a>
			</td>
			</tr>
			</table>
		</td>
		<td align="center">
		<?php
		if(!empty($p->picture) && is_file(WEB_DIR . "/img/products/small/{$p->picture}"))
		{
			?>
			<a href="admin/product.php?action=edit&id_product=<?php echo intval($p->id); ?>">
			<img src="img/products/small/<?php echo htmlspecialchars($p->picture); ?>">
			</a>
			<?php
		}
		?>
		</td>
		<td>
		<a href="admin/product.php?action=edit&id_product=<?php echo intval($p->id); ?>"><b><?php echo htmlspecialchars($p->title); ?></b>
		<br>
		<?php echo nl2br(htmlspecialchars(Tools::limitString($p->description, 100))); ?></a>
		</td>
		<td>
		<?php
		if(intval($p->active) == 1)
		{
			?>
			<a href="javascript:deactivateProduct('<?php echo intval($p->id); ?>'); " title="deactivate"><img src="admin/img/icons/bullet_red_blur.gif" alt="deactivate"></a>
			<img src="admin/img/icons/bullet_green.gif" alt="<?php echo htmlspecialchars(translate("product is active on the public site")); ?>">
			<?php
		}
		else
		{
			?>
			<img src="admin/img/icons/bullet_red.gif" alt="<?php echo htmlspecialchars(translate("product is not active on the public site")); ?>">
			<a href="javascript:activateProduct('<?php echo intval($p->id); ?>'); " title="activate"><img src="admin/img/icons/bullet_green_blur.gif" alt="activate"></a>
			<?php
		}
		?>
		</td>
		<td>
			<a href="admin/product.php?action=edit&id_product=<?php echo intval($p->id); ?>" title="edit"><img src="admin/img/icons/edit.gif" alt="edit"></a>
			<a href="javascript:deleteProduct('<?php echo intval($p->id); ?>'); " title="delete"><img src="admin/img/icons/delete.png" alt="delete"></a>
		</td>
		<td>
			<time datetime="<?php echo htmlspecialchars($p->date_created); ?>"><?php echo htmlspecialchars($p->displayDateTime('date_created')); ?></time>
		</td>
		</tr>
		</header>
		</article>
		<?php
	}
	?>
	</table>
	<?php
	echo getListPages($productsCount);
}
?>