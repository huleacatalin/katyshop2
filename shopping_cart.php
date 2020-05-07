<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(__FILE__) . "/init.php");

$user = Visitor::getInstance();
if($user->isAdminLoggedIn()) {
	Application::addError('Admin accounts cannot send orders');
	Tools::redirect('admin');
}
$basket = Application::getShoppingCart();

$theme = SessionWrapper::get('html_theme');
require_once(dirname(__FILE__) . "/html/$theme/shopping_cart.php");
?>