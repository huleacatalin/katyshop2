<?php

/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

class TableAddress extends MysqlTable
{
	function __construct(&$database)
	{
		parent::__construct($database, 'address');
	}

	function createLogicObject()
	{
		return new Address();
	}

	function getStrictFields()
	{
		return array("id", "id_user", "delivery", "invoicing", "primary_addr");
	}

	/**
	 * @return Address
	 */
	function getRecordById($id)
	{
		$ret = new Address();
		$q = "select * from `{$this->name}`
			where id = '" . $this->db->escape($id) . "' ";
		$res = $this->db->query($q);
		if($row = $this->db->fetch_array($res))
			$ret->copyFromArray($row);
		$res->free();
		$ret->decrypt();
		return $ret;
	}

	function getRecordsByUserId($id_user, $condition = "")
	{
		$where = "";
		switch ($condition)
		{
			case "primary_addr":
				$where = "and primary_addr = '1' ";
				break;
			case "delivery":
				$where = "and delivery = '1' ";
				break;
			case "invoicing":
				$where = "and invoicing = '1' ";
				break;
		}
		$ret = array();
		$q = "select * from `{$this->name}`
			where id_user = '" . $this->db->escape($id_user) . "'
			$where
			order by primary_addr desc ";
		$res = $this->db->query($q);
		while($row = $this->db->fetch_array($res))
		{
			$a = new Address();
			$a->copyFromArray($row);
			$a->decrypt();
			$ret[] = $a;
		}
		$res->free();
		return $ret;
	}

	/**
	 * @param Address $a
	 */
	function save($a)
	{
		if($a->primary_addr == 1)
		{
			$q = "update `{$this->name}` set primary_addr = '0'
				where id_user = '" . $this->db->escape($a->id_user) . "' ";
			$this->db->query($q);
		}

		$a->encrypt();
		if($a->id > 0)
			parent::updateObj($a);
		else
			parent::insertObj($a);
		$a->decrypt();
	}

	function deleteByUserId($id_user)
	{
		$q = "delete from `{$this->name}`
			where id_user = '" . $this->db->escape($id_user) . "' ";
		$this->db->query($q);
	}

}

?>