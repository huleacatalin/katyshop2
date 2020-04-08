<?php

/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

class TableProduct extends MysqlTable
{
	function __construct(&$database)
	{
		parent::__construct($database, 'product');
	}

	function createLogicObject()
	{
		return new Product();
	}

	function getStrictFields()
	{
		return array("id", "id_category", "pos", "active");
	}

	/**
	 * @return Product
	 */
	function getRecordById($id)
	{
		$ret = new Product();
		$q = "select p.*, m.title as manufacturer from {$this->name} p
			left join {$this->db->tbManufacturer->name} m on p.id_manufacturer = m.id
			where p.id = '" . $this->db->escape($id) . "' ";
		$res = $this->db->query($q);
		if($row = $this->db->fetch_array($res))
			$ret->copyFromArray($row);
		$res->free();
		
		$ret->getImagesFromDb();
		return $ret;
	}

	/**
	 * @return Product
	 */
	function getProductByTitle($title, $id_category)
	{
		$ret = new Product();
		$q = "select p.*, m.title as manufacturer from {$this->name} p
			left join {$this->db->tbManufacturer->name} m on p.id_manufacturer = m.id
			where p.title = '" . $this->db->escape($title) . "'
			and p.id_category = '" . $this->db->escape($id_category) . "' ";
		$res = $this->db->query($q);
		if($row = $this->db->fetch_array($res))
			$ret->copyFromArray($row);
		$res->free();
		
		$ret->getImagesFromDb();
		return $ret;
	}

	/**
	 * @return Product
	 */
	function getProductByPos($pos, $id_category)
	{
		$ret = new Product();
		$q = "select p.*, m.title as manufacturer from {$this->name} p
			left join {$this->db->tbManufacturer->name} m on p.id_manufacturer = m.id
			where p.pos = '" . $this->db->escape($pos) . "'
			and id_category = '" . $this->db->escape($id_category) . "' ";
		$res = $this->db->query($q);
		if($row = $this->db->fetch_array($res))
			$ret->copyFromArray($row);
		$res->free();
		$ret->getImagesFromDb();
		return $ret;
	}

	function productExists($id)
	{
		$q = "select count(*) as total from {$this->name}
			where id = '" . $this->db->escape($id) . "' ";
		$res = $this->db->query($q);
		$row = $this->db->fetch_array($res);
		$res->free();
		return (intval(@$row["total"]) > 0);
	}

	function getMaxPos($id_category)
	{
		$q = "select max(pos) as max_pos from {$this->name}
			where id_category = '" . $this->db->escape($id_category) . "' ";
		$res = $this->db->query($q);
		$row = $this->db->fetch_array($res);
		$res->free();
		return intval(@$row["max_pos"]);
	}

	/**
	 * extract old position from the stack of positions:
	 */
	function removePosition($pos, $id_category)
	{
		$q = "update {$this->name} set pos = pos - 1
			where pos >= '" . $this->db->escape($pos) . "'
			and id_category = '" . $this->db->escape($id_category) . "' ";
		$this->db->query($q);
	}

	// make room in the stack of positions for this product:
	function insertPosition($pos, $id_category)
	{
		$q = "update {$this->name} set pos = pos + 1
			where pos >= '" . $this->db->escape($pos) . "'
			and id_category = '" . $this->db->escape($id_category) . "' ";
		$this->db->query($q);
	}

	function composeIdCategoryCondition($id_category)
	{
		$ids = $this->db->tbCategory->getAllChildIds($id_category);
		$q = "and id_category in ('" . $this->db->escape($id_category) . "' ";
		for($i = 0; $i < count($ids); $i++)
		{
			$q .= ", '" . $this->db->escape($ids[$i]) . "'";
		}
		$q .= ")";
		return $q;
	}

	function composeKeywordsCondition($s)
	{
		$arr = Tools::parseSearchString($s);
		$exact = $arr["exact"];
		$aproximate = $arr["aproximate"];
		$fields = array("p.title", "p.description", "p.content", "p.technical_details");

		$q = "";
		for($i = 0; $i < 10 && $i < count($aproximate); $i++)
		{
			$word = $this->db->escape($aproximate[$i]);
			$q .= "and (";
			for($j = 0; $j < count($fields); $j++)
			{
				if($j > 0)
					$q .= "or ";
				$q .= "{$fields[$j]} like '%$word%' ";
			}
			$q .= ") ";
		}

		for($i = 0; $i < 10 && $i < count($exact); $i++)
		{
			$word = $this->db->escape($exact[$i]);
			$q .= "and (";
			for($j = 0; $j < count($fields); $j++)
			{
				if($j > 0)
					$q .= "or ";
				$q .= "{$fields[$j]} like '%$word%' ";
			}
			$q .= ") ";
		}

		return $q;
	}

