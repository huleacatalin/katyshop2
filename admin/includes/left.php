<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

?>
<div id="left">

<ul>
<li <?php echo (THIS_PAGE == 'index.php') ? 'class="selected"' : ''; ?>><a href="admin/index.php">Admin</a></li>
<li <?php echo (THIS_PAGE == 'user.php') ? 'class="selected"' : ''; ?>><a href="admin/user.php">Users</a></li>
<li <?php echo (THIS_PAGE == 'order.php') ? 'class="selected"' : ''; ?>><a href="admin/order.php">Orders</a></li>
<li <?php echo (THIS_PAGE == 'manufacturer.php') ? 'class="selected"' : ''; ?>><a href="admin/manufacturer.php">Manufacturers</a></li>
<li <?php echo (THIS_PAGE == 'contact_message.php') ? 'class="selected"' : ''; ?>><a href="admin/contact_message.php">Messages</a></li>
<li <?php echo (THIS_PAGE == 'category.php' && intval(@$_GET['id_category']) == 0) ? 'class="selected"' : ''; ?>><a href="admin/category.php">Categories</a></li>
</ul>

<div id="categories">
<?php
$db = Application::getDb();
$category = Application::getCurrentCategory();
$tree = $db->tbCategory->getTree(false);
displayCategoriesTree($tree, 'admin/category.php', $category);
?>
</div>

</div>