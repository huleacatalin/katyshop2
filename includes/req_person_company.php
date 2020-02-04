<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

$user = Application::getUser();
if(!$user->isPersonLoggedIn() && !$user->isCompanyLoggedIn())
	Tools::redirect("login.php", true);
?>