<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(__FILE__) . "/init.php");
$theme = SessionWrapper::get('html_theme');
require_once(dirname(__FILE__) . "/html/$theme/terms.php");
?>