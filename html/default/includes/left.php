<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

function template_include_left() {
	// local variables scope so they don't conflict with the global ones
	$db = Application::getDb();
	$currentCategory = Application::getCurrentCategory();
	$categoriesTree = $db->tbCategory->getTree();
	?>
	<aside id="left">

	<nav id="categories">
	<?php
	displayCategoriesTree($categoriesTree, 'category.php', $currentCategory);
	?>
	</nav>

	</aside>
	<?php
}
template_include_left();
?>