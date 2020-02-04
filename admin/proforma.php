<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(dirname(__FILE__)) . "/init.php");
require_once(WEB_DIR . "/includes/req_admin.php");

$filename = DATA_DIR . "/orders/{$_GET["code"]}.html";
if (!is_file($filename))
{
	die("Could not find the file that contains proforma invoice");
}
else
{
	$s = file_get_contents($filename);
	$s = Tools::decrypt($s, Application::getConfigValue('openssl_key'));
	echo $s;
}


?>