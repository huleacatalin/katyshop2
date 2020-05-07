<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

function template_include_breadcrumb() {
	// local variables scope so they don't conflict with the global ones
	$db = Application::getDb();
	$c = Application::getCurrentCategory();
	$breadcrumb = $db->tbCategory->getBreadcrumb($c->id);

	$breadcrumbProduct = new Product();
	if(!empty($_GET['id_product']))
		$breadcrumbProduct = $db->tbProduct->getRecordById($_GET['id_product']);
	?>
	<nav id="breadcrumb">
	<a href="category.php"><?php echo htmlspecialchars(APP_NAME); ?></a>
	<?php
	for($i = 0; $i < count($breadcrumb); $i++)
	{
		?>
		&raquo; <a href="category.php?id_category=<?php echo htmlspecialchars($breadcrumb[$i]->id); ?>"><?php echo htmlspecialchars($breadcrumb[$i]->title); ?></a>
		<?php
	}

	if(!empty($_GET["id_product"]))
	{
		?>
		&raquo; <a href="product.php?id_product=<?php echo htmlspecialchars($breadcrumbProduct->id); ?>"><?php echo htmlspecialchars($breadcrumbProduct->title); ?></a>
		<?php
	}
	?>
	</nav>
	<?php
}
template_include_breadcrumb();
?>