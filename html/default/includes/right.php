<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

function template_include_right() {
	// local variables scope so they don't conflict with the global ones
	?>
	<aside id="right">

	<?php require_once(dirname(__FILE__) . "/login_box.php"); ?>

	<p><a href="https://www.github.com/huleacatalin/katyshop2" target="_blank"><img src="html/default/img/design/octocat.jpg"></a></p>
	<p><a href="https://www.sourceforge.net/p/katyshop2" target="_blank"><img src="html/default/img/design/sourceforge.jpg"></a></p>
	</aside>
	<?php
}
template_include_right();
?>