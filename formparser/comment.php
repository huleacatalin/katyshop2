<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(dirname(__FILE__)) . "/init.php");

$user = Application::getUser();
$db = Application::getDb();
if(!$user->isUserLoggedIn())
	Tools::redirect("../login.php");

if(@$_GET["action"] == "post")
{
	$comment = new Comment();
	$comment->copyFromArray($_POST);
	$comment->id_user = $user->id;
	if($comment->validate()) {
		$db->tbComment->insertObj($comment);
		Application::addMessage('Comment sent');
	}
	Tools::redirect('../product.php?id_product=' . intval($comment->id_product));
}
elseif(@$_GET['action'] == 'delete') {
	if($user->isAdminLoggedIn()) {
		$db->tbComment->deleteById(@$_POST['id']);
		Application::addMessage('Comment deleted');
	}
	Tools::redirect('../product.php?id_product=' . intval(@$_POST['id_product']));
}

?>