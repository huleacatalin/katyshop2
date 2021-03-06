<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

?>
<html>
<head>
<title><?php echo htmlspecialchars(APP_NAME); ?></title>
<?php require_once(dirname(__FILE__) . "/includes/html_head.php"); ?>
</head>

<body>
<!--  Free CSS Templates from www.templatemo.com -->
<div id="templatemo_container">
<?php require_once(dirname(__FILE__) . "/includes/header.php"); ?>
    <div id="templatemo_content">
<?php require_once(dirname(__FILE__) . "/includes/left.php"); ?>
        <div id="templatemo_content_right">
<main>
<h1><?php echo htmlspecialchars(translate("My orders")); ?></h1>
<?php require_once(dirname(__FILE__) . "/includes/print_messages.php"); ?>

<p>
<?php echo htmlspecialchars(translate("Select by status")); ?>:
<a href="orders_list.php"><?php echo htmlspecialchars(translate("All")); ?></a>
<?php
for($i = 0; $i < count($orderStatuses); $i++)
{
	if($orderStatuses[$i] != "in cart")
	{
		?>
		| <a href="orders_list.php?status=<?php echo rawurlencode($orderStatuses[$i]); ?>"><?php echo htmlspecialchars(translate($orderStatuses[$i])); ?></a>
		<?php
	}
}
?>
</p>
<?php

if($ordersCount > 0)
{
	?>
	<form action="orders_list.php" method="get">
	<?php echo Tools::http_build_hidden_inputs($_GET, array("title")); ?>
	<label style="float: left; margin-right: 20px; "><?php echo htmlspecialchars(translate("Title")); ?>: <input type="text" name="title" value="<?php echo htmlspecialchars(@$_GET["title"]); ?>" class="text"></label>
	<label style="float: left; margin-right: 20px; "><?php echo htmlspecialchars(translate("Code")); ?>: <input type="text" name="code" value="<?php echo htmlspecialchars(@$_GET["code"]); ?>" class="text"></label>
	<label style="clear: both;"><?php echo htmlspecialchars(translate("Status")); ?>: <input type="text" name="status" value="<?php echo htmlspecialchars(@$_GET["status"]); ?>" class="text"></label>
	<input type="submit" value="<?php echo htmlspecialchars(translate("Search")); ?>" class="button">
	</form>

	<table class="cuborder" cellspacing="0" cellpadding="2">
	<tr>
	<th nowrap><?php echo pagination_columnHead(translate("ID"), "id"); ?></th>
	<th nowrap><?php echo pagination_columnHead(translate("Title"), "title"); ?></th>
	<th nowrap><?php echo pagination_columnHead(translate("Code"), "code"); ?></th>
	<th nowrap><?php echo pagination_columnHead(translate("Status"), "status"); ?></th>
	<th nowrap><?php echo pagination_columnHead(translate("Date"), "date_ordered"); ?></th>
	<th nowrap><?php echo pagination_columnHead(translate("Total"), "total"); ?></th>
	</tr>
	<?php
	for($i = 0; $i < count($orders); $i++)
	{
		$o = $orders[$i];
		?>
		<tr onmouseover="this.style.backgroundColor='#ddeeff'; " onmouseout="this.style.backgroundColor='#ffffff'; ">
		<td><?php echo htmlspecialchars($o->id); ?></td>
		<td onclick="redirect('order.php?id=<?php echo htmlspecialchars($o->id); ?>'); ">
			<a href="order.php?id=<?php echo htmlspecialchars($o->id); ?>"><?php echo htmlspecialchars($o->title); ?></a>
			&nbsp;
		</td>
		<td onclick="redirect('order.php?id=<?php echo htmlspecialchars($o->id); ?>'); ">
			<a href="order.php?id=<?php echo htmlspecialchars($o->id); ?>"><?php echo htmlspecialchars($o->code); ?></a>
			&nbsp;
		</td>
		<td><?php echo htmlspecialchars($o->status); ?></td>
		<td><time datetime="<?php echo htmlspecialchars($o->date_ordered); ?>"><?php echo htmlspecialchars($o->displayDateTime('date_ordered')); ?></time></td>
		<td align="right" style="font-weight: bold; "><?php echo htmlspecialchars(displayPrice($o->total)); ?></td>
		</tr>
		<?php
	}
	?>
	<tr>
	<td colspan="6" align="right">
	<?php
	echo pagination_listPages($ordersCount);
	echo pagination_rowsPerPage();
	?>
	</td>
	</tr>
	</table>
	<?php
}
else
{
	?>
	<p><?php echo htmlspecialchars(translate("Could not find any order for your search criteria.")); ?></p>
	<?php
}
?>

</main>
            <div class="cleaner_with_height">&nbsp;</div>
        </div> <!-- end of content right -->
<?php /* require_once(dirname(__FILE__) . "/includes/right.php"); */ ?>

    	<div class="cleaner_with_height">&nbsp;</div>
    </div> <!-- end of content -->
    
<?php require_once(dirname(__FILE__) . "/includes/footer.php"); ?>
<!--  Free CSS Template www.templatemo.com -->
</div> <!-- end of container -->
<!-- templatemo 086 book store -->
<!-- 
Book Store Template 
http://www.templatemo.com/preview/templatemo_086_book_store 
-->
</body>
</html>