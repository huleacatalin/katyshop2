<?php

/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

class TableUserCompany extends MysqlTable
{

	function __construct(&$database)
	{
		parent::__construct($database, 'user_company');
	}

	function createLogicObject()
	{
		return new UserCompany();
	}

	function getRecordById($id)
	{
		$ret = new UserCompany();
		$q = "select * from {$this->name} uc
			left join {$this->db->tbUserPerson->name} up on uc.id = up.id
			left join {$this->db->tbUser->name} u on up.id = u.id
			where up.id = '" . $this->db->escape($id) . "' ";
		$res = $this->db->query($q);
		if($row = $this->db->fetch_array($res))
			$ret->copyFromArray($row);
		$res->free();
		$ret->decrypt();
		return $ret;
	}

}
?>