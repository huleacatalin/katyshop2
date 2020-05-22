<?php

/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(__FILE__) . "/common/BaseObject.php");

/**
 * Singleton class.
 * Place here all global objects such as database, config... used on the entire site
 *
 */
class Application extends BaseObject
{
	// generic
	var $cfg = array();
	/**
	 * @var Database
	 */
	var $db;
	var $mailAgent;
	var $currentMessage = 0;
	var $currentError = 0;
	var $messages = array();
	var $errors = array();
	/**
	 * @var Visitor
	 */
	var $user;

	//#########################################
	// specific
	var $category;
	var $product;

	/**
	 * @var Order
	 */
	var $shopping_cart;

	/**
	 * This is a singleton class, so the constructor is private
	 * @access private
	 */
	function __construct()
	{
	}

	/**
	 * Singleton
	 * @return Application
	 */
	static function createInstance()
	{
		global $Application;
		if(!is_a($Application, "Application"))
		{
			$Application = new Application();
			$Application->init();
		}
		return $Application;
	}

	/**
	 * @return User
	 */
	static function login($username, $password, $rememberPassword)
	{
		global $Application;
		$user = Visitor::login($username, $password, $rememberPassword);
		$Application->user = $user;
		return $user;
	}

	static function logout()
	{
		global $Application;
		$user = Visitor::logout();
		$Application->user = $user;
		$Application->shopping_cart = new Order();
		SessionWrapper::clear();
		$Application->commitSession();
		return $user;
	}

	//#######################################
	//# GETTERS								#
	//#######################################
	static function getConfig()
	{
		global $Application;
		return $Application->cfg;
	}

	static function getConfigValue($key)
	{
		global $Application;
		return @$Application->cfg[$key];
	}

	/**
	 * @return Database
	 */
	static function getDb()
	{
		global $Application;
		return $Application->db;
	}

	/**
	 * @return AppMailAgent
	 */
	static function getMailAgent()
	{
		global $Application;
		return $Application->mailAgent;
	}

	static function getMessages()
	{
		global $Application;
		return $Application->messages;
	}

	static function getErrors()
	{
		global $Application;
		return $Application->errors;
	}

	/**
	 * @return Visitor
	 */
	static function getUser()
	{
		global $Application;
		return $Application->user;
	}

	/**
	 * @return Category
	 */
	static function getCurrentCategory()
	{
		global $Application;
		if(is_a($Application->category, "Category"))
			return $Application->category;
		else
			return $Application->createCategory();
	}

	/**
	 * @return Product
	 */
	static function getCurrentProduct()
	{
		global $Application;
		if(is_a($Application->product, "Product"))
			return $Application->product;
		else
			return $Application->createProduct();
	}

	/**
	 * @return Order
	 */
	static function getShoppingCart()
	{
		global $Application;
		$Application->shopping_cart->computeValue();
		return $Application->shopping_cart;
	}

	//#######################################
	//# SETTERS								#
	//#######################################

	/**
	 * @param Order $o
	 */
	static function setShoppingCart($o)
	{
		global $Application;
		$Application->shopping_cart = new Order();
		$Application->shopping_cart->copyFromObject($o);
	}

	//#######################################
	//# MESSAGES AND ERRORS					#
	//#######################################
	static function addError($error)
	{
		global $Application;
		$Application->errors[] = $error;
	}

	static function addMessage($message)
	{
		global $Application;
		$Application->messages[] = $message;
	}

	static function appendErrors($newErrors)
	{
		global $Application;
		$Application->errors = array_merge($Application->errors, $newErrors);
	}

	static function appendMessages($newMessages)
	{
		global $Application;
		$Application->messages = array_merge($Application->messages, $newMessages);
	}

	static function hasMessages()
	{
		global $Application;
		return (count($Application->messages) > 0);
	}

	static function firstMessage()
	{
		global $Application;
		$Application->currentMessage = 0;
		if(count($Application->messages) > 0)
		{
			return $Application->messages[0];
		}
		else
		{
			return false;
		}
	}

	static function getNextMessage()
	{
		global $Application;
		if($Application->currentMessage < count($Application->messages))
		{
			$x = $Application->currentMessage;
			$Application->currentMessage++;
			return $Application->messages[$x];
		}
		else
		{
			return false;
		}
	}

