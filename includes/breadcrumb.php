<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

?>
<p id="admin_breadcrumb">
<a href="category.php"><?php echo htmlspecialchars(APP_NAME); ?></a>
<?php
$db = Application::getDb();
$category = Application::getCurrentCategory();
$list = $db->tbCategory->getBreadcrumb($category->id);

for($i = 0; $i < count($list); $i++)
{
	?>
	&raquo; <a href="category.php?id_category=<?php echo htmlspecialchars($list[$i]->id); ?>"><?php echo htmlspecialchars($list[$i]->title); ?></a>
	<?php
}

if(!empty($_GET["id_product"]))
{
	$p = $db->tbProduct->getRecordById($_GET["id_product"]);
	?>
	&raquo; <a href="product.php?id_product=<?php echo htmlspecialchars($p->id); ?>"><?php echo htmlspecialchars($p->title); ?></a>
	<?php
}
?>
</p>