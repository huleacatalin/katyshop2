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
        <div id="templatemo_content_left">
        	<div class="templatemo_content_left_section">
			
	<?php require_once(dirname(__FILE__) . "/shopping_cart_box.php"); ?>
	
				<br clear="all">
            	<h1>Categories</h1>
	<aside id="left">

	<nav id="categories">
	<?php
	displayCategoriesTree($categoriesTree, 'category.php', $currentCategory);
	?>
	</nav>

	</aside>
				<br clear="all">
            </div>
        </div> <!-- end of content left -->
	<?php
}
template_include_left();
?>