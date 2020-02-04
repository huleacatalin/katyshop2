<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

if(Application::hasErrors() || Application::hasMessages())
{
	?>
	<div id="print_messages">
	<?php
	Application::firstMessage();
	while($s = Application::getNextMessage())
	{
		?>
		<p class="message"><?php echo htmlspecialchars($s); ?></p>
		<?php
	}
	
	Application::firstError();
	while ($s = Application::getNextError())
	{
		?>
		<p class="error"><?php echo htmlspecialchars($s); ?></p>
		<?php
	}
	?>
	</div><!-- END OF <div id="print_messages"> -->
	<?php
}
?>