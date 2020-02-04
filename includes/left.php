<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

?>
<div id="left">

<div id="categories">
<?php
$db = Application::getDb();
$c = Application::getCurrentCategory();
$tree = $db->tbCategory->getTree();
displayCategoriesTree($tree, 'category.php', $c);
?>
</div>

</div>