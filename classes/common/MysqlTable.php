<?php

/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(__FILE__) . "/BaseObject.php");

// A table from a database
class MysqlTable extends BaseObject
{
	var $name;

	/**
	 * @var Database
	 */
	var $db;

	var $fields = array();
	var $primaryKeys = array();
	var $insertFields = array();
	var $updateFields = array();
	var $autoincrementFields = array();

	/**
	 * Constructor. Class MysqlTable, a table from a database.
	 *
	 * @param MysqlDatabase $database
	 * @param string $tableName
	 * @return MysqlTable
	 */
	function __construct(&$database, $tableName)
	{
		$this->db = &$database;
		$this->name = $tableName;
	}

	#####################################
	# AUTOMATIC FIELDS AND KEYS			#
	#####################################

	/**
	 * All classes inherited from MysqlTable must implement this method,
	 * that returns an empty object ususally stored in that table.
	 * This method is used by MysqlTable::getRecordByPks() and by MysqlTable::search(),
	 * if you don't implement createLogicObject() you will not be able to use them.
	 * Example:
	 * // Sample function written in TableAddress (extends MysqlTable)
	 * function createLogicObject()
	 * {
	 * 		return new Address();
	 * }
	 *
	 * @return LogicObject
	 */
	function createLogicObject()
	{
		die("MysqlTable::createLogicObject() must be overriden in inherited class");
	}

	/**
	 * Sends a "describe table_name" query in order to find out list of fields from this table,
	 * primary keys, auto increment fields and so on.
	 */
	function readTableInfo()
	{
		$this->fields = array();
		$this->primaryKeys = array();
		$this->insertFields = array();
		$this->updateFields = array();
		$this->autoincrementFields = array();

		$q = "describe {$this->name} ";
		$res = $this->db->query($q);
		while($row = $this->db->fetch_array($res))
		{
			$this->fields[] = $row["Field"];
			if($row["Key"] == "PRI")
			{
				$this->primaryKeys[] = $row["Field"];
				if(strstr($row["Extra"], "auto_increment"))
				{
					// I don't want primary keys with auto_increment
					// to be used in INSERT statements
					$this->autoincrementFields[] = $row["Field"];
				}
				else
				{
					$this->insertFields[] = $row["Field"];
				}
			}
			else
			{
				$this->insertFields[] = $row["Field"];
				$this->updateFields[] = $row["Field"];
			}
		}
		$res->free();
	}

	/**
	 * Get the list of all field names from this table
	 */
	function getFields()
	{
		if(empty($this->fields))
			$this->readTableInfo();
		return $this->fields;
	}

	function getPrimaryKeys()
	{
		if(empty($this->primaryKeys))
			$this->readTableInfo();
		return $this->primaryKeys;
	}

	function getAutoincrementFields()
	{
		if(empty($this->fields))
			$this->readTableInfo();
		return $this->autoincrementFields;
	}

	/**
	 * List of fields used for INSERT statement. If this function is not working fine for you,
	 * please override it in the inherited class.
	 *
	 * Example: table persons with fields id (primary key), first_name, last_name
	 * If id field is auto_increment, getInsertFields() will return array("first_name", "last_name").
	 * If id field is not auto_increment, getInsertFields() will return array("id", "first_name", "last_name").
	 *
	 * The result of this function is used by MysqlTable::insertObj().
	 *
	 * @return unknown
	 */
	function getInsertFields()
	{
		if(empty($this->insertFields))
			$this->readTableInfo();
		return $this->insertFields;
	}

	/**
	 * Return array of all field names except primary keys.
	 * The result of this function is used by updateObj().
	 *
	 * @return unknown
	 */
	function getUpdateFields()
	{
		if(empty($this->updateFields))
			$this->readTableInfo();
		return $this->updateFields;
	}

	/**
	 * Override this in the inherited class.
	 * These fields are used by search() function, to use "=" instead of "like" when
	 * searching a value.
	 *
	 * Example:
	 * function getStrictFields()
	 * {
	 * 		return array("id", "id_company");
	 * }
	 *
	 * If the fields in a sample persons table are: id, id_company, first_name, last_name,
	 * you will usually use "=" to search id and id_company and "like" to search first_name, last_name.
	 *
	 *
	 * @return array
	 */
	function getStrictFields()
	{
		return array();
	}


