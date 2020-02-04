<?php

/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */
class Database extends MysqlDatabase
{
	/**
	 * @var TableUser
	 */
	var $tbUser;

	/**
	 * @var TableUserPerson
	 */
	var $tbUserPerson;

	/**
	 * @var TableUserCompany
	 */
	var $tbUserCompany;

	/**
	 * @var TableAdmin
	 */
	var $tbAdmin;

	/**
	 * @var TableAddress
	 */
	var $tbAddress;

	/**
	 * @var TableCategory
	 */
	var $tbCategory;

	/**
	 * @var TableProduct
	 */
	var $tbProduct;

	/**
	 * @var TableProductImage
	 */
	var $tbProductImage;

	/**
	 * @var TableOrder
	 */
	var $tbOrder;

	/**
	 * @var TableOrderProduct
	 */
	var $tbOrderProduct;

	/**
	 * @var TableManufacturer
	 */
	var $tbManufacturer;

	/**
	 * @var TableContactMessage
	 */
	var $tbContactMessage;

	function __construct($dbHost, $username, $password, $dbName)
	{
		parent::__construct($dbHost, $username, $password, $dbName);
	}

	function registerTables()
	{
		$cfgDb = Application::getConfigValue("db");
		$this->tbUser = new TableUser($this);
		$this->tbUserPerson = new TableUserPerson($this);
		$this->tbUserCompany = new TableUserCompany($this);
		$this->tbAdmin = new TableAdmin($this);
		$this->tbAddress = new TableAddress($this);
		$this->tbCategory = new TableCategory($this);
		$this->tbProduct = new TableProduct($this);
		$this->tbProductImage = new TableProductImage($this);
		$this->tbOrder = new TableOrder($this);
		$this->tbOrderProduct = new TableOrderProduct($this);
		$this->tbManufacturer = new TableManufacturer($this);
		$this->tbContactMessage = new TableContactMessage($this);
	}
}
?>