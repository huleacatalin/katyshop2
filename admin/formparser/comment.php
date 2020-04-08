<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(dirname(dirname(__FILE__))) . "/init.php");
require_once(WEB_DIR . "/includes/req_admin.php");

$db = Application::getDb();

if(@$_GET['action'] == 'delete') {
	$db->tbComment->deleteById(@$_POST['id']);
	Application::addMessage('Comment deleted');
	Tools::redirect('../product.php?action=view_comments&id_product=' . intval(@$_POST['id_product']));
}

?>