	#####################################
	# ARRAY PARAMETER FUNCTIONS			#
	#####################################

	/**
	 * I advise you not to use this function directly in program; use insertObj() instead.
	 * Sends a simple INSERT query using this table.
	 *
	 * @param array $assocValues - assoc array: keys are field names,
	 * values are values to insert
	 * @return MysqlResult
	 */
	function insert($assocValues)
	{
		$fieldNames = array_keys($assocValues);

		$q = "INSERT INTO " . $this->name . "(";
		for($i = 0; $i < count($fieldNames); $i++)
		{
			if($i > 0)
				$q .= ", ";
			$q .= $fieldNames[$i];
		}

		$q .= ") VALUES (";
		for($i = 0; $i < count($fieldNames); $i++)
		{
			if($i > 0)
				$q .= ", ";
			$q .= "'" . $this->db->escape($assocValues[$fieldNames[$i]]) . "'";
		}
		$q .= ")";
		return $this->db->query($q);
	}

	/**
	 * I advise you not to use this function directly in program; use updateObj() instead.
	 * Sends a simple UPDATE query to this table
	 *
	 * @param array $assocFields - assoc array, keys are field names to update
	 * @param array $assocKeys - [optional] assoc array, keys are field names for WHERE clause
	 * @return MysqlResult
	 */
	function update($assocFields, $assocKeys = array())
	{
		$fieldNames = array_keys($assocFields);
		$keyNames = array_keys($assocKeys);

		$q = "UPDATE " . $this->name . " SET ";

		for($i = 0; $i < count($fieldNames); $i++)
		{
			if($i > 0)
				$q .= ", ";
			$q .= $fieldNames[$i] . " = ";
			$q .= "'" . $this->db->escape($assocFields[$fieldNames[$i]]) . "'";
		}

		if(count($keyNames) > 0)
			$q .= " WHERE ";

		for($i = 0; $i < count($keyNames); $i++)
		{
			if($i > 0)
				$q .= " AND ";
			$q .= $keyNames[$i] . " = ";
			$q .= "'" . $this->db->escape($assocKeys[$keyNames[$i]]) . "'";
		}
		return $this->db->query($q);
	}

	/**
	 * I advise you not to use this function directly in program; use deleteObj() instead.
	 */
	function delete($assocKeys = array())
	{
		$keyNames = array_keys($assocKeys);

		$q = "DELETE FROM " . $this->name;

		if(count($keyNames) > 0)
			$q .= " WHERE ";

		for($i = 0; $i < count($keyNames); $i++)
		{
			if($i > 0)
				$q .= " AND ";
			$q .= $keyNames[$i] . " = ";
			$q .= "'" . $this->db->escape($assocKeys[$keyNames[$i]]) . "'";
		}

		return $this->db->query($q);
	}


	#####################################
	# OBJECT PARAMETER FUNCTIONS		#
	#####################################

	/**
	 * $object is instance of a class inherited from LogicObject
	 *
	 * @param LogicObject $object
	 */
	function insertObj($object)
	{
		$insertFields = $this->getInsertFields();
		$arr = array();
		for($i = 0; $i < count($insertFields); $i++)
		{
			$key = $insertFields[$i];
			$arr[$key] = $object->$key;
		}
		$this->insert($arr);
	}

	/**
	 * $object is instance of a class inherited from LogicObject
	 *
	 * @param LogicObject $object
	 */
	function updateObj($object)
	{
		$updateFields = $this->getUpdateFields();
		$arr = array();
		for($i = 0; $i < count($updateFields); $i++)
		{
			$key = $updateFields[$i];
			$arr[$key] = $object->$key;
		}
		$primaryKeys = $this->getPrimaryKeys();
		$arr2 = array();
		for($i = 0; $i < count($primaryKeys); $i++)
		{
			$key = $primaryKeys[$i];
			$arr2[$key] = $object->$key;
		}
		$this->update($arr, $arr2);
	}

	/**
	 * $object is instance of a class inherited from LogicObject
	 *
	 * @param LogicObject $object
	 */
	function deleteObj($object)
	{
		$primKeys = $this->getPrimaryKeys();
		$arr = array();
		for($i = 0; $i < count($primKeys); $i++)
		{
			$key = $primKeys[$i];
			$arr[$key] = $object->$key;
		}
		$this->delete($arr);
	}

