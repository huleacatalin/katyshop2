<?php

/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

class TableCategory extends MysqlTable
{
	function __construct(&$database)
	{
		parent::__construct($database, 'category');
	}

	function createLogicObject()
	{
		return new Category();
	}

	/**
	 * @return Category
	 */
	function getRecordById($id)
	{
		$ret = new Category();
		$q = "select * from `{$this->name}`
			where id = '" . $this->db->escape($id) . "' ";
		$res = $this->db->query($q);
		if($row = $this->db->fetch_array($res))
			$ret->copyFromArray($row);
		$res->free();
		return $ret;
	}

	/**
	 * @return Category
	 */
	function getCategoryByTitle($title, $id_parent)
	{
		$ret = new Category();
		$q = "select * from `{$this->name}`
			where title = '" . $this->db->escape($title) . "'
			and id_parent = '" . $this->db->escape($id_parent) . "' ";
		$res = $this->db->query($q);
		if($row = $this->db->fetch_array($res))
			$ret->copyFromArray($row);
		$res->free();
		return $ret;
	}

	/**
	 * @return Category
	 */
	function getCategoryByPos($pos, $id_parent)
	{
		$ret = new Category();
		$q = "select * from `{$this->name}`
			where pos = '" . $this->db->escape($pos) . "'
			and id_parent = '" . $this->db->escape($id_parent) . "' ";
		$res = $this->db->query($q);
		if($row = $this->db->fetch_array($res))
			$ret->copyFromArray($res);
		$res->free();
		return $ret;
	}

	function categoryExists($id)
	{
		$q = "select count(*) as total from `{$this->name}`
			where id = '" . $this->db->escape($id) . "' ";
		$res = $this->db->query($q);
		$row = $this->db->fetch_array($res);
		$res->free();
		return (intval(@$row["total"]) > 0);
	}

	function getChildCategories($id, $orderBy = "pos", $orderDirection = "asc", $onlyActive = false)
	{
		$fs = $this->getFields();
		if(!in_array($orderBy, $fs))
			$orderBy = "pos";
		if(!in_array($orderDirection, array("asc", "desc")))
			$orderDirection = "asc";

		$where = ($onlyActive) ? "and active = '1' " : "";

		$ret = array();
		$q = "select * from `{$this->name}`
			where id_parent = '" . $this->db->escape($id) . "'
			$where
			order by $orderBy $orderDirection ";
		$res = $this->db->query($q);
		while($row = $this->db->fetch_array($res))
		{
			$c = new Category();
			$c->copyFromArray($row);
			$ret[] = $c;
		}
		$res->free();
		return $ret;
	}

	function getChildrenCount($id)
	{
		$q = "select count(*) as total from `{$this->name}`
			where id_parent = '" . $this->db->escape($id) . "' ";
		$res = $this->db->query($q);
		$row = $this->db->fetch_array($res);
		$res->free();
		return intval(@$row["total"]);
	}

	function getAllChildIds($id_category)
	{
		$ret = array();
		$q = "select id from `{$this->name}`
			where id_parent = '" . $this->db->escape($id_category) . "' ";
		$res = $this->db->query($q);
		while($row = $this->db->fetch_array($res))
		{
			$ret[] = $row["id"];
			$temp = $this->getAllChildIds($row["id"]);
			$ret = array_merge($ret, $temp);
		}
		$res->free();
		return $ret;
	}

	function getBreadcrumb($id)
	{
		$ret = array();
		$q = "select * from `{$this->name}`
			where id = '" . $this->db->escape($id) . "' ";
		$res = $this->db->query($q);
		if($row = $this->db->fetch_array($res))
		{
			$c = new Category();
			$c->copyFromArray($row);
			if(intval($row["id_parent"]) > 0)
				$ret = $this->getBreadcrumb($row["id_parent"]);
			$ret[] = $c;
		}
		$res->free();
		return $ret;
	}
	
	function getTree($onlyActive = true)
	{
		$ret = array();
		$q = "select * from `{$this->name}` ";
		if($onlyActive)
			$q .= "where active = 1 ";
		$q .= "order by pos ";
		$res = $this->db->query($q);
		$arr = array();
		while($row = $this->db->fetch_array($res)) {
			$c = new Category();
			$c->copyFromArray($row);
			$arr[] = $c;
		}
		$res->free();
		
		$ret = $this->getChildrenFromArr($arr, 0);
		return $ret;
	}
	
	function getChildrenFromArr($arr, $id_parent)
	{
		$ret = array();
		$j = 0;
		for($i = 0; $i < count($arr); $i++) {
			if($arr[$i]->id_parent == $id_parent) {
				$ret[$j]['item'] = $arr[$i];
				$ret[$j]['children'] = $this->getChildrenFromArr($arr, $arr[$i]->id);
				$j++;
			}
		}
		return $ret;
	}

	function getMaxPos($id_parent)
	{
		$q = "select max(pos) as max_pos from `{$this->name}`
			where id_parent = '" . $this->db->escape($id_parent) . "' ";
		$res = $this->db->query($q);
		$row = $this->db->fetch_array($res);
		$res->free();
		return intval(@$row["max_pos"]);
	}

	/**
	 * extract old position from the stack of positions:
	 */
	function removePosition($pos, $id_parent)
	{
		$q = "update `{$this->name}` set pos = pos - 1
			where pos >= '" . $this->db->escape($pos) . "'
			and id_parent = '" . $this->db->escape($id_parent) . "' ";
		$this->db->query($q);
	}

	// make room in the stack of positions for this category:
	function insertPosition($pos, $id_parent)
	{
		$q = "update `{$this->name}` set pos = pos + 1
			where pos >= '" . $this->db->escape($pos) . "'
			and id_parent = '" . $this->db->escape($id_parent) . "' ";
		$this->db->query($q);
	}

	/**
	 * @param Category $c
	 */
	function save(&$c)
	{
		$max_pos = $this->getMaxPos($c->id_parent);
		$parentCategory = $this->getRecordById($c->id_parent);
		$c->nest_level = $parentCategory->nest_level + 1;

		if($c->id > 0)
		{
			$oldRecord = $this->getRecordById($c->id);
			if($oldRecord->pos != $c->pos || $oldRecord->id_parent != $c->id_parent)
			{
				$this->removePosition($oldRecord->pos, $oldRecord->id_parent);
				$this->insertPosition($c->pos, $c->id_parent);
			}
			parent::updateObj($c);
		}
		else
		{
			$this->insertPosition($c->pos, $c->id_parent);
			parent::insertObj($c);
			$c->id = $this->db->lastInsertId();
		}
	}

	/**
	 * @param Category $c
	 */
	function deleteObj($c)
	{
		$children = $this->getChildCategories($c->id);
		for($i = 0; $i < count($children); $i++)
			$this->deleteObj($children[$i]);
		$this->removePosition($c->pos, $c->id_parent);
		$c->removeImages();
		$this->db->tbProduct->deleteByCategoryId($c->id);
		parent::deleteObj($c);
	}

}

?>