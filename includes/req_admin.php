<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

$user = Application::getUser();
if(!$user->isAdminLoggedIn())
	Tools::redirect("login.php", true);
?>