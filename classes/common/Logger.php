<?php

/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(__FILE__) . "/BaseClass.php");

class Logger extends BaseClass
{
	/**
	 * Example:
	 * Logger::str("Hello World!", __FILE__, __LINE__);
	 * log anything. This is called by Logger::err and Logger::msg too.
	 */
	static function str($s, $file = "", $line = "")
	{
		$cfgLog = Application::getConfigValue("logger");
		$s = "[" . $line . "] " . $s;
		$s = "[" . basename($file) . "] " . $s;
		$s = "[" . date("Y-m-d H:i:s") . "] " . $s;
		if(@$cfgLog["active"])
		{
			$f = @fopen(DATA_DIR . "/logs/" . @$cfgLog["filename"], "a+");
			@fwrite($f, $s . "\r\n");
			@fclose($f);
		}
	}

	/**
	 * log request; similar to apache log files, but has the capability also to log _POST data
	 */
	static function request($bubble = false)
	{
		$cfgLog = Application::getConfigValue("logger");

		$file = $_SERVER['REQUEST_URI'];
		$arr = parse_url(BASE_HREF);
		$file = str_replace($arr["path"], "", $file);

		$s = "REQUEST_URI = ";
		$s .= $file;
		if($_POST)
		{
			$s .= "\r\n _POST = ";
			$s .= print_r($_POST, true);
		}
		$s = "[" . $_SERVER['REMOTE_ADDR'] . "] " . $s;
		$s = "[" . date("Y-m-d H:i:s") . "] " . $s;
		if($bubble)
			Logger::str($s);
		if(@$cfgLog["request_active"])
		{
			$f = @fopen(DATA_DIR . "/logs/" . @$cfgLog["request_filename"], "a+");
			@fwrite($f, $s . "\r\n");
			@fclose($f);
		}
	}

	/**
	 * Example:
	 * Logger::err("Oh no!", __FILE__, __LINE__);
	 * log an error.
	 */
	static function err($s, $file = "", $line = "")
	{
		Logger::str($s, $file, $line);

		$cfgLog = Application::getConfigValue("logger");
		$s = "[" . $line . "] " . $s;
		$s = "[" . basename($file) . "] " . $s;
		$s = "[" . date("Y-m-d H:i:s") . "] " . $s;
		if(@$cfgLog["errors_active"])
		{
			$f = @fopen(DATA_DIR . "/logs/" . @$cfgLog["errors_filename"], "a+");
			@fwrite($f, $s . "\r\n");
			@fclose($f);
		}
	}

	/**
	 * Example:
	 * Logger::msg("I love you :)", __FILE__, __LINE__);
	 * log a message
	 */
	static function msg($s, $file = "", $line = "")
	{
		Logger::str($s, $file, $line);

		$cfgLog = Application::getConfigValue("logger");
		$s = "[" . $line . "] " . $s;
		$s = "[" . basename($file) . "] " . $s;
		$s = "[" . date("Y-m-d H:i:s") . "] " . $s;
		if(@$cfgLog["messages_active"])
		{
			$f = @fopen(DATA_DIR . "/logs/" . @$cfgLog["messages_filename"], "a+");
			@fwrite($f, $s . "\r\n");
			@fclose($f);
		}
	}

	/**
	 * Example:
	 * $x = new SomeObject();
	 * Logger::vardump($x, "x", __FILE__, __LINE__)
	 * log dump of a variable
	 */
	static function vardump($value, $varName = "some variable", $file = "", $line = "")
	{
		$value = Tools::remove_keys($value, array("db", "cfg", "mailAgent"));

		$s = $varName . " = " . print_r($value, true);
		Logger::str($s, $file, $line);

		$cfgLog = Application::getConfigValue("logger");
		$s = "[" . $line . "] " . $s;
		$s = "[" . basename($file) . "] " . $s;
		$s = "[" . date("Y-m-d H:i:s") . "] " . $s;
		if(@$cfgLog["vardump_active"])
		{
			$f = @fopen(DATA_DIR . "/logs/" . @$cfgLog["vardump_filename"], "a+");
			@fwrite($f, $s . "\r\n");
			@fclose($f);
		}
	}

}
?>