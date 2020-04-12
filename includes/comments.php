
<h3><?php echo translate('Comments'); ?></h3>
<?php
$db = Application::getDb();
$arr = $db->tbComment->getCommentsByProductId($p->id);
foreach($arr as $comment) {
	?>
	<div class="comment">
	<span class="username"><?php echo htmlspecialchars($comment->username); ?>:</span>
	<?php
	if($user->isAdminLoggedIn()) {
		?>
		<span class="delete">
		<form action="formparser/comment.php?action=delete" method="post" id="frm_del_comment_<?php echo intval($comment->id); ?>">
		<input type="hidden" name="id" value="<?php echo intval($comment->id); ?>">
		<input type="hidden" name="id_product" value="<?php echo intval($p->id); ?>">
		<a href="javascript:if(confirm('<?php echo htmlspecialchars(translate('Are you sure you want to delete this comment?')) ?>')) {document.getElementById('frm_del_comment_<?php echo intval($comment->id); ?>').submit()} " title="<?php echo translate('delete'); ?>"><img src="img/icons/delete.png" alt="<?php echo translate('delete'); ?>"><?php echo translate('delete'); ?></a>
		</form>
		</span>
		<?php
	}
	?>
	<span class="date"><time datetime="<?php echo htmlspecialchars($comment->date_created); ?>"><?php echo htmlspecialchars($comment->displayDateTime('date_created')); ?></time></span>
	<p><?php echo nl2br(htmlspecialchars($comment->content)); ?></p>
	</div>
	<?php
}

if($user->isUserLoggedIn()) {
	?>
	<form action="formparser/comment.php?action=post" method="post">
	<input type="hidden" name="id_product" value="<?php echo htmlspecialchars(@$p->id); ?>">
	<label><?php echo translate("Post a comment"); ?>:</label>
	<textarea name="content" required class="comment"></textarea>
	<input type="submit" value="<?php echo translate("Send"); ?>" class="button">
	</form>
	<?php
}
else {
	?>
	<p><?php echo translate("You must login to post a comment"); ?>.</p>
	<?php
}
?>