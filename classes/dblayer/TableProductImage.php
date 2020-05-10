<?php

/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

class TableProductImage extends MysqlTable
{
	function __construct(&$database)
	{
		parent::__construct($database, 'product_image');
	}

	function createLogicObject()
	{
		return new ProductImage();
	}
	
	/**
	 * @return ProductImage
	 */
	function getRecordById($id)
	{
		$ret = new ProductImage();
		$q = "select * from `{$this->name}` 
			where id = '" . $this->db->escape($id) . "' ";
		$res = $this->db->query($q);
		if($row = $this->db->fetch_array($res))
			$ret->copyFromArray($row);
		$res->free();
		return $ret;
	}
	
	function getImageByPos($id_product, $pos) {
		$ret = new ProductImage();
		$q = "select * from `{$this->name}`
			where id_product = '" . intval($id_product) . "'
			and pos = '" . intval($pos) . "' ";
		$res = $this->db->query($q);
		if($row = $this->db->fetch_array($res))
			$ret->copyFromArray($row);
		$res->free();
		return $ret;
	}

	function getImagesByProductId($id_product)
	{
		$q = "select * from `{$this->name}` 
			where id_product = '" . $this->db->escape($id_product) . "' 
			order by pos ";
		$res = $this->db->query($q);
		$ret = array();
		while($row = $res->fetch_array()) {
			$pi = new ProductImage();
			$pi->copyFromArray($row);
			$ret[] = $pi;
		}
		$res->free();
		return $ret;
	}

	function getMaxPos($id_product)
	{
		$q = "select max(pos) as max_pos from `{$this->name}`
			where id_product = '" . $this->db->escape($id_product) . "' ";
		$res = $this->db->query($q);
		$row = $this->db->fetch_array($res);
		$res->free();
		return intval(@$row["max_pos"]);
	}

	/**
	 * extract old position from the stack of positions:
	 */
	function removePosition($pos, $id_product)
	{
		$q = "update `{$this->name}` set pos = pos - 1
			where pos >= '" . $this->db->escape($pos) . "'
			and id_product = '" . $this->db->escape($id_product) . "' ";
		$this->db->query($q);
	}

	// make room in the stack of positions for this product image:
	function insertPosition($pos, $id_product)
	{
		$q = "update `{$this->name}` set pos = pos + 1
			where pos >= '" . $this->db->escape($pos) . "'
			and id_product = '" . $this->db->escape($id_product) . "' ";
		$this->db->query($q);
	}

	function insertObj($pi)
	{
		$pi->pos = $this->getMaxPos($pi->id_product) + 1;
		parent::insertObj($pi);
		$pi->id = $this->db->lastInsertId();
		if($pi->pos == 1)
			$this->db->tbProduct->updatePicture($pi->id_product, $pi->filename);
	}
	
	function updateObj($pi)
	{
		$oldRecord = $this->getRecordById($pi->id);
		if($oldRecord->pos != $pi->pos)
		{
			$this->removePosition($oldRecord->pos, $oldRecord->id_product);
			$this->insertPosition($pi->pos, $pi->id_product);
		}
		parent::updateObj($pi);
		
		if($pi->pos == 1) {
			$this->db->tbProduct->updatePicture($pi->id_product, $pi->filename);
		}
		elseif($pi->pos == 2) {
			$pi1 = $this->getImageByPos($pi->id_product, 1);
			$this->db->tbProduct->updatePicture($pi1->id_product, $pi1->filename);
		}
	}
	
	function deleteObj($pi) {
		$this->removePosition($pi->pos, $pi->id_product);
		parent::deleteObj($pi);
	}
	
}

?>