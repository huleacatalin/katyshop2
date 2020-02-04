<?php

/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(__FILE__) . "/User.php");

class Admin extends User
{
	var $id_admin = 0;
	var $is_admin = 0;

	function __construct()
	{
		parent::__construct();
	}


}









?>