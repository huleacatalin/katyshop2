<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(__FILE__) . "/init.php");

$user = Application::getUser();
if($user->isUserLoggedIn())
	Tools::redirect("index.php");

$registerUser = SessionWrapper::get("registerUser");
if(!is_a($registerUser, "User"))
	$registerUser = new User();

$theme = SessionWrapper::get('html_theme');
require_once(dirname(__FILE__) . "/html/$theme/register.php");
?>