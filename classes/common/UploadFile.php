<?php

/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(__FILE__) . "/BaseObject.php");

/**
 * not a very smart class, but helps you write less code...
 * bleah...
 *
 */
class UploadFile extends BaseObject
{
	var $inputName = "";
	var $tmpPrefix = "tmp";
	var $prefix = "";
	var $tmpName = "";
	var $newFilename = "";
	var $TEMP_DIR = "";
	var $FINAL_DIR = "";
	
	var $my_FILES = array();

	var $errors = array();
	var $messages = array();

	function __construct($htmlFormInputName, $argFinalDir, $argTempDir = "", $index = -1)
	{
		parent::__construct();
		$this->inputName = $htmlFormInputName;
		$this->FINAL_DIR = $argFinalDir;
		$this->TEMP_DIR = $argTempDir;
		
		$this->my_FILES = array('name' => ($index > -1) ? @$_FILES[$this->inputName]['name'][$index] : @$_FILES[$this->inputName]['name'],
								'type' => ($index > -1) ? @$_FILES[$this->inputName]['type'][$index] : @$_FILES[$this->inputName]['type'],
								'tmp_name' => ($index > -1) ? @$_FILES[$this->inputName]['tmp_name'][$index] : @$_FILES[$this->inputName]['tmp_name'],
								'error' => ($index > -1) ? @$_FILES[$this->inputName]['error'][$index] : @$_FILES[$this->inputName]['error'],
								'size' => ($index > -1) ? @$_FILES[$this->inputName]['size'][$index] : @$_FILES[$this->inputName]['size']);
		
		$this->setTmpPrefix("");
		$this->setPrefix("");
	}

	function isEmpty()
	{
		return (empty($_FILES) || empty($_FILES[$this->inputName]) || empty($this->my_FILES['name']));
	}

	function setTmpPrefix($newTmpPrefix)
	{
		$this->tmpPrefix = $newTmpPrefix;
		$this->tmpName = $this->tmpPrefix . $this->my_FILES['name'];
	}

	function setPrefix($argPrefix)
	{
		$this->prefix = $argPrefix;
		$this->newFilename = $this->prefix . $this->my_FILES['name'];
	}

	function validateInput()
	{
		if (empty($this->my_FILES['name']))
			$this->errors[] = "There was an error while trying to upload the file";
		if(strlen($this->tmpName) < 5 || strlen($this->tmpName) > 255)
			$this->errors[] = "Temporary filename must have between 5 and 255 characters";
		if(strlen($this->newFilename) < 5 || strlen($this->newFilename) > 255)
			$this->errors[] = "New filename must have between 5 and 255 characters";
		if(!is_dir($this->FINAL_DIR))
			$this->errors[] = "Could not find FINAL_DIR as a directory to use it";
		if(!empty($this->TEMP_DIR) && !is_dir($this->TEMP_DIR))
			$this->errors[] = "Could not find TEMP_DIR as a directory to use it";
	}

	function validateImage()
	{
		if (!Tools::isImage($this->my_FILES['name']))
			$this->errors[] = "The file you uploaded is not an image, please try again";
	}

	function upload($toFinalDir = true)
	{
		if($this->hasErrrors())
			return false;

		if($toFinalDir)
		{
			$filename = $this->FINAL_DIR . "/" . $this->tmpName;
		}
		else
		{
			if(empty($this->TEMP_DIR))
			{
				$this->errors[] = "Cannot use temporary upload method because TEMP_DIR is not set";
				return false;
			}
			$filename = $this->TEMP_DIR . "/" . $this->tmpName;
		}

		if(move_uploaded_file($this->my_FILES["tmp_name"], $filename))
		{
			return true;
		}
		else
		{
			$this->errors[] = "There was an error while trying to upload the file";
			return false;
		}
	}

	function resize_limitwh($w = 100, $h = 100)
	{
		if($this->hasErrrors())
			return false;

		$im = new RESIZEIMAGE();
		$im->setImage($this->TEMP_DIR . "/" . $this->tmpName);
		$im->resize_limitwh($w, $h, $this->TEMP_DIR . "/" . $this->newFilename);

		if(is_file($this->TEMP_DIR . "/" . $this->newFilename))
		{
			return true;
		}
		else
		{
			$this->errors[] = "Could not process the image you uploaded";
			return false;
		}
	}

	/**
	 * If you uploaded the image to a temporary directory
	 * and processed it there, call commit() in the end to clean up temporary directory
	 * and move the file to the final directory
	 *
	 * If you set a filename for $deleteExistingFile, this function will try to delete
	 * that file from $this->FINAL_DIR, before moving uploaded file
	 */
	function commit($deleteExistingFile = "")
	{
		if(empty($this->TEMP_DIR))
		{
			$this->errors[] = "Cannot use commit() because TEMP_DIR is not set";
			return false;
		}

		if(is_file($this->TEMP_DIR . "/" . $this->newFilename))
		{
			if(!empty($deleteExistingFile))
				@unlink($this->FINAL_DIR . "/" . $deleteExistingFile);
			@rename($this->TEMP_DIR . "/" . $this->newFilename, $this->FINAL_DIR . "/" . $this->newFilename);
		}

		// delete from temporary directory
		if(is_file($this->TEMP_DIR . "/" . $this->newFilename))
			@unlink($this->TEMP_DIR . "/" . $this->newFilename);
		if(is_file($this->TEMP_DIR . "/" . $this->tmpName))
			@unlink($this->TEMP_DIR . "/" . $this->tmpName);

		if($this->hasErrrors())
			return false;
		else
			return true;
	}

	function hasErrrors()
	{
		return (count($this->errors) > 0);
	}

	function clearErrors()
	{
		$this->errors = array();
	}

	function clearMessages()
	{
		$this->messages = array();
	}

}

?>