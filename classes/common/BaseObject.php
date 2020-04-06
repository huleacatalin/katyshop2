<?php

/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(__FILE__) . "/BaseClass.php");

class BaseObject extends BaseClass
{
	function __construct()
	{

	}

	/**
	 * I don't want to write the __sleep() function for every object
	 * in my logic, so i put it in the base object class, that way all
	 * objects inherited from here will be entirely serialized when working with sessions.
	 *
	 * Override it in inherited class if it's not working properly for you.
	 *
	 * @return unknown
	 */
	function __sleep()
	{
		$ret = array();
		$myClass = get_class($this);
		$allProps = array_keys(get_class_vars($myClass));
		$ret = $allProps;
		return $ret;
	}

	/**
	 * Reset all properties of an object to their initial default values.
	 */
	function reset()
	{
		$asoc = get_class_vars(get_class($this));
		foreach ($asoc as $key => $value)
		{
			$this->$key = $value;
		}
	}

	/**
	 * Example:
	 * class Person
	 * {
	 * 		var $firstName;
	 * 		var $lastName;
	 * 		var $eyesColor;
	 * }
	 *
	 * $p = new Person();
	 * $arr = array("firstName" => "John", "lastName" => "Doe", "eyesColor" => "red");
	 * $p->copyFromArray($arr); // $p now has the values from $arr array on it's properties.
	 *
	 */
	function copyFromArray($arr)
	{
		$asoc = get_class_vars(get_class($this));
		$props = array_keys($asoc);
		for($i = 0; $i < count($props); $i++)
		{
			$prop = $props[$i];
			if(array_key_exists($prop, $arr))
				$this->$prop = $arr[$prop];
		}
	}

	/**
	 * Example:
	 * class Person
	 * {
	 * 		var $firstName;
	 * 		var $lastName;
	 * 		var $eyesColor;
	 * }
	 *
	 * $p = new Person();
	 * $p->firstName = "John";
	 * $p->lastName = Doe;
	 *
	 * $anotherP = new Person();
	 * $anotherP->copyFromArray($p); // $anotherP now has the values from $p object on it's properties.
	 *
	 */
	function copyFromObject($obj)
	{
		$mykeys = get_class_vars(get_class($this));
		$mykeys = array_keys($mykeys);

		$keys = get_object_vars($obj);
		foreach ($keys as $key => $value)
		{
			if(in_array($key, $mykeys))
			{
				if(is_array($value))
				// array may keep references inside it's elements,
				// but we don't want that, we actually want a Clone of $obj
					$this->$key = Compat::array_clone($obj->$key);
				else
					$this->$key = $obj->$key;
			}
		}
	}

	/**
	 * Constructor of the inherited class must not have mandatory parameters.
	 */
	function createClone()
	{
		$className = get_class($this);
		$newObj = new $className();
		$newObj->copyFromObject($this);
		return $newObj;
	}

	/**
	 * Since we have date format configurable, I don't want to write all parameters
	 * for DateFormat::display() in all web pages.
	 *
	 * I'll just place this in base core object, so all objects can display their
	 * own dates and date time properties in format chosed by config.
	 *
	 * @param sql_date $propertyName
	 * @return string
	 */
	function displayDate($propertyName)
	{
		$cfgDf = Application::getConfigValue("date_format");
		$lang_code = Application::getConfigValue("lang_code");
		if(array_key_exists($lang_code, $cfgDf))
			$cfgDf = $cfgDf[$lang_code];
		
		$df = new DateFormat();
		$df->readDate($this->$propertyName);
		$str = $df->validate() ? $df->displayDate($cfgDf["date"], $cfgDf["separator_date"]) : "";
		return $str;
	}

	/**
	 * Since we have date format configurable, I don't want to write all parameters
	 * for DateFormat::display() in all web pages.
	 *
	 * I'll just place this in base core object, so all objects can display their
	 * own dates and date time properties in format chosed by config.
	 *
	 * @param sql_date $propertyName
	 * @return string
	 */
	function displayDateTime($propertyName)
	{
		$cfgDf = Application::getConfigValue("date_format");
		$lang_code = Application::getConfigValue("lang_code");
		if(array_key_exists($lang_code, $cfgDf))
			$cfgDf = $cfgDf[$lang_code];
		
		$df = new DateFormat();
		$df->readDateTime($this->$propertyName);
		$str = $df->validate() ? $df->display($cfgDf["date_time"], $cfgDf["separator_date"], $cfgDf["separator_date_time"], $cfgDf["separator_time"]) : "";
		return $str;
	}

	function readDate($propertyName, $dateValue)
	{
		$cfgDf = Application::getConfigValue("date_format");
		$df = new DateFormat();
		$df->readDate($dateValue, $cfgDf["date"], $cfgDf["separator_date"]);
		$this->$propertyName = $df->validateDate() ? $df->displayDate() : "";
	}

	function readDateTime($propertyName, $dateValue)
	{
		$cfgDf = Application::getConfigValue("date_format");
		$lang_code = Application::getConfigValue("lang_code");
		if(array_key_exists($lang_code, $cfgDf))
			$cfgDf = $cfgDf[$lang_code];
	
		$df = new DateFormat();
		$df->readDateTime($dateValue, $cfgDf["date"], $cfgDf["separator_date"]);
		$this->$propertyName = $df->validate() ? $df->display() : "";
	}

	function toStr()
	{
		return print_r($this, true);
	}
}

?>