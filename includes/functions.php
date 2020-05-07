<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

/**
 * Small simple functions, mainly used for html output.
 * Nothing related to database or other complex logic should stay here.
 */
 
function translate($str) {
	 $lang_code = Application::getConfigValue("lang_code");
	 $lang = Application::getConfigValue("lang");
	 $arr = array();
	 if(@array_key_exists($lang_code, $lang))
		$arr = $lang[$lang_code];
	
	 if(array_key_exists($str, $arr) && !empty($arr[$str]))
		 return $arr[$str];
	 else
		return $str;
}

function getImgDir() {
	if(defined('IN_ADMIN') && IN_ADMIN == true) {
		return 'admin/img';
	}
	else {
		$theme = SessionWrapper::get('html_theme');
		return "html/$theme/img";
	}
}

//#######################################################
//# PAGINATION											#
//#######################################################

function _pagination_composeLink($start, $rowsPerPage, $orderBy, $orderDirection, $listName = "")
{
	$listNameParam = empty($listName) ? "" : "[$listName]";
	$s = "?start$listNameParam=$start";
	$s .= "&rowsPerPage$listNameParam=$rowsPerPage";
	$s .= "&order_by$listNameParam=$orderBy";
	$s .= "&order_direction$listNameParam=$orderDirection";
	if(empty($listName))
	{
		$s .= "&" . Tools::http_build_query2($_GET, array("start", "rowsPerPage", "order_by", "order_direction"));
	}
	else
	{
		$s .= "&" . Tools::http_build_query2($_GET, array($listName));
		$s .= "#" . $listName . '" ';
	}
	return $s;
}

function pagination_readRowsPerPage($listName, $defaultValue = 25)
{
	$rowsPerPage = (empty($listName)) ? intval(@$_GET["rowsPerPage"]) : intval(@$_GET["rowsPerPage"][$listName]);
	if($rowsPerPage == 0)
		$rowsPerPage = $defaultValue;
	return $rowsPerPage;
}

function pagination_columnHead($text, $columnName, $displayArrows = true, $listName = "")
{
	$start = empty($listName) ? intval(@$_GET["start"]) : intval(@$_GET["start"][$listName]);
	$rowsPerPage = pagination_readRowsPerPage($listName);
	$orderBy = empty($listName) ? @$_GET["order_by"] : @$_GET["order_by"][$listName];
	$orderDirection = empty($listName) ? @$_GET["order_direction"] : @$_GET["order_direction"][$listName];

	$asc = !($orderBy == $columnName && $orderDirection == "asc");
	$title = ($asc) ? translate("order ascending by ") . $text : translate("order descending by ") .$text;
	$class = ($asc) ? "desc" : "asc"; // at this moment, $asc is reverse of the current option
	$newDirection = ($asc) ? "asc" : "desc";

	$s = '<a href="' . THIS_DIR . THIS_PAGE;
	$s .= _pagination_composeLink(0, $rowsPerPage, $columnName, $newDirection, $listName);
	$s .= '" ';

	if($orderBy == $columnName)
		$s .= 'class="' . $class . '" ';
	$s .= 'title="' . htmlspecialchars($title) . '">';
	$s .= htmlspecialchars(@$text) . '</a>';
	if($displayArrows)
		$s .= pagination_arrows($text, $columnName, $listName);
	return $s;
}

/**
 * If you leave $direction null, both arrows will be drawn.
 * If you set it to "asc", only the ascending arrow will be drawn.
 * If you set it to "desc", only the descending arrow will be drawn.
 */
function pagination_arrows($text, $columnName, $listName = "", $direction = null)
{
	if(is_null($direction))
	{
		$s = pagination_arrows($text, $columnName, $listName, "asc");
		$s .= pagination_arrows($text, $columnName, $listName, "desc");
		return $s;
	}
	else
	{
		$start = empty($listName) ? intval(@$_GET["start"]) : intval(@$_GET["start"][$listName]);
		$rowsPerPage = pagination_readRowsPerPage($listName);
		$orderBy = empty($listName) ? @$_GET["order_by"] : @$_GET["order_by"][$listName];
		$orderDirection = empty($listName) ? @$_GET["order_direction"] : @$_GET["order_direction"][$listName];
		$asc = ($direction == "asc");
		$title = ($asc) ? translate("order ascending by ") . $text : translate("order descending by ") . $text;

		$s = '<a href="' . THIS_DIR . THIS_PAGE;
		$s .= _pagination_composeLink(0, $rowsPerPage, $columnName, $direction, $listName);
		$s .= '" ';
		$s .= 'title="' . htmlspecialchars($title) . '">';

		if($orderBy == $columnName && $direction == $orderDirection)
		{
			if($direction == "desc")
				$s .= '<img src="' . getImgDir() . '/icons/bullet_arrow_down_orange.gif" alt="' . htmlspecialchars($title) . '">';
			else
				$s .= '<img src="' . getImgDir() . '/icons/bullet_arrow_up_orange.gif" alt="' . htmlspecialchars($title) . '">';
		}
		else
		{
			if($direction == "desc")
				$s .= '<img src="' . getImgDir() . '/icons/bullet_arrow_down.gif" alt="' . htmlspecialchars($title) . '">';
			else
				$s .= '<img src="' . getImgDir() . '/icons/bullet_arrow_up.gif" alt="' . htmlspecialchars($title) . '">';
		}

		$s .= '</a>';
		return $s;
	}
}

