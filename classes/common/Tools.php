<?php

/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(__FILE__) . "/BaseClass.php");

class Tools extends BaseClass
{
	static function printr($what) {
		// Copyleft Andrei Serdeliuc
			if(is_a($what, "LogicObject"))
			{
				$insertFields = $what->__sleep();
				$arr = array();
				for($i = 0; $i < count($insertFields); $i++){
					$key = $insertFields[$i];
					$arr[$key] = $what->$key;
				}
				echo("<hr><h4><b>Start of print_r</b></h4><table border=1 bgcolor='#f1f1f1'><tr><td><pre>");
				$s = print_r($arr, true);
				$s = str_replace("[", "<font color='red'><b>[</b></font>", $s);
				$s = str_replace("]", "<font color='red'><b>]</b></font>", $s);
				$s = str_replace("Object", "<font color='blue'><b>Object</b></font>", $s);
				$s = str_replace("=>", "<font color='blue'><b>=></b></font>", $s);
				echo $s;
				echo("</pre></tr></td></table><h4><b>End of print_r</b></h4><hr>");
			}
			else
			{
			echo("<hr><h4><b>Start of print_r</b></h4><table border=1 bgcolor='#f1f1f1'><tr><td><pre>");
			$s = print_r($what, true);
			$s = str_replace("[", "<font color='red'><b>[</b></font>", $s);
			$s = str_replace("]", "<font color='red'><b>]</b></font>", $s);
			$s = str_replace("Object", "<font color='blue'><b>Object</b></font>", $s);
			$s = str_replace("=>", "<font color='blue'><b>=></b></font>", $s);
			echo $s;
			echo("</pre></tr></td></table><h4><b>End of print_r</b></h4><hr>");
			}
	}

	static function redirect($target, $toBaseHref = false)
	{
		Application::commitSession();
		if(!$toBaseHref)
			header("location: $target");
		else
			header("location: " . BASE_HREF . $target);
		exit;
	}

	static function validateInt($str, $positive = false, $strict = false)
	{
		if(!$positive)
			return (strval($str) == strval(intval($str)));
		elseif (!$strict)
			return (strval($str) == strval(intval($str)) && intval($str) >= 0);
		else
			return (strval($str) == strval(intval($str)) && intval($str) > 0);
	}

	static function validateFloat($str, $positive = false, $strict = false)
	{
		if(!$positive)
			return (strval($str) == strval(floatval($str)));
		elseif (!$strict)
			return (strval($str) == strval(floatval($str)) && floatval($str) >= 0);
		else
			return (strval($str) == strval(floatval($str)) && floatval($str) > 0);
	}

	static function validateAlphanumeric($string)
	{
		if(preg_match('/[^a-zA-Z0-9_]/', $string))
			return false;
		else
			return true;
	}

	static function validateEmail($string)
	{
		return filter_var($string, FILTER_VALIDATE_EMAIL);
	}

	/**
	 * Validate if a string corresponds to a number formatted with number_format().
	 */
	static function validateFormattedNumber($number = "", $decimals = 20, $dec_point = ".", $thousands_sep = ",")
	{
		$s = "";
		$s = strval($number);
		if(!Tools::validateInt($decimals, true))
			$decimals = 20;

		$dec_point = strval($dec_point);
		if(strlen($dec_point) > 1)
			$dec_point = substr($dec_point, 0, 1);

		$thousands_sep = strval($thousands_sep);
		if(strlen($thousands_sep) > 1)
			$thousands_sep = substr($thousands_sep, 0, 1);

		$arr = explode($dec_point, $s);
		// not more than 1 decimal point:
		if(count($arr) > 2)
			return false;

		// right side of decimal point must be integer
		if(count($arr) == 2 && !Tools::validateInt($arr[1], true))
			return false;

		$arr2 = explode($thousands_sep, $arr[0]);
		if(!Tools::validateInt($arr2[0]))
			return false;
		for($i = 1; $i < count($arr2); $i++)
		{
			if(!Tools::validateInt($arr2[$i], true))
				return false;
		}

		return true;
	}

	static function isImage($filename)
	{
		$ext = Tools::getExtension($filename);
		$images = array("bmp", "jpg", "jpeg", "gif", "png");
		return in_array(strtolower($ext), $images);
	}

	static function isOffice($filename)
	{
		$ext = Tools::getExtension($filename);
		$images = array("doc", "pdf", "xls", "txt", "rtf");
		return in_array(strtolower($ext), $images);
	}

