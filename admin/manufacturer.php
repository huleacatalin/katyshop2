<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(__FILE__) . "/init.php");
require_once(dirname(__FILE__) . "/includes/req_admin.php");
?>
<html>
<head>
<title><?php echo htmlspecialchars(APP_NAME); ?></title>
<?php require_once(dirname(__FILE__) . "/includes/html_head.php"); ?>
</head>

<body>
<?php require_once(dirname(__FILE__) . "/includes/header.php"); ?>
<?php require_once(dirname(__FILE__) . "/includes/left.php"); ?>
<main>
<h1><?php echo htmlspecialchars(translate("Manufacturers admin")); ?></h1>

<form action="admin/formparser/manufacturer.php?action=delete" method="post" id="frm_delete_manufacturer">
<input type="hidden" name="id" value="0">
</form>

<?php require_once(dirname(__FILE__) . "/includes/print_messages.php"); ?>

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
	<h2><?php echo ($m->id == 0) ? htmlspecialchars(translate("Add a new manufacturer")) : htmlspecialchars(translate("Edit manufacturer details")); ?></h2>
	<p><a href="admin/manufacturer.php">&laquo; <?php echo htmlspecialchars(translate("Back to the manufacturers list")); ?></a></p>
	<form action="admin/formparser/manufacturer.php?action=save" method="post" enctype="multipart/form-data">
	<input type="hidden" name="MAX_FILE_SIZE" value="8000000">
	<input type="hidden" name="id" value="<?php echo htmlspecialchars($m->id); ?>">
	<label><?php echo htmlspecialchars(translate("Title")); ?>: <input type="text" name="title" required minlength="3" maxlength="255" value="<?php echo htmlspecialchars($m->title); ?>" class="text"></label>
	<label><?php echo htmlspecialchars(translate("Description")); ?>: <textarea name="description" maxlength="1000" style="height: 100px; "><?php echo htmlspecialchars($m->description); ?></textarea></label>
	<p><?php echo htmlspecialchars(translate("Image")); ?> <br>
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
		<a href="javascript:changeManufacturerPicture(); " id="the_picture_link"><?php echo htmlspecialchars(translate("click here to change the image")); ?></a><br>
		<input type="file" name="picture" disabled style="display: none; " id="the_picture">
	</p>
	<p>
		<input type="submit" value="<?php echo htmlspecialchars(translate("Save")); ?>" class="button">
		<input type="button" value="<?php echo htmlspecialchars(translate("Cancel")); ?>" class="button" onclick="redirect('admin/manufacturer.php'); ">
	</p>
	</form>
	<?php
}
else
{
	?>
	<h2><?php echo htmlspecialchars(translate("Manufacturers list")); ?></h2>
	<a href="admin/manufacturer.php?action=detail&id=0"><?php echo htmlspecialchars(translate("click here to add a new manufacturer")); ?></a>
	<?php
	$list = $db->tbManufacturer->search(@$_GET, @$_GET["start"], @$_GET["rowsPerPage"], @$_GET["order_by"], @$_GET["order_direction"]);
	$manufacturersCount = $db->tbManufacturer->getCount(@$_GET, @$_GET["start"], @$_GET["rowsPerPage"], @$_GET["order_by"], @$_GET["order_direction"]);
	if($manufacturersCount == 0)
	{
		?>
		<p><?php echo htmlspecialchars(translate("There are no manufacturers in the list")); ?></p>
		<?php
	}
	else
	{
		?>
		<table cellpadding="2" cellspacing="0" class="cuborder">
		<tr>
		<td>&nbsp;</td>
		<td><?php echo pagination_columnHead(translate("Title"), "title") ?></td>
		<td><?php echo pagination_columnHead(translate("Description"), "description") ?></td>
		<td>&nbsp;</td>
		</tr>
		<?php
		$theme = SessionWrapper::get('html_theme');
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
				<a href="admin/manufacturer.php?action=detail&id=<?php echo htmlspecialchars($m->id); ?>"><img src="admin/img/icons/edit.gif" alt="edit"></a>
				<a href="javascript:deleteManufacturer('<?php echo htmlspecialchars($m->id); ?>'); "><img src="admin/img/icons/delete.png"></a>
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
</main>
<?php require_once(dirname(__FILE__) . "/includes/right.php"); ?>
<?php require_once(dirname(__FILE__) . "/includes/footer.php"); ?>
</body>
</html>