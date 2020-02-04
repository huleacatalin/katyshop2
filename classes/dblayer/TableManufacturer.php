<?php

/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

class TableManufacturer extends MysqlTable
{

	function __construct(&$database)
	{
		parent::__construct($database, 'manufacturer');
	}

	function createLogicObject()
	{
		return new Manufacturer();
	}

	function getStrictFields()
	{
		parent::getStrictFields();
		return array("id");
	}

	/**
	 * @return Manufacturer
	 */
	function getManufacturerById($id)
	{
		$arr = array("id" => $id);
		return parent::getRecordByPks($arr);
	}

	/**
	 * @return Manufacturer
	 */
	function getManufacturerByTitle($title)
	{
		$ret = new Manufacturer();
		$q = "select * from {$this->name}
			where title = '" . $this->db->escape($title) . "' ";
		$res = $this->db->query($q);
		if($row = $this->db->fetch_array($res))
			$ret->copyFromArray($row);
		$res->free();
		return $ret;
	}

	function idExists($id)
	{
		$q = "select count(*) as total from {$this->name}
			where id = '" . $this->db->escape($id) . "' ";
		$res = $this->db->query($q);
		$row = $this->db->fetch_array($res);
		$res->free();
		return (intval($row["total"]) > 0);
	}

	function titleExists($title)
	{
		$q = "select count(*) as total from {$this->name}
			where id = '" . $this->db->escape($title) . "' ";
		$res = $this->db->query($q);
		$row = $this->db->fetch_array($res);
		$res->free();
		return (intval($row["total"]) > 0);
	}

	/**
	 * @param Manufacturer $m
	 */
	function save(&$m)
	{
		if($m->id == 0)
		{
			$this->insertObj($m);
			$m->id = $this->db->lastInsertId();
			return $m->id;
		}
		else
		{
			$this->updateObj($m);
			return $m->id;
		}
	}


}

?>