function pagination_listPages($recordsCount, $defaultRowsPerPage = 25, $listName = "")
{
	$start = empty($listName) ? intval(@$_GET["start"]) : intval(@$_GET["start"][$listName]);
	$rowsPerPage = pagination_readRowsPerPage($listName);
	$orderBy = empty($listName) ? @$_GET["order_by"] : @$_GET["order_by"][$listName];
	$orderDirection = empty($listName) ? @$_GET["order_direction"] : @$_GET["order_direction"][$listName];

	$previous = $start - $rowsPerPage;
	if($previous < 0)
		$previous = 0;
	$next = $start + $rowsPerPage;
	if($next >= $recordsCount)
		$next = $recordsCount - $rowsPerPage;
	if($next < 0)
		$next = 0;

	$s = translate("Page: ");
	$s .= '<a href="' . THIS_DIR . THIS_PAGE;
	$s .= _pagination_composeLink($previous, $rowsPerPage, $orderBy, $orderDirection, $listName);
	$s .= '">&laquo; ' . translate('Previous') . '</a> ';

	$page = 0;
	for($i = 0; $i < $recordsCount; $i+= $rowsPerPage)
	{
		$page++;
		if($start == $i)
		{
			$s .= "<b>$page</b> ";
		}
		else
		{
			$s .= '<a href="' . THIS_DIR . THIS_PAGE;
			$s .= _pagination_composeLink($i, $rowsPerPage, $orderBy, $orderDirection, $listName);
			$s .= '">' . $page . '</a> ';
		}
	}

	$s .= '<a href="' . THIS_DIR . THIS_PAGE;
	$s .= _pagination_composeLink($next, $rowsPerPage, $orderBy, $orderDirection, $listName);
	$s .= '">' . translate("Next") . ' &raquo; </a> ';
	return $s;
}

function pagination_rowsPerPage($listName = "")
{
	$start = empty($listName) ? intval(@$_GET["start"]) : intval(@$_GET["start"][$listName]);
	$rowsPerPage = pagination_readRowsPerPage($listName);
	$orderBy = empty($listName) ? @$_GET["order_by"] : @$_GET["order_by"][$listName];
	$orderDirection = empty($listName) ? @$_GET["order_direction"] : @$_GET["order_direction"][$listName];

	$options = array(1, 2, 3, 4, 5, 10, 20, 30, 40, 50, 100, 250, 500, 750, 1000);
	$s = translate('Rows per page') . ': <select onchange="changeUrlBySel(this); " style="width: 40px; display: inline; ">';
	for($i = 0; $i < count($options); $i++)
	{
		$selected = ($rowsPerPage == $options[$i]) ? "selected" : "";
		$url = THIS_DIR . THIS_PAGE . _pagination_composeLink(0, $options[$i], $orderBy, $orderDirection, $listName);
		$s .= '<option value="' . $url . '" ' . $selected . '>' . $options[$i] . '</option>';
	}
	$s .= '</select>';
	return $s;
}


//		displayOrderBy($category->id, "pos", "asc", "category.php", "products");
//#######################################################
//# GENERIC												#
//#######################################################

/**
 * function getHeadingLink($key)
 * This function is used to add sort capabilities to a table that lists something from database
 *
 * Sample:
 *
 * $tableFields = array(
 * 	// "array_key_name" => array("db_field_name", "html_table_display_name")
 * 	"name" => array("name", "Name"),
 * 	"code" => array("code", "Code"),
 * 	"customer" => array("customer_rel_type", "Customer"),
 * 	"supplier" => array("supplier_rel_type", "Supplier"),
 * 	"email" => array("email", "Email"),
 * 	"telephone" => array("telephone", "Telephone")
 * );
 *
 *
 *		<table class="cuborder" cellspacing="0">
 * 		<tr>
 * 		<th><?php echo getHeadingLink("name"); ?></th>
 * 		<th><?php echo getHeadingLink("code"); ?></th>
 * 		<th><?php echo getHeadingLink("customer"); ?></th>
 * 		<th><?php echo getHeadingLink("supplier"); ?></th>
 * 		<th><?php echo getHeadingLink("email"); ?></th>
 * 		<th><?php echo getHeadingLink("telephone"); ?></th>
 *		</tr>
 *
 */

