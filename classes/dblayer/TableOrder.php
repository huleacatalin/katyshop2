<?php

/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

class TableOrder extends MysqlTable
{
	function __construct(&$database)
	{
		parent::__construct($database, '_orders');
	}

	function createLogicObject()
	{
		return new Order();
	}

	function getStrictFields()
	{
		parent::getStrictFields();
		return array("id", "id_user", "total", "measuring_unit");
	}

	/**
	 * @return Order
	 */
	function getRecordById($id)
	{
		$ret = new Order();
		$q = "select * from {$this->name}
			where id = '" . $this->db->escape($id) . "' ";
		$res = $this->db->query($q);
		if($row = $this->db->fetch_array($res))
			$ret->copyFromArray($row);
		$res->free();
		$ret->decrypt();

		$ret->orderProducts = $this->db->tbOrderProduct->getRecordsByOrderId($ret->id);

		return $ret;
	}

	/**
	 * @return Order
	 */
	function getRecordByCode($code)
	{
		$ret = new Order();
		$q = "select * from {$this->name}
			where code = '" . $this->db->escape($code) . "' ";
		$res = $this->db->query($q);
		if($row = $this->db->fetch_array($res))
			$ret->copyFromArray($row);
		$res->free();
		$ret->decrypt();

		$ret->orderProducts = $this->db->tbOrderProduct->getRecordsByOrderId($ret->id);

		return $ret;
	}

	function orderExists($id)
	{
		$q = "select count(*) as total from {$this->name}
			where id = '" . $this->db->escape($id) . "' ";
		$res = $this->db->query($q);
		$row = $this->db->fetch_array($res);
		$res->free();
		return (intval(@$row["total"]) > 0);
	}

	function changeStatus($id_order, $newStatus)
	{
		$q = "update {$this->name}
			set status = '" . $this->db->escape($newStatus) . "'
			where id = '" . $this->db->escape($id_order) . "' ";
		$this->db->query($q);
	}

	/**
	 * @param Order $o
	 * @return int id of the order
	 */
	 // function insertObj(&$o)
	function insertObj($o)
	{
		$o->computeValue();
		$o->status = "sent";
		$o->encrypt();
		parent::insertObj($o);
		$o->id = $this->db->lastInsertId();
		$o->generateCode();
		parent::updateObj($o);
		$o->setProductsIds();

		for($i = 0; $i < $o->getProductsCount(); $i++)
		{
			$op = $o->getOrderProduct($i + 1);
			$this->db->tbOrderProduct->insertObj($op);
		}

		$o->decrypt();
		$o->generateProforma();

		return $o->id;
	}

	function search($criteria = array(), $start = 0, $rowsPerPage = 25, $orderBy = "", $orderDirection = "asc")
	{
		$list = parent::search($criteria, $start, $rowsPerPage, $orderBy, $orderDirection);
		for($i = 0; $i < count($list); $i++)
			$list[$i]->decrypt();
		return $list;
	}

}

?>