	/**
	 * Get Record by primary keys
	 * Example:
	 * // overriden in inherited class
	 * // Suppose we have table order_products with primary keys id_order and line_number
	 * function getRecordByPks($id_order, $line_number)
	 * {
	 * 		return parent::getRecordByPks(array("id_order" => $id_order, "line_number" => $line_number));
	 * }
	 *
	 * @param assoc_array $params
	 * @return LogicObject
	 */
	function getRecordByPks($params)
	{
		$ret = $this->createLogicObject();
		$pks = $this->getPrimaryKeys();
		$q = "select * from {$this->name}
			where 1 = 1 ";
		for($i = 0; $i < count($pks); $i++)
		{
			$q .= "and {$pks[$i]} = '" . $this->db->escape(@$params[$pks[$i]]) . "' ";
		}
		$res = $this->db->query($q);
		if($row = $this->db->fetch_array($res))
			$ret->copyFromArray($row);
		$res->free();
		return $ret;
	}

	/**
	 * This function is using the result from MysqlTable::getStrictFields()
	 * in order to decide on which fields it should use "=" or "like" to perform the search.
	 * Example:
	 * // $list will contain an array of Person objects
	 * $list = $db->tbPersons->search(array("first_name" => "Monica", "city" => "Bucharest"), 0, 10, "first_name", "asc");
	 * // or search from $_GET parameters (useful for pagination)
	 * $list = $db->tbPersons->search($_GET, @$_GET["start"], @$_GET["rows_per_page"], @$_GET["order_by"], @$_GET["order_direction"]);
	 *
	 * $criteria is an associative array with string keys.
	 */
	function search($criteria = array(), $start = 0, $rowsPerPage = 25, $orderBy = "", $orderDirection = "asc")
	{
		if(empty($this->fields))
			$this->readTableInfo();

		$start = intval($start);
		$rowsPerPage = intval($rowsPerPage);
		if($rowsPerPage < 1)
			$rowsPerPage = 25;
		if(!in_array($orderDirection, array("asc", "desc")))
			$orderDirection = "asc";
		$strictFields = $this->getStrictFields();

		$ret = array();
		$q = "select * from {$this->name}
			where 1 = 1 ";
		foreach ($criteria as $key => $value)
		{
			if(!empty($key) && strval($value) != "" && in_array($key, $this->fields))
			{
				if(!in_array($key, $strictFields))
					$q .= "and $key like '%" . $this->db->escape($value) . "%' ";
				else
					$q .= "and $key = '" . $this->db->escape($value) . "' ";
			}
		}
		if(in_array($orderBy, $this->fields))
			$q .= "order by $orderBy $orderDirection ";
		$q .= "limit $start, $rowsPerPage ";
		$res = $this->db->query($q);
		while($row = $this->db->fetch_array($res))
		{
			$o = $this->createLogicObject();
			$o->copyFromArray($row);
			$ret[] = $o;
		}
		$res->free();
		return $ret;
	}

	/**
	 * Use it in conjunction with MysqlTable::search() to make pagination for multiple results.
	 */
	function getCount($criteria = array(), $start = 0, $rowsPerPage = 25, $orderBy = "", $orderDirection = "asc")
	{
		if(empty($this->fields))
			$this->readTableInfo();

		$start = intval($start);
		$rowsPerPage = intval($rowsPerPage);
		if($rowsPerPage < 1)
			$rowsPerPage = 25;
		if(!in_array($orderDirection, array("asc", "desc")))
			$orderDirection = "asc";
		$strictFields = $this->getStrictFields();

		$q = "select count(*) as total from {$this->name}
			where 1 = 1 ";
		foreach ($criteria as $key => $value)
		{
			if(!empty($key) && strval($value) != "" && in_array($key, $this->fields))
			{
				if(!in_array($key, $strictFields))
					$q .= "and $key like '%" . $this->db->escape($value) . "%' ";
				else
					$q .= "and $key = '" . $this->db->escape($value) . "' ";
			}
		}
		
		$res = $this->db->query($q);
		$row = $this->db->fetch_array($res);
		$res->free();
		return intval($row["total"]);
	}

}
?>