	static function hasErrors()
	{
		global $Application;
		return (count($Application->errors) > 0);
	}

	static function firstError()
	{
		global $Application;
		$Application->currentError = 0;
		if(count($Application->errors) > 0)
		{
			return $Application->errors[0];
		}
		else
		{
			return false;
		}
	}

	static function getNextError()
	{
		global $Application;
		if($Application->currentError < count($Application->errors))
		{
			$x = $Application->currentError;
			$Application->currentError++;
			return $Application->errors[$x];
		}
		else
		{
			return false;
		}
	}

	//#######################################
	//# INIT 								#
	//#######################################
	function init()
	{
		ob_start();

		$this->loadConfig();

		if(defined('INSTALL_DONE')) {
			Logger::request();
			SessionWrapper::start();
			
			if(isset($_GET['html_theme']) && in_array($_GET['html_theme'], $this->cfg['html_themes']))
				SessionWrapper::set('html_theme', $_GET['html_theme']);
			if(!in_array(SessionWrapper::get('html_theme'), $this->cfg['html_themes']))
				SessionWrapper::set('html_theme', 'office_accessories');

			$this->fixCompat();
			$this->createDatabase();

			$this->mailAgent = new AppMailAgent();
			$this->createMessagesAndErrors();
			$this->createShoppingCart();
			$this->user = Visitor::getInstance();
		}
		else {
			header('location: install/');
			exit();
		}
	}

	function loadConfig()
	{
		require_once(dirname(dirname(__FILE__)) . "/config/config.php");
		require_once(dirname(dirname(__FILE__)) . "/config/counties.php");
		include_once(dirname(dirname(__FILE__)) . "/config/lang/{$this->cfg["lang_code"]}.php");
	}

	static function fixCompat()
	{
		$_GET = Compat::stripNice($_GET);
		$_POST = Compat::stripNice($_POST);
		$_COOKIE = Compat::stripNice($_COOKIE);
	}

	function createDatabase()
	{
		$cfgDb = $this->getConfigValue("db");
		$this->db = new Database($cfgDb['host'],$cfgDb['user'],$cfgDb['pass'],$cfgDb['name']);
		$this->db->registerTables();
		$this->db->open() or die("Application could not connect to the database");
	}

	function createMessagesAndErrors()
	{
		$this->messages = SessionWrapper::get("Application_messages");
		$this->errors = SessionWrapper::get("Application_errors");

		if(!is_array($this->messages))
			$this->messages = array();

		if(!is_array($this->errors))
			$this->errors = array();

		SessionWrapper::set("Application_messages", array());
		SessionWrapper::set("Application_errors", array());
	}

	/**
	 * @return Category
	 */
	function createCategory()
	{
		$id_category = 0;
		if(!empty($_GET["id_category"]))
		{
			$id_category = $_GET["id_category"];
		}
		elseif (!empty($_GET["id_parent"]))
		{
			$id_category = $_GET["id_parent"];
		}
		elseif (!empty($_GET["id_product"]))
		{
			$p = $this->db->tbProduct->getRecordById($_GET["id_product"]);
			$id_category = $p->id_category;
		}

		$this->category = $this->db->tbCategory->getRecordById($id_category);
		return $this->category;
	}

	function createProduct()
	{
		$this->product = $this->db->tbProduct->getRecordById(@$_GET["id_product"]);
		return $this->product;
	}

	function createShoppingCart()
	{
		$this->shopping_cart = SessionWrapper::get("Application_shopping_cart");
		if(!is_a($this->shopping_cart, "Order"))
			$this->shopping_cart = new Order();
	}

	//#######################################
	//# END OF INIT							#
	//#######################################


	//#######################################
	//# COMMIT SESSION						#
	//#######################################

	static function commitSession()
	{
		$messages = Application::getMessages();
		$errors = Application::getErrors();
		$shoppingCart = Application::getShoppingCart();
		SessionWrapper::set("Application_messages", $messages);
		SessionWrapper::set("Application_errors", $errors);
		SessionWrapper::set("Application_shopping_cart", $shoppingCart);
	}
}

?>