$tableFields = array();
function getHeadingLink($key, $panel = "admin")
{
	global $tableFields;
	$s = '<a href="' . THIS_DIR . THIS_PAGE;
	$s .= '?order_by=' . $key;

	$asc = true;
	if(@$_GET["order_by"] == $key && @$_GET["order_direction"] == "asc")
		$asc = false;
	$s .= '&order_direction=' . ($asc ? "asc" : "desc");
	$s .= "&" . Tools::http_build_query2($_GET, array("order_by", "order_direction"));
	$s .= '" ';

	if(@$_GET["order_by"] == $key)
	{
		// at this moment, $asc is reverse of the current option
		if(!$asc)
			$class = "asc";
		else
			$class = "desc";
		$s .= 'class="' . $class . '" ';
	}

	$s .= '>' . htmlspecialchars(@$tableFields[$key][1]) . '</a>';
	return $s;
}

function getListPages($recordsCount, $defaultRowsPerPage = 25)
{
	$s = "";

	$start = intval(@$_GET["start"]);
	$rowsPerPage = intval(@$_GET["rowsPerPage"]);
	if($rowsPerPage == 0)
		$rowsPerPage = $defaultRowsPerPage;
	$previous = $start - $rowsPerPage;
	if($previous < 0)
		$previous = 0;
	$next = $start + $rowsPerPage;
	if($next >= $recordsCount)
		$next = $recordsCount - $rowsPerPage;
	if($next < 0)
		$next = 0;

	$s .= translate("Page: ");
	$s .= '<a href="' . THIS_DIR . THIS_PAGE;
	$s .= "?start=$previous&rowsPerPage=$rowsPerPage&" . Tools::http_build_query2($_GET, array("start", "rowsPerPage"));
	$s .= '">&laquo; ' . translate("Previous") . '</a> ';

	$page = 0;
	for($i = 0; $i < $recordsCount; $i+= $rowsPerPage)
	{
		$page++;
		if($start == $i)
		{
			$s .= "<b>$page</b> ";
		}
		else
		{
			$s .= '<a href="' . THIS_DIR . THIS_PAGE;
			$s .= "?start=$i&rowsPerPage=$rowsPerPage&" . Tools::http_build_query2($_GET, array("start", "rowsPerPage"));
			$s .= '">' . $page . '</a> ';
		}
	}


	$s .= '<a href="' . THIS_DIR . THIS_PAGE;
	$s .= "?start=$next&rowsPerPage=$rowsPerPage&" . Tools::http_build_query2($_GET, array("start", "rowsPerPage"));
	$s .= '">' . translate("Next") . ' &raquo; </a> ';
	return $s;
}

function filterCriteria($criteria, $tableFields)
{
	$ret = array();
	foreach ($tableFields as $key => $value)
	{
		$dbField = $tableFields[$key][0];
		$ret[$dbField] = @$criteria[$key];
	}
	return $ret;
}

function filterStart($start)
{
	$start = intval($start);
	if($start > 0)
		return $start;
	else
		return 0;
}

function filterRowsPerPage($rowsPerPage, $defaultValue = 25)
{
	$rowsPerPage = intval($rowsPerPage);
	if($rowsPerPage > 0)
		return $rowsPerPage;
	else
		return $defaultValue;
}

function filterOrderBy($orderBy, $tableFields, $defaultValue)
{
	if(!empty($tableFields[$orderBy][0]))
		return $tableFields[$orderBy][0];
	else
		return $defaultValue;
}

function filterOrderDirection($orderDirection, $defaultValue = "asc")
{
	if($orderDirection == "desc")
		return "desc";
	elseif ($orderDirection == "asc")
		return "asc";
	else
		return $defaultValue;
}

//#######################################################
//# WEBSITE SPECIFIC									#
//#######################################################

