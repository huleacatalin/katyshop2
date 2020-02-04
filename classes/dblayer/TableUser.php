<?php

/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

class TableUser extends MysqlTable
{

	function __construct(&$database)
	{
		parent::__construct($database, 'user');
	}

	function createLogicObject()
	{
		return new User();
	}

	/**
	 * @return User
	 */
	function getUserById($id)
	{
		$ret = new User();
		$q = "select * from {$this->name}
			where id = '" . $this->db->escape($id) . "' ";
		$res = $this->db->query($q);
		if($row = $this->db->fetch_array($res))
			$ret->copyFromArray($row);
		$res->free();

		$ret->decrypt();
		return $ret;
	}

	/**
	 * @return User
	 */
	function getUserByUsername($username)
	{
		$ret = new User();
		$q = "select * from {$this->name}
			where username = '" . $this->db->escape($username) . "' ";
		$res = $this->db->query($q);
		if($row = $this->db->fetch_array($res))
			$ret->copyFromArray($row);
		$res->free();
		$ret->decrypt();
		return $ret;
	}

	function usernameExists($username)
	{
		$q = "select count(*) as total from {$this->name}
			where username = '" . $this->db->escape($username) . "' ";
		$res = $this->db->query($q);
		$row = $this->db->fetch_array($res);
		$res->free();
		return (intval(@$row["total"]) > 0);
	}

	function idExists($id)
	{
		$q = "select count(*) as total from {$this->name}
			where id = '" . $this->db->escape($id) . "' ";
		$res = $this->db->query($q);
		$row = $this->db->fetch_array($res);
		$res->free();
		return (intval(@$row["total"]) > 0);
	}

	function emailExists($email)
	{
		$q = "select count(*) as total from {$this->name}
			where email = '" . $this->db->escape($email) . "' ";
		$res = $this->db->query($q);
		$row = $this->db->fetch_array($res);
		$res->free();
		return (intval(@$row["total"]) > 0);
	}

	function setLoginCode($id_user, $login_code)
	{
		$q = "update {$this->name} set login_code = '" . $this->db->escape($login_code) . "'
			where id = '" . $this->db->escape($id_user) . "' ";
		$this->db->query($q);
	}

	function activate($id_user)
	{
		$q = "update {$this->name} set active = '1',
			activation_code = ''
			where id = '" . $this->db->escape($id_user) . "' ";
		$this->db->query($q);
	}

	function deactivate($id_user)
	{
		$q = "update {$this->name} set active = '0' ,
			activation_code = ''
			where id = '" . $this->db->escape($id_user) . "' ";
		$this->db->query($q);
	}

	/**
	 * @param User $user
	 */
	function insertObj($user)
	{
		$user->encrypt();
		parent::insertObj($user);
		$user->id = $this->db->lastInsertId();
		if(is_a($user, "UserPerson"))
			$this->db->tbUserPerson->insertObj($user);
		if (is_a($user, "UserCompany"))
			$this->db->tbUserCompany->insertObj($user);
		if(is_a($user, "Admin"))
		{
			$user->id_admin = $user->id;
			$this->db->tbAdmin->insertObj($user);
		}
		$user->decrypt();
	}

	/**
	 * @param User $user
	 */
	function updateObj($user)
	{
		$user->encrypt();
		parent::updateObj($user);
		if(is_a($user, "UserPerson"))
			$this->db->tbUserPerson->updateObj($user);
		if (is_a($user, "UserCompany"))
			$this->db->tbUserCompany->updateObj($user);
		if(is_a($user, "Admin"))
			$this->db->tbAdmin->updateObj($user);
		$user->decrypt();
	}

	/**
	 * @param User $user
	 */
	function deleteObj($user)
	{
		if(is_a($user, "UserPerson"))
			$this->db->tbUserPerson->deleteObj($user);
		if (is_a($user, "UserCompany"))
			$this->db->tbUserCompany->deleteObj($user);
		if(is_a($user, "Admin"))
			$this->db->tbAdmin->deleteObj($user);

		$this->db->tbAddress->deleteByUserId($user->id);
		parent::deleteObj($user);
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