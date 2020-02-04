<?php

/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(__FILE__) . "/BaseClass.php");

class Compat extends BaseClass
{
	/**
	 * Strip slashes from $val if magic quotes (gpc or runtime) is enabled.
	 * $val can be a string or an array
	 * $condition can be "gpc" or "runtime"
	 * 
	 * Example:
	 * $_POST = Compat::stripNice($_POST); // make sure that magic quotes dissapear
	 */
	static function stripNice($val, $condition = "gpc")
	{
		$test = true;
		if($condition == "gpc")
			$test = get_magic_quotes_gpc();
		elseif($condition == "runtime")
			$test = get_magic_quotes_runtime();
		
		if($test)
		{
			if(!is_array($val))
			{
				return stripslashes($val);
			}
			else 
			{
				foreach($val as $key => $value)
				{
					$val[$key] = Compat::stripNice($value, $condition);
				}
				return $val;
			}
		}
		else 
		{
			return $val;
		}
	}
	
	static function stripNiceRuntime($val)
	{
		return Compat::stripNice($val, "runtime");
	}
	
	static function cloneObj($thing)
	{
		if(is_a($thing, "LogicObject"))
		{
			return $thing->createClone();
		}
		elseif(is_object($thing) || is_resource($thing))
		{
			if (version_compare(phpversion(), '5.0') < 0)
				return $thing;
			else 
				return clone($thing);
		}
		elseif (is_array($thing))
		{
			return Compat::array_clone($thing);
		}
		else 
		{
			return $thing;
		}
	}
	
	static function array_clone($arr)
	{
		$temp = array();
		foreach ($arr as $key => $value)
		{
			$temp[$key] = Compat::cloneObj($value);
		}
		return $temp;
	}
	
}

?>