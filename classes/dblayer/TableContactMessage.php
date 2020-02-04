<?php

/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

class TableContactMessage extends MysqlTable
{
	function __construct(&$database)
	{
		parent::__construct($database, 'contact_message');
	}

	function createLogicObject()
	{
		return new ContactMessage();
	}

	function getStrictFields()
	{
		return array("id", "id_user");
	}

	/**
	 * @return ContactMessage
	 */
	function getRecordById($id)
	{
		$ret = new ContactMessage();
		$q = "select * from {$this->name}
			where id = '" . $this->db->escape($id) . "' ";
		$res = $this->db->query($q);
		if($row = $this->db->fetch_array($res))
			$ret->copyFromArray($row);
		$res->free();
		$ret->decrypt();
		return $ret;
	}

	function messageExists($id)
	{
		$q = "select count(*) as total from {$this->name}
			where id = '" . $this->db->escape($id) . "' ";
		$res = $this->db->query($q);
		$row = $this->db->fetch_array($res);
		$res->free();
		return (intval(@$row["total"]) > 0);
	}
	
	function insertObj($m)
	{
		$m->encrypt();
		return parent::insertObj($m);
		$m->decrypt();
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