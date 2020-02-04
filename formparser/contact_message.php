<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(dirname(__FILE__)) . "/init.php");

$db = Application::getDb();
if(@$_GET["action"] == "send")
{
	$user = Application::getUser();
	$m = new ContactMessage();
	$m->copyFromArray($_POST);
	$m->id_user = intval(@$user->id);
	$m->user_details = $user->toStr(true);
	$m->date_sent = date("Y-m-d H:i:s");

	if($m->validate())
	{
		$ma = Application::getMailAgent();
		$db->tbContactMessage->insertObj($m);
		$ma->contactMessage($m);
		Application::addMessage("Message has been sent");
		SessionWrapper::set("editContactMessage", "");
	}
	else
	{
		SessionWrapper::set("editContactMessage", $m);
	}
	Tools::redirect("../contact.php");
}

?>