	static function appendFileSuffix($filename, $suffix)
	{
		$x = strrpos($filename, ".");
		if($x === false)
			return $filename . "_$suffix";

		$s = substr($filename, 0, $x);
		$s .= "_$suffix";
		$s .= substr($filename, $x, strlen($filename) - $x);
		return $s;
	}

	static function removeFileSuffix($filename)
	{
		// $filename is like: myDoc_D3DS.txt
		// then parts are:
		$ext = ""; // .txt
		$suffix = ""; // _D3DS
		$basename = ""; // myDoc_D3DS
		$originalBase = ""; // myDoc
		$originalFilename = ""; // myDoc.txt

		$x = strrpos($filename, ".");
		$ext = ($x === false) ? "" : substr($filename, $x, strlen($filename) - $x);
		$basename = ($x === false) ? $filename : substr($filename, 0, $x);
		$x = strrpos($basename, "_");
		$suffix = ($x === false) ? "" : substr($basename, $x, strlen($basename) - $x);
		$originalBase = ($x === false) ? $basename : substr($basename, 0, $x);
		$originalFilename = $originalBase . $ext;

		return $originalFilename;
	}

	static function getExtension($filename)
	{
		$arr = explode(".", $filename);
		if(count($arr) < 2)
			return "";
		else
			return $arr[count($arr) - 1];
	}

	static function getRandomChars($count = 10)
	{
		$chars = "1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";
		$s = "";
		for($i = 0; $i < $count; $i++)
		{
			$x = rand(1, strlen($chars) - 1);
			$s .= $chars{$x};
		}
		return $s;
	}

	/**
	 * Recursive remove keys from this array
	 *
	 * @param array $arr
	 * @param array $remove_keys
	 * @return array
	 */
	static function remove_keys($arr, $remove_keys)
	{
		if(is_object($arr))
			$arr = get_object_vars($arr);
		if(!is_array($arr))
			return $arr;

		$temp = array();
		foreach ($arr as $key => $value)
		{
			if(!in_array("$key", $remove_keys))
			{
				if(is_array($value) || is_object($value))
					$temp["$key"] = Tools::remove_keys($value, $remove_keys);
				else
					$temp["$key"] = $value;
			}
		}
		return $temp;
	}


	/**
	 * $inputArr parameter is something like $_GET, $_POST...
	 *
	 * Sample input array:
	 * array('foo'=>'bar',
	 *         'baz'=>'boom',
	 *         'cow'=>'milk',
	 *         'php'=>'hypertext processor');
	 * This function will return a url querystring like foo=bar&baz=boom&cow=milk&php=hypertext+processor
	 *
	 * Useful thing found here in a user's comment:
	 * http://www.php.net/http_build_query
	 *
	 * (and a little chopped by me)
	 *
	 * @param array $arr
	 */
	static function http_build_query2( $formdata, $exclude_keys = array(), $numeric_prefix = null, $key = null )
	{
		$res = array();
		foreach((array)$formdata as $k => $v)
		{
			if(in_array($k, $exclude_keys))
				continue;

			$tmp_key = urlencode(is_int($k) ? $numeric_prefix.$k : $k);
			if($key)
				$tmp_key = $key.'['.$tmp_key.']';
			if(is_array($v) || is_object($v))
			{
				$res[] = Tools::http_build_query2($v, $exclude_keys, null /* or $numeric_prefix if you want to add numeric_prefix to all indexes in array*/, $tmp_key);
			}
			else
			{
				$res[] = $tmp_key."=".urlencode($v);
			}
			/*
			If you want, you can write this as one string:
			$res[] = ( ( is_array($v) || is_object($v) ) ? http_build_query($v, null, $tmp_key) : $tmp_key."=".urlencode($v) );
			*/
		}
		$separator = ini_get('arg_separator.output');
		return implode($separator, $res);
	}

	/**
	 * $inputArr parameter is something like $_GET, $_POST...
	 *
	 * Sample input array:
	 * array('foo'=>'bar',
	 *         'baz'=>'boom',
	 *         'cow'=>'milk',
	 *         'php'=>'hypertext processor');
	 * This function will return a string containing html hidden input fields like:
	 * <input type="hidden" name="foo" value="bar" />
	 * <input type="hidden" name="baz" value="boom" />
	 *
	 * @param array $arr
	 */
	static function http_build_hidden_inputs( $formdata, $exclude_keys = array(), $numeric_prefix = null, $key = null )
	{
		$res = array();
		foreach((array)$formdata as $k => $v)
		{
			if(in_array($k, $exclude_keys))
				continue;

			$tmp_key = urlencode(is_int($k) ? $numeric_prefix.$k : $k);
			if($key)
				$tmp_key = $key.'['.$tmp_key.']';
			if(is_array($v) || is_object($v))
			{
				$res[] = Tools::http_build_hidden_inputs($v, $exclude_keys, null /* or $numeric_prefix if you want to add numeric_prefix to all indexes in array*/, $tmp_key);
			}
			else
			{
				$res[] = '<input type="hidden" name="' . htmlspecialchars($tmp_key) . '" value="' . htmlspecialchars($v) . '" />';
			}
			/*
			If you want, you can write this as one string:
			$res[] = ( ( is_array($v) || is_object($v) ) ? http_build_query($v, null, $tmp_key) : $tmp_key."=".urlencode($v) );
			*/
		}
		return implode("\r\n", $res);
	}

