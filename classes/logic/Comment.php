<?php

/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

class Comment extends LogicObject
{
	var $id = 0;
	var $id_product = 0;
	var $id_user = 0;
	var $username = '';
	var $content = '';
	var $date_created = '';

	function __construct()
	{
		parent::__construct();
		$this->date_created = date('Y-m-d H:i:s');
	}

	function validate()
	{
		$errors = array();
		if(strlen($this->content) < 3 || strlen($this->content) > 1000)
			$errors[] = "Comment must have between 3 and 1000 characters";
		
		$db = Application::getDb();
		if(!$db->tbProduct->productExists($this->id_product))
			$errors[] = 'Product of this comment does not exist';
		
		if(!$db->tbUser->idExists($this->id_user))
			$errors[] = 'User of this comment does not exist';

		Application::appendErrors($errors);
		return (count($errors) == 0);
	}
	
}

?>