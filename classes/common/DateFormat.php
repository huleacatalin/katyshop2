<?php

/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(__FILE__) . "/date/Date.php");

// 2006-08-09
/**
 * Extends Date from PEAR
 *
 */
class DateFormat extends Date 
{
	function __construct($date = null)
	{
		return parent::__construct($date);
	}
	
	/**
	 * method from base class is not working on windows :(
	 *
	 */
	function isFuture()
	{
		$now = new DateFormat();
		if($this->isGreater($now))
			return true;
		else
			return false;
	}
	
	/**
	 * @param DateFormat $d
	 */
	function isGreater($d)
	{
		if($this->year > $d->year)
			return true;
		if($this->year < $d->year)
			return false;
			
		if($this->month > $d->month)
			return true;
		if($this->month < $d->month)
			return false;
			
		if($this->day > $d->day)
			return true;
		if($this->day < $d->day)
			return false;
			
		if($this->hour > $d->hour)
			return true;
		if($this->hour < $d->hour)
			return false;
			
		if($this->minute > $d->minute)
			return true;
		if($this->minute < $d->minute)
			return false;
			
		if($this->second > $d->second)
			return true;
		if($this->second < $d->second)
			return false;

		return false;
	}
	
	function clear()
	{
        $this->year       = 0;
        $this->month      = 1;
        $this->day        = 1;
        $this->hour       = 0;
        $this->minute     = 0;
        $this->second     = 0;
        $this->partsecond = (float)0;
	}
	
	function readDate($str, $format = "YYYY-MM-DD", $separator = "-", $clear = true)
	{
		if($clear)
			$this->clear();
		
        $arr = explode($separator, $str);
        $orderBy = explode($separator, $format);
        if(count($arr) != count($orderBy))
        	return false;
		
		for($i = 0; $i < count($orderBy); $i++)
		{
			switch ($orderBy[$i])
			{
				case "YYYY":
					$this->year = $arr[$i];
					break;
				case "MM":
					$this->month = $arr[$i];
					break;
				case "DD":
					$this->day = $arr[$i];
					break;
			}
		}
		return true;
	}
	
	function readTime($str, $format = "H:i:s", $separator = ":", $clear = true)
	{
		if($clear)
			$this->clear();
        
        $arr = explode($separator, $str);
        $orderBy = explode($separator, $format);
        if(count($arr) != count($orderBy))
        	return false;
		
		for($i = 0; $i < count($orderBy); $i++)
		{
			switch ($orderBy[$i])
			{
				case "H":
					$this->hour = $arr[$i];
					break;
				case "i":
					$this->minute = $arr[$i];
					break;
				case "s":
					$this->second = $arr[$i];
					break;
			}
		}
		return true;
	}
	
	function readDateTime($str, $format = "YYYY-MM-DD H:i:s", $dateSeparator = "-", $dateTimeSeparator = " ", $timeSeparator = ":")
	{
		$this->clear();
		
		$arr = explode($dateTimeSeparator, $str);
		$orderBy = explode($dateTimeSeparator, $format);
		if(count($arr) != count($orderBy))
			return false;
		
		for($i = 0; $i < count($orderBy); $i++)
		{
			if(strpos($orderBy[$i], "YYYY") !== false)
			{
				$temp = $this->readDate($arr[$i], $orderBy[$i], $dateSeparator, false);
				if(!$temp)
					return false;
			}
			elseif (strpos($orderBy[$i], "H") !== false)
			{
				$temp = $this->readTime($arr[$i], $orderBy[$i], $timeSeparator, false);
				if(!$temp)
					return false;
			}
		}
		return true;
	}
	
	function display($format = "YYYY-MM-DD H:i:s", $dateSeparator = "-", $dateTimeSeparator = " ", $timeSeparator = ":")
	{
		$str = "";
		$arr = explode($dateTimeSeparator, $format);
		for($i = 0; $i < count($arr); $i++)
		{
			if($i > 0)
				$str .= $dateTimeSeparator;
			if(strpos($arr[$i], "YYYY") !== false || strpos($arr[$i], "MM") !== false
					|| strpos($arr[$i], "DD") !== false)
			{
				$str .= $this->displayDate($arr[$i], $dateSeparator);
			}
			elseif (strpos($arr[$i], "H") !== false ||strpos($arr[$i], "i") !== false 
					||strpos($arr[$i], "s") !== false)
			{
				$str .= $this->displayTime($arr[$i], $timeSeparator);
			}
		}
		return $str;
	}
	
	function displayDate($format = "YYYY-MM-DD", $separator = "-")
	{
		$str = "";
		$arr = @explode($separator, $format);
		for($i = 0; $i < count($arr); $i++)
		{
			if($i > 0)
				$str .= $separator;
			switch ($arr[$i])
			{
				case "YYYY":
					$str .= $this->year;
					break;
				case "MM":
					$str .= str_pad($this->month, 2, "0", STR_PAD_LEFT);
					break;
				case "DD":
					$str .= str_pad($this->day, 2, "0", STR_PAD_LEFT);
					break;
			}
		}
		return $str;
	}
	
	function displayTime($format = "H:i:s", $separator = ":")
	{
		$str = "";
		$arr = @explode($separator, $format);
		for($i = 0; $i < count($arr); $i++)
		{
			if($i > 0)
				$str .= $separator;
			switch ($arr[$i])
			{
				case "H":
					$str .= str_pad($this->hour, 2, "0", STR_PAD_LEFT);
					break;
				case "i":
					$str .= str_pad($this->minute, 2, "0", STR_PAD_LEFT);
					break;
				case "s":
					$str .= str_pad($this->second, 2, "0", STR_PAD_LEFT);
					break;
			}
		}
		return $str;
	}
	
	function validateDate($minYear = 1970, $maxYear = 2050)
	{
		if(!is_numeric($this->year) || !is_numeric($this->month) || !is_numeric($this->day))
			return false;
		if(intval($this->year) < $minYear || intval($this->year) > $maxYear)
			return false;
		if(intval($this->month) < 1 || intval($this->month) > 12)
			return false;
		if(intval($this->day) < 1 || intval($this->day) > 31)
			return false;
			
		$maxDays = $this->maxDaysInMonth($this->year, $this->month);
		if($this->day > $maxDays)
			return false;
		return true;
	}

	function validateTime()
	{
		if(!is_numeric($this->hour) || !is_numeric($this->minute) || !is_numeric($this->second))
			return false;
		if(intval($this->hour) < 0 || intval($this->hour) > 24)
			return false;
		if(intval($this->minute) < 0 || intval($this->minute) > 60)
			return false;
		if(intval($this->second) < 0 || intval($this->second) > 60)
			return false;
		return true;
	}
	
	function validate($minYear = 1970, $maxYear = 2050)
	{
		return $this->validateDate($minYear, $maxYear) && $this->validateTime();
	}
	
	function maxDaysInMonth($year, $month)
	{
		$leap = false;
		$max = 30;
	
		if($year % 400 == 0)
		{
			$leap = true;
		}
		else
		{
			if($year % 100 == 0)
			{
				$leap = false;
			}
			else
			{
				if($year % 4 == 0)
				{
					$leap = true;
				}
			}
		}
	
		if($month == 2)
		{
			if($leap == 1)
			{
				$max = 29;
			}
			else
			{
				$max = 28;
			}
		}
		else
		{
			if($month % 2 == 1)
			{
				if($month < 8) $max = 31;
			}
			else
			{
				if($month > 7) $max = 31;
			}
		}
		return $max;
	}
	
}


?>