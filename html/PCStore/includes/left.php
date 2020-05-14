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
	
	<!-- Begin Left Sidebar -->
	<div id="left-sidebar" class="sidebar">
		<ul>
			<li class="widget">
				<h2>Categories</h2>
				<div class="widget-entry">
					<?php
					displayCategoriesTree($categoriesTree, 'category.php', $currentCategory);
					?>
				</div>
			</li>

		</ul>
	</div>
	<!-- End Sidebar -->
	
	<?php
}
template_include_left();
?>