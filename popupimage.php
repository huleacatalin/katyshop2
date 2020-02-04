<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

?>
<html>
<head>
<title>Picture</title>
<style>
img
{
	margin: 0px;
}

a.window_close
{
	display: block;
	height: 20px;
	font-family: verdana;
	font-size: 10pt;
	color: #ff0000;
	background-color: #cae4ff;
}

a.window_close:hover
{
	background-color: #a4c8ee;
}
</style>
<script language="javascript">
function resizeWindow(picture)
{
	var diffX = picture.width - document.body.clientWidth + 5;
	var diffY = picture.height - document.body.clientHeight + 25;

	if(picture.width > (screen.availWidth - 100))
		diffX -= picture.width - (screen.availWidth - 100);
	if(picture.height > (screen.availHeight - 200))
		diffY -= picture.height - (screen.availHeight - 200);

	window.resizeBy(diffX, diffY);
	//window.resizeTo(picture.width, picture.height);
}

function centerWindow()
{
	var x = screen.availWidth - document.body.clientWidth;
	var y = screen.availHeight - document.body.clientHeight;
	x /= 2;
	y /= 2;
	y -= 100; // presume some toolbars

	if(x < 0)
		x = 0;
	if(y < 0)
		y = 0;
	window.moveTo(x, y);
}
</script>

</head>

<body style="margin: 0px; padding: 0px; ">
<a href="javascript:window.close(); " class="window_close"><nobr>(X) close window</nobr></a>
<img src="<?php echo htmlspecialchars(@$_GET["img_src"]); ?>" onload="resizeWindow(this); centerWindow(); ">
</body>
</html>