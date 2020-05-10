<?php

/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

class TableAdmin extends MysqlTable
{

	function __construct(&$database)
	{
		parent::__construct($database, '_admins');
	}

	function createLogicObject()
	{
		return new Admin();
	}

	function getRecordById($id)
	{
		$ret = new Admin();
		$q = "select * from `{$this->name}` a
			left join `{$this->db->tbUser->name}` u on a.id_admin = u.id
			where a.id_admin = '" . $this->db->escape($id) . "' ";

		$res = $this->db->query($q);
		if($row = $this->db->fetch_array($res))
			$ret->copyFromArray($row);
		$res->free();
		$ret->decrypt();
		return $ret;
	}

}
?>