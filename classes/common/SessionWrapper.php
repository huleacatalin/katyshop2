<?php

/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(__FILE__) . "/BaseClass.php");

class SessionWrapper extends BaseClass
{
	static function start()
	{
		return session_start();
	}

	static function set($varname, $value)
	{
		$value = serialize($value);
		$varname .= "_asdf_" . SessionWrapper::id();
		$_SESSION[$varname] = $value;
	}

	static function get($varname)
	{
		$varname .= "_asdf_" . SessionWrapper::id();
		if(isset($_SESSION[$varname]))
			return unserialize($_SESSION[$varname]);
		else
			return "";
	}

	static function clear()
	{
		foreach($_SESSION as $key => $value)
		{
			$_SESSION[$key] = "";
		}
	}

	static function destroy()
	{
		return _asdf_destroy();
	}

	static function isRegistered($varname)
	{
		$varname .= "_asdf_" . SessionWrapper::id();
		return isset($_SESSION[$varname]);
	}

	static function id()
	{
		$thisArgs = func_get_args();
		return call_user_func_array("session_id", $thisArgs);
	}
}
?>