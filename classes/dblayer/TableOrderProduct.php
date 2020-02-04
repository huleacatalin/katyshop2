<?php

/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

class TableOrderProduct extends MysqlTable
{
	function __construct(&$database)
	{
		parent::__construct($database, 'order_product');
	}

	function createLogicObject()
	{
		return new OrderProduct();
	}

	function getStrictFields()
	{
		parent::getStrictFields();
		return array("id_order", "line_number", "id_product", "price", "quantity",
					"measuring_unit", "total");
	}

	function getRecordsByOrderId($id_order)
	{
		$ret = array();
		$q = "select * from {$this->name}
			where id_order = '" . $this->db->escape($id_order) . "'
			order by line_number";
		$res = $this->db->query($q);
		while($row = $this->db->fetch_array($res))
		{
			$op = new OrderProduct();
			$op->copyFromArray($row);
			$op->decrypt();
			$ret[] = $op;
		}
		$res->free();
		return $ret;
	}

	/**
	 * @return OrderProduct
	 */
	 /*
	function getRecordByPks($id_order, $line_number)
	{
		$ret = new OrderProduct();
		$q = "select * from {$this->name}
			where id_order = '" . $this->db->escape($id_order) . "'
			and line_number = '" . $this->db->escape($line_number) . "' ";
		$res = $this->db->query($q);
		if($row = $this->db->fetch_array($res))
			$ret->copyFromArray($row);
		return $ret;
	}
	*/

	function orderProductExists($id_order, $line_number)
	{
		$q = "select count(*) as total from {$this->name}
			where id_order = '" . $this->db->escape($id_order) . "'
			and line_number = '" . $this->db->escape($line_number) . "' ";
		$res = $this->db->query($q);
		$row = $this->db->fetch_array($res);
		$res->free();
		return (intval(@$row["total"]) > 0);
	}

	function insertObj($op) {
		$op->encrypt();
		parent::insertObj($op);
		$op->decrypt();
	}

}

?>