	function advancedSearch($criteria, $start, $rowsPerPage, $orderBy, $orderDirection)
	{
		if(empty($this->fields))
			$this->readTableInfo();

		$start = intval($start);
		$rowsPerPage = intval($rowsPerPage);
		if($rowsPerPage < 1)
			$rowsPerPage = 25;
		$start = intval($start);
		if(!in_array($orderDirection, array("asc", "desc")))
			$orderDirection = "asc";
		$strictFields = $this->getStrictFields();

		$ret = array();
		$q = "select p.*, m.title as manufacturer, c.nest_level, c.pos from {$this->name} p
			left join {$this->db->tbManufacturer->name} m on p.id_manufacturer = m.id
			left join {$this->db->tbCategory->name} c on p.id_category = c.id
			where 1 = 1 ";
		if(!empty($criteria["title"]))
			$q .= "and p.title like '%" . $this->db->escape(@$criteria["title"]) . "%' ";
		if(floatval(@$criteria["min_price"]) > 0)
			$q .= "and p.price >= '" . $this->db->escape($criteria["min_price"]) . "' ";
		if(floatval(@$criteria["max_price"]) > 0)
			$q .= "and p.price <= '" . $this->db->escape($criteria["max_price"]) . "' ";
		if(!empty($criteria["measuring_unit"]))
			$q .= "and p.measuring_unit = '" . $this->db->escape($criteria["measuring_unit"]) . "' ";
		if(!empty($criteria["description"]))
			$q .= "and p.description like '%" . $this->db->escape($criteria["description"]) . "%' ";
		if(!empty($criteria["content"]))
			$q .= "and p.content like '%" . $this->db->escape($criteria["content"]) . "%' ";
		if(intval(@$criteria["id_manufacturer"]) > 0)
			$q .= "and p.id_manufacturer = '" . $this->db->escape($criteria["id_manufacturer"]) . "' ";
		if(intval(@$criteria["id_category"]) > 0 && @$criteria["only_current_category"] == "1")
			$q .= $this->composeIdCategoryCondition($criteria["id_category"]);
		if(intval(@$criteria["active"]) == 1)
			$q .= "and p.active = '1' ";
		if(!empty($criteria["keywords"]))
			$q .= $this->composeKeywordsCondition($criteria["keywords"]);

		if(in_array($orderBy, $this->fields))
		{
			if($orderBy == "pos")
				$q .= "order by c.nest_level $orderDirection, c.pos $orderDirection, p.pos $orderDirection ";
			else
				$q .= "order by p.$orderBy $orderDirection ";
		}
		$q .= "limit $start, $rowsPerPage ";

		$res = $this->db->query($q);
		while($row = $this->db->fetch_array($res))
		{
			$o = $this->createLogicObject();
			$o->copyFromArray($row);
			$ret[] = $o;
		}
		$res->free();
		return $ret;
	}

	function advancedGetCount($criteria, $start, $rowsPerPage, $orderBy, $orderDirection)
	{
		if(empty($this->fields))
			$this->readTableInfo();

		$start = intval($start);
		$rowsPerPage = intval($rowsPerPage);
		if($rowsPerPage < 1)
			$rowsPerPage = 25;
		$start = intval($start);
		if(!in_array($orderDirection, array("asc", "desc")))
			$orderDirection = "asc";
		$strictFields = $this->getStrictFields();

		$ret = array();
		$q = "select count(*) as total from {$this->name} p
			left join {$this->db->tbManufacturer->name} m on p.id_manufacturer = m.id
			left join {$this->db->tbCategory->name} c on p.id_category = c.id
			where 1 = 1 ";
		if(!empty($criteria["title"]))
			$q .= "and p.title like '%" . $this->db->escape(@$criteria["title"]) . "%' ";
		if(floatval(@$criteria["min_price"]) > 0)
			$q .= "and p.price >= '" . $this->db->escape($criteria["min_price"]) . "' ";
		if(floatval(@$criteria["max_price"]) > 0)
			$q .= "and p.price <= '" . $this->db->escape($criteria["max_price"]) . "' ";
		if(!empty($criteria["measuring_unit"]))
			$q .= "and p.measuring_unit = '" . $criteria["measuring_unit"] . "' ";
		if(!empty($criteria["description"]))
			$q .= "and p.description like '%" . $criteria["description"] . "%' ";
		if(!empty($criteria["content"]))
			$q .= "and p.content like '%" . $criteria["content"] . "%' ";
		if(intval(@$criteria["id_manufacturer"]) > 0)
			$q .= "and p.id_manufacturer = '" . $this->db->escape($criteria["id_manufacturer"]) . "' ";
		if(intval(@$criteria["id_category"]) > 0 && @$criteria["only_current_category"] == "1")
			$q .= $this->composeIdCategoryCondition($criteria["id_category"]);
		if(intval(@$criteria["active"]) == 1)
			$q .= "and p.active = '1' ";
		if(!empty($criteria["keywords"]))
			$q .= $this->composeKeywordsCondition($criteria["keywords"]);

		$res = $this->db->query($q);
		$row = $this->db->fetch_array($res);
		$res->free();
		return intval(@$row["total"]);
	}

	/**
	 * @param Product $p
	 */
	function save(&$p)
	{
		$max_pos = $this->getMaxPos($p->id_category);

		if($p->id > 0)
		{
			$oldRecord = $this->getRecordById($p->id);
			if($oldRecord->pos != $p->pos || $oldRecord->id_category != $p->id_category)
			{
				$this->removePosition($oldRecord->pos, $oldRecord->id_category);
				$this->insertPosition($p->pos, $p->id_category);
			}
			parent::updateObj($p);
		}
		else
		{
			$this->insertPosition($p->pos, $p->id_category);
			parent::insertObj($p);
			$p->id = $this->db->lastInsertId();
		}
	}
	
	function updatePicture($id_product, $picture)
	{
		$q = "update {$this->name} set picture = '" . $this->db->escape($picture) . "'
			where id = '" . intval($id_product) . "' ";
		$this->db->query($q);
	}

	/**
	 * @param Product $p
	 */
	function deleteObj($p)
	{
		$this->removePosition($p->pos, $p->id_category);
		$p->removeImages();
		$this->db->tbComment->deleteByProductId($p->id);
		parent::deleteObj($p);
	}

	function deleteByCategoryId($id_category)
	{
		$q = "select * from {$this->name}
			where id_category = '" . $id_category . "' ";
		$res = $this->db->query($q);
		while($row = $this->db->fetch_array($res))
		{
			$p = new Product();
			$p->copyFromArray($row);
			$this->deleteObj($p);
		}
		$res->free();
	}

}

?>