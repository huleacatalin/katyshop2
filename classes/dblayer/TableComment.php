<?php

/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

class TableComment extends MysqlTable
{
	function __construct(&$database)
	{
		parent::__construct($database, 'comments');
	}

	function createLogicObject()
	{
		return new Comment();
	}
	
	function getCommentsByProductId($id_product) {
		$ret = array();
		$q = "select c.*, u.username from {$this->name} c left join {$this->db->tbUser->name} u 
			on c.id_user = u.id
			where c.id_product = '" . $this->db->escape($id_product) . "' 
			order by c.date_created desc ";
		$res = $this->db->query($q);
		while($row = $this->db->fetch_array($res)) {
			$c = new Comment;
			$c->copyFromArray($row);
			$ret[] = $c;
		}
		return $ret;
	}
	
	function deleteById($id) {
		$q = "delete from {$this->name} where id = '" . $this->db->escape($id) . "' ";
		$this->db->query($q);
	}
	
	function deleteByProductId($id_product) {
		$q = "delete from {$this->name} where id_product = '" . $this->db->escape($id_product) . "' ";
		$this->db->query($q);
	}
}

?>