function displayCategoriesTree($tree, $file, $currentCategory, $nestLevel = 0)
{
	if(count($tree) == 0)
		return;
	$nestLevel = intval($nestLevel);
	
	echo '<ul>';
	foreach($tree as $entry) {
		$c = $entry['item'];
		$children = $entry['children'];
		$selected = ($currentCategory->id == $c->id);
		$cssClass = "nest_level_$nestLevel";
		if($selected)
			$cssClass .= ' selected';
		?>
		<li class="<?php echo $cssClass; ?>">
		<a href="<?php echo $file; ?>?id_category=<?php echo htmlspecialchars($c->id); ?>"><?php echo htmlspecialchars($c->title); ?></a>
		</li>
		<?php
		displayCategoriesTree($children, $file, $currentCategory, $nestLevel + 1);
		?>
		<?php
	}
	echo '</ul>';
}

function displayCategoriesSelect($tree, $id_selected, $nestLevel = 0)
{
	if($nestLevel == 0) {
		?>
		<option value="0"><?php echo htmlspecialchars(APP_NAME); ?></option>
		<?php
	}
	foreach($tree as $entry) {
		$c = $entry['item'];
		$children = $entry['children'];
		$paddingLeft = '';
		for($i = 0; $i < $nestLevel; $i++)
			$paddingLeft .= '&nbsp;&nbsp;&nbsp;&nbsp;';
		?>
		<option value="<?php echo htmlspecialchars($c->id); ?>" <?php echo ($id_selected == $c->id) ? 'selected' : ''; ?>><?php echo $paddingLeft . htmlspecialchars($c->title); ?></option>
		<?php
		displayCategoriesSelect($children, $id_selected, $nestLevel + 1);
	}
}

function displayOrderBy($id_category, $field, $direction, $file, $object)
{
	?><a href="<?php echo $file; ?>?id_category=<?php echo intval($id_category) ?>&order_by[<?php echo $object; ?>]=<?php echo htmlspecialchars($field); ?>&order_direction[<?php echo $object; ?>]=<?php echo htmlspecialchars($direction); ?>#<?php echo $object; ?>"
		title="order <?php echo htmlspecialchars($direction); ?>ending by <?php echo htmlspecialchars($field); ?>"><?php
	if(@$_GET["order_by"][$object] == $field && $direction == @$_GET["order_direction"][$object])
	{
		if($direction == "desc")
		{
			?><img src="<?php echo getImgDir(); ?>/icons/bullet_arrow_down_orange.gif" alt="order descending by <?php echo htmlspecialchars($field); ?>"><?php
		}
		else
		{
			?><img src="<?php echo getImgDir(); ?>/icons/bullet_arrow_up_orange.gif" alt="order ascending by <?php echo htmlspecialchars($field); ?>"><?php
		}
	}
	else
	{
		if($direction == "desc")
		{
			?><img src="<?php echo getImgDir(); ?>/icons/bullet_arrow_down.gif" alt="order descending by <?php echo htmlspecialchars($field); ?>"><?php
		}
		else
		{
			?><img src="<?php echo getImgDir(); ?>/icons/bullet_arrow_up.gif" alt="order ascending by <?php echo htmlspecialchars($field); ?>"><?php
		}
	}
	?></a><?php
}

function displayDestinationTree($breadCrumb, $index = -1)
{
	$db = Application::getDb();
	if($index == -1)
		$c = new Category(0, APP_NAME);
	else
		$c = $breadCrumb[$index];
	$children = $db->tbCategory->getChildCategories($c->id);
	if(count($children) > 0)
	{
		echo "<ul>";
		for ($i = 0; $i < count($children); $i++)
		{
			$c = $children[$i];
			$active = ($index + 1 < count($breadCrumb) && $breadCrumb[$index + 1]->id == $c->id);
			$selected = ($index + 2 == count($breadCrumb) && $breadCrumb[$index + 1]->id == $c->id);
			$liClass = '';
			if($db->tbCategory->getChildrenCount($c->id) > 0)
			{
				if($active)
					$liClass = 'class="expanded"';
				else
					$liClass = 'class="collapsed"';
			}
			?>
			<li <?php echo $liClass; ?>>
			<a href="admin/category.php?action=change_parent&id_category=<?php echo intval(@$_GET["id_category"]); ?>&id_destination=<?php echo htmlspecialchars($c->id); ?>" <?php echo ($selected) ? 'class="active"' : ''; ?>><?php echo htmlspecialchars($c->title); ?></a>
			<?php
			if($active)
				displayDestinationTree($breadCrumb, $index + 1);
			?>
			</li>
			<?php
		}
		echo "</ul>";
	}
}

/**
 * @param float $x
 * @return string - return the price formatted as a string with thousands and decimals separators
 */
function displayPrice($x)
{
	return number_format($x, 2, ".", ",");
}

/**
 * Takes as a parameter a string formatted with displayPrice() and return the original float
 * @param string $str
 * @return float
 */
function readPrice($str)
{
	return Tools::read_number_format($str, 2, ".", ",");
}




?>