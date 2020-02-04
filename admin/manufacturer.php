<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(dirname(__FILE__)) . "/init.php");
require_once(WEB_DIR . "/includes/req_admin.php");
?>
<html>
<head>
<title><?php echo APP_NAME; ?></title>
<?php require_once(WEB_DIR . "/includes/html_head.php"); ?>
</head>

<body>
<?php require_once(WEB_DIR . "/includes/header.php"); ?>
<?php require_once(WEB_DIR . "/admin/includes/left.php"); ?>
<div id="content">
<h1>Manufacturers admin</h1>

<form action="admin/formparser/manufacturer.php?action=delete" method="post" id="frm_delete_manufacturer">
<input type="hidden" name="id" value="0">
</form>

<?php require_once(WEB_DIR . "/includes/print_messages.php"); ?>

<?php
$db = Application::getDb();
if(@$_GET["action"] == "detail")
{
	if(isset($_GET["id"]))
	{
		$m = $db->tbManufacturer->getManufacturerById($_GET["id"]);
	}
	else
	{
		$m = SessionWrapper::get("editManufacturer");
		if(!is_a($m, "Manufacturer"))
			$m = new Manufacturer();
	}
	?>
	<h2><?php echo ($m->id == 0) ? "Add a new manufacturer" : "Edit manufacturer details"; ?></h2>
	<p><a href="admin/manufacturer.php">&laquo; Back to the manufacturers list</a></p>
	<form action="admin/formparser/manufacturer.php?action=save" method="post" enctype="multipart/form-data">
	<input type="hidden" name="MAX_FILE_SIZE" value="8000000">
	<input type="hidden" name="id" value="<?php echo htmlspecialchars($m->id); ?>">
	<label>Title: <input type="text" name="title" value="<?php echo htmlspecialchars($m->title); ?>" class="text"></label>
	<label>Description: <textarea name="description" style="height: 100px; "><?php echo htmlspecialchars($m->description); ?></textarea></label>
	<p>Image <br>
		<?php
		if(!empty($m->picture))
		{
			?>
			<img src="img/manufacturers/<?php echo htmlspecialchars($m->picture); ?>">
			<br>
			<?php echo htmlspecialchars($m->picture); ?>
			<br>
			<?php
		}
		?>
		<a href="javascript:changeManufacturerPicture(); " id="the_picture_link">click here to change the image</a><br>
		<input type="file" name="picture" disabled style="display: none; " id="the_picture">
	</p>
	<p>
		<input type="submit" value="Save" class="button">
		<input type="button" value="Cancel" class="button" onclick="redirect('admin/manufacturer.php'); ">
	</p>
	</form>
	<?php
}
else
{
	?>
	<h2>Manufacturers list</h2>
	<a href="admin/manufacturer.php?action=detail&id=0">click here to add a new manufacturer</a>
	<?php
	$list = $db->tbManufacturer->search(@$_GET, @$_GET["start"], @$_GET["rowsPerPage"], @$_GET["order_by"], @$_GET["order_direction"]);
	$manufacturersCount = $db->tbManufacturer->getCount(@$_GET, @$_GET["start"], @$_GET["rowsPerPage"], @$_GET["order_by"], @$_GET["order_direction"]);
	if($manufacturersCount == 0)
	{
		?>
		<p>There are no manufacturers in the list</p>
		<?php
	}
	else
	{
		?>
		<table cellpadding="2" cellspacing="0" class="cuborder">
		<tr>
		<td>&nbsp;</td>
		<td><?php echo pagination_columnHead("Title", "title") ?></td>
		<td><?php echo pagination_columnHead("Description", "description") ?></td>
		<td>&nbsp;</td>
		</tr>
		<?php
		for($i = 0; $i < count($list); $i++)
		{
			$m = $list[$i];
			?>
			<tr>
			<td>
				<?php
				if(!empty($m->picture) && is_file(WEB_DIR . "/img/manufacturers/{$m->picture}"))
				{
					?>
					<a href="admin/manufacturer.php?action=detail&id=<?php echo htmlspecialchars($m->id); ?>"><img src="img/manufacturers/<?php echo htmlspecialchars($m->picture); ?>"></a>
					<?php
				}
				?>
				&nbsp;
			</td>
			<td><a href="admin/manufacturer.php?action=detail&id=<?php echo htmlspecialchars($m->id); ?>"><?php echo htmlspecialchars($m->title); ?></a></td>
			<td><a href="admin/manufacturer.php?action=detail&id=<?php echo htmlspecialchars($m->id); ?>"><?php echo htmlspecialchars(Tools::limitString($m->description)); ?></a></td>
			<td>
				<a href="admin/manufacturer.php?action=detail&id=<?php echo htmlspecialchars($m->id); ?>"><img src="img/icons/edit.gif" alt="edit"></a>
				<a href="javascript:deleteManufacturer('<?php echo htmlspecialchars($m->id); ?>'); "><img src="img/icons/delete.png"></a>
			</td>
			</tr>
			<?php
		}
		?>
		<tr>
		<td colspan="4" align="right">
		<?php
		echo pagination_listPages($manufacturersCount);
		echo pagination_rowsPerPage();
		?>
		</td>
		</tr>
		</table>
		<?php
	}
}
?>
</div>
<?php require_once(WEB_DIR . "/includes/right.php"); ?>
<?php require_once(WEB_DIR . "/includes/footer.php"); ?>
</body>
</html>