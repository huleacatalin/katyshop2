<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

function template_include_right() {
	// local variables scope so they don't conflict with the global ones
	?>
					<!-- Begin Right Sidebar -->
					<div id="right-sidebar" class="sidebar">

	<?php require_once(dirname(__FILE__) . "/login_box.php"); ?>

	<p><a href="https://www.github.com/huleacatalin/katyshop2" target="_blank"><img src="html/PCStore/img/design/octocat.jpg" width="173"></a></p>
	<p><a href="https://www.sourceforge.net/p/katyshop2" target="_blank"><img src="html/PCStore/img/design/sourceforge.jpg" width="173"></a></p>
	<p><a href="https://www.softpedia.com" target="_blank"><img src="html/PCStore/img/design/softpedia.jpg" width="173"></a></p>
					</div>
					<!-- End Sidebar -->
	<?php
}
template_include_right();
?>