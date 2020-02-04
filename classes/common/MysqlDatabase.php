<?php

/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(__FILE__) . "/BaseObject.php");

class MysqlDatabase extends BaseObject
{
	var $mysqli;

	/**
	 * Constructor
	 *
	 * @param string $dbHost
	 * @param string $username
	 * @param string $password
	 * @param string $dbName
	 * @return MysqlDatabase
	 */
	function __construct($dbHost, $username, $password, $dbName)
	{
		$this->mysqli = new mysqli();
		@$this->mysqli->real_connect($dbHost, $username, $password, $dbName);
	}

	/**
	 * Try to open connection. Returns true on success or false on failure.
	 *
	 * @return boolean
	 */
	function open()
	{
		if($this->mysqli->connect_errno)
			return false;
		else
			return true;
	}

	/**
	 * Close connection to database.
	 *
	 * @return boolean
	 */
	function close()
	{
		$this->mysqli->close();
	}

	/**
	 * Escape a string parameter, in order to prepare it
	 * for sql query (avoid injection)
	 *
	 * @param string $str
	 * @return string
	 */
	function escape($str)
	{
		return $this->mysqli->real_escape_string($str);
	}

	/**
	 * Send a mysql query AS-IS written in $q parameter.
	 * Nothing is escaped by this function, just send the query.
	 * Example: $result = $db->query("SELECT * FROM users");
	 *
	 * @param string $q
	 */
	function query($q)
	{
		$res = $this->mysqli->query($q);
		if($res === false)
		{
			Logger::err("Database::query() failed with error message: " . $this->mysqli->error, __FILE__, __LINE__);
			Logger::err("Query was: $q", __FILE__, __LINE__);
		}
		return $res;
	}

	/**
	 * @return int
	 */
	function lastInsertId()
	{
		return $this->mysqli->insert_id;
	}

	function fetch_array($res)
	{
		return $res->fetch_array();
	}
}
?>