	static function limitString($str, $maxChars = 30)
	{
		if(strlen($str) <= $maxChars)
			return $str;
		return substr($str, 0, $maxChars) . "...";
	}

	static function limitDecimals($number, $decimals = 2)
	{
		return sprintf("%01.{$decimals}f", $number);
	}

	static function dowrap($str, $width = 40, $cut = 1, $break = "\n")
	{
		return wordwrap($str, $width, $break, $cut);
	}

	static function startsWith($str, $needle)
	{
		return (strpos($str, $needle) !== false && strpos($str, $needle) == 0);
	}

	// reverse of number_format() - read a number formatted with number_format()
	// and return it as a float
	static function read_number_format($number = "", $decimals = 20, $dec_point = ".", $thousands_sep = ",")
	{
		$s = "";
		$s = strval($number);
		if(!Tools::validateInt($decimals, true))
			$decimals = 20;

		$dec_point = strval($dec_point);
		if(strlen($dec_point) > 1)
			$dec_point = substr($dec_point, 0, 1);

		$thousands_sep = strval($thousands_sep);
		if(strlen($thousands_sep) > 1)
			$thousands_sep = substr($thousands_sep, 0, 1);

		$arr = explode($dec_point, $s);
		$arr0 = explode($thousands_sep, $arr[0]);
		$s = "";
		for($i = 0; $i < count($arr0); $i++)
			$s .= $arr0[$i];
		if(count($arr) > 1)
			$s .= "." . $arr[1];

		$s = floatval($s);
		if(!is_float($s))
			$s = 0;

		return $s;
	}

	static function parseSearchString($s)
	{
		$s = preg_replace('/[^a-zA-Z0-9_\*\"]/', " ", $s); // strip all weird characters
		$s = preg_replace('/(\s)+/', " ", $s); // replace tabs, new lines and multiple spaces with simple space
		$s = str_replace('*', '%', $s); // use * as a special character to search random characters
		$exact = array(); // list of exact expresions to search
		$aproximate = array(); // list of aproximate words to search

		$i = 0;
		$b = false;
		while($i !== false)
		{
			$j = strpos($s, '"', $i);
			if($j !== false)
				$word = substr($s, $i, $j - $i);
			else
				$word = substr($s, $i, strlen($s) - $i);

			if($b)
				$exact[] = trim($word);
			else
				$aproximate[] = trim($word);
			$b = !$b;
			$i = ($j === false) ? false : $j + 1;
		}
		$aproximate = trim(implode(" ", $aproximate));
		$aproximate = explode(" ", $aproximate);
		$aproximate = array_values(Tools::array_trim($aproximate));
		$exact = array_values(Tools::array_trim($exact));

		return array("exact" => $exact, "aproximate" => $aproximate);
	}

	/**
	 * Removes duplicate and empty values
	 *
	 * @param array $arr
	 * @return array
	 */
	static function array_trim($arr)
	{
		$ret = array_unique($arr);
		foreach ($ret as $key => $value)
		{
			if(empty($value))
				unset($ret[$key]);
		}
		return $ret;
	}

	static function encrypt($str, $key) {
		$ciphering = "AES-128-CTR";
		$options = 0;
		$chars = 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890';
		$iv = '';
		while(strlen($iv) < 16) {
			$i = rand(0, strlen($chars) - 1);
			$iv .= $chars[$i];
		}
		$encrypted = openssl_encrypt($str, $ciphering, $key, $options, $iv);
		return $iv . $encrypted;
	}

	static function decrypt($encrypted, $key) {
		$ciphering = "AES-128-CTR";
		$options = 0;
		$iv = substr($encrypted, 0, 16);
		$encrypted = substr($encrypted, 16, strlen($encrypted) - 16);
		return openssl_decrypt($encrypted, $ciphering, $key, $options, $iv);
	}

}
?>