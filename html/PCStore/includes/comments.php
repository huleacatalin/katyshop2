<?php
function template_include_comments() {
	// local variables scope so they don't conflict with the global ones
	global $product;
	$db = Application::getDb();
	$comments = $db->tbComment->getCommentsByProductId($product->id);
	$user = Application::getUser();
	?>
	<h3><?php echo htmlspecialchars(translate('Comments')); ?></h3>
	<?php
	foreach($comments as $comment) {
		?>
		<div class="comment">
		<span class="username"><?php echo htmlspecialchars($comment->username); ?>:</span>
		<?php
		if($user->isAdminLoggedIn()) {
			?>
			<span class="delete">
			<form action="formparser/comment.php?action=delete" method="post" id="frm_del_comment_<?php echo intval($comment->id); ?>">
			<input type="hidden" name="id" value="<?php echo intval($comment->id); ?>">
			<input type="hidden" name="id_product" value="<?php echo intval($product->id); ?>">
			<a href="javascript:if(confirm('<?php echo htmlspecialchars(translate('Are you sure you want to delete this comment?')) ?>')) {document.getElementById('frm_del_comment_<?php echo intval($comment->id); ?>').submit()} " title="<?php echo htmlspecialchars(translate('delete')); ?>"><img src="html/PCStore/img/icons/delete.png" alt="<?php echo htmlspecialchars(translate('delete')); ?>"><?php echo htmlspecialchars(translate('delete')); ?></a>
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
		<input type="hidden" name="id_product" value="<?php echo htmlspecialchars(@$product->id); ?>">
		<label><?php echo htmlspecialchars(translate("Post a comment")); ?>:</label>
		<textarea name="content" required class="comment"></textarea>
		<input type="submit" value="<?php echo htmlspecialchars(translate("Send")); ?>" class="button">
		</form>
		<?php
	}
	else {
		?>
		<p><?php echo htmlspecialchars(translate("You must login to post a comment")); ?>.</p>
		<?php
	}
}
template_include_comments();
?>