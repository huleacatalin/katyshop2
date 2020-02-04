<?php

function getRandomChars($len) {
	$s = '';
	$chars = '1234567890QAZWSXEDCRFVTGBYHNUJMIKOLPqazwsxedcrfvtgbyhnujmikolp';
	for($i = 0; $i < $len; $i++) {
		$j = rand(0, strlen($chars) - 1);
		$s .= $chars{$j};
	}
	return $s;
}

function tools_encrypt($str, $key) {
	$ciphering = "AES-128-CTR";
	$options = 0;
	$iv = getRandomChars(16);
	$encrypted = openssl_encrypt($str, $ciphering, $key, $options, $iv);
	return $iv . $encrypted;
}

$APP_NAME = @$_POST['APP_NAME'];

$s = dirname($_SERVER['REQUEST_URI']);
if($_SERVER['REQUEST_URI']{strlen($_SERVER['REQUEST_URI']) - 1} != '/')
	$s = dirname($s);
$protocol = 'http';
if(isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) != 'off')
	$protocol = 'https';
$BASE_HREF = $protocol . '://' . $_SERVER['SERVER_NAME'] . $s . '/';

$default_currency = array_key_exists('default_currency', $_POST) ? $_POST['default_currency'] : '$';
$shop_invoice_info = @$_POST['shop_invoice_info'];

$openssl_key = getRandomChars(128);

$db_host = array_key_exists('db_host', $_POST) ? $_POST['db_host'] : 'localhost';
$db_user = array_key_exists('db_user', $_POST) ? $_POST['db_user'] : 'root';
$db_password = @$_POST['db_password'];
$db_name = array_key_exists('db_name', $_POST) ? $_POST['db_name'] : 'katyshop2';

$admin_username = array_key_exists('admin_username', $_POST) ? $_POST['admin_username'] : 'admin';
$admin_password = array_key_exists('admin_password', $_POST) ? $_POST['admin_password'] : '';
$admin_confirm_password = array_key_exists('admin_confirm_password', $_POST) ? $_POST['admin_confirm_password'] : '';
$admin_email = array_key_exists('admin_email', $_POST) ? $_POST['admin_email'] : 'admin@' . $_SERVER['SERVER_NAME'];

$error = '';
$config_filename = dirname(dirname(__FILE__)) . '/config/config.php';
if(!is_readable($config_filename))
	$error .= 'config/config.php is not readable, installation cannot continue. ';
if(!is_writable($config_filename))
	$error .= 'config/config.php is not writable, installation cannot continue. ';

if(empty($error)) {
	$config_contents = file_get_contents($config_filename);
	$search_string = "define('INSTALL_DONE', true);";
	if(strpos($config_contents, $search_string) !== false) {
		$error .= 'It looks like there has been a previous installation. This installation cannot continue. ';
		$error .= 'In order to reinstall you need to completely remove the previous installation - the files and the database. ';
		$error .= 'Then start all over again. ';
	}
}

if(@$_POST['submit'] == 'Submit' && empty($error)) {
	if(strlen($admin_username) < 5 || strlen($admin_username) > 20)
		$error .= 'Admin username can have between 5 and 20 characters. ';
	if(preg_match('/[^a-zA-Z0-9_]/', $admin_username))
		$error .= "Admin username must only have letters, numbers or underscore characters. ";
	if(strlen($admin_password) < 5 || strlen($admin_password) > 255)
		$error .= 'Admin password can have between 5 and 255 characters. ';
	if($admin_password != $admin_confirm_password)
		$error .= 'Admin password and confirmation password do not match. ';
	if(!filter_var($admin_email, FILTER_VALIDATE_EMAIL))
		$error .= 'Admin email is not valid. ';
	
	if(empty($error)) {
		$mysqli = new mysqli();
		$connected = @$mysqli->real_connect($db_host, $db_user, $db_password, $db_name);
		if($connected) {
			$tables = array('address', 'admin', 'category', 'contact_message', 'manufacturer', 
							'order_product', 'orders', 'product', 'product_image', 'user', 'user_company', 'user_person');
			$q = "show tables";
			$res = $mysqli->query($q);
			$arr = $res->fetch_all();
			$conflicts = array();
			foreach($arr as $row)
				if(in_array($row[0], $tables))
					$conflicts[] = $row[0];
				
			if(count($conflicts) == 0) {
			
				$filename = dirname(dirname(__FILE__)) . '/sql/create.sql';
				$q = file_get_contents($filename);
				$mysqli->multi_query($q);
				
				if(count($mysqli->error_list) > 0) {
					$error .= 'There have been errors while creating tables in the database: ';
					$arr = array();
					for($i = 0; $i < count($mysqli->error_list); $i++)
						foreach($mysqli->error_list[$i] as $key => $value)
							$arr[] = $value;
					$error .= implode(', ', $arr) . '. ';
				}
				$mysqli->close();
			
				$mysqli = new mysqli();
				$connected = @$mysqli->real_connect($db_host, $db_user, $db_password, $db_name);
				if(!$connected)
					$error .= 'Could not reconnect to the database for creating the admin account. ';
				
				if(empty($error)) {
					$user_id = 1;
					$user_username = $admin_username; 
					$user_password = password_hash($admin_password, PASSWORD_DEFAULT);
					$user_email = md5($admin_email);
					$user_email2 = tools_encrypt($admin_email, $openssl_key);
					$user_acc_type = "admin";
					$user_active = 1;
					$q = "insert into user(id, username, password, email, email2, acc_type, active) values(
						'" . $mysqli->real_escape_string($user_id) . "',
						'" . $mysqli->real_escape_string($user_username) . "',
						'" . $mysqli->real_escape_string($user_password) . "',
						'" . $mysqli->real_escape_string($user_email) . "',
						'" . $mysqli->real_escape_string($user_email2) . "',
						'" . $mysqli->real_escape_string($user_acc_type) . "',
						'" . $mysqli->real_escape_string($user_active) . "')";
					if(!$mysqli->query($q))
						$error .= 'Could not insert admin account into the database. ' . $mysqli->error . '. ';
					
					if(!$mysqli->query('insert into admin(id_admin, is_admin) values(1, 1) '))
						$error .= 'Error while creating the admin account. ' . $mysqli->error . '. ';
				}
				
				$mysqli->close();
				
				if(empty($error)) {
					$config_contents = file_get_contents($config_filename);
					$config_install_s = '<?php
//###############################################
//# INSTALL										#
//###############################################
define("APP_NAME", "' . addslashes($APP_NAME) . '"); // how do you want your site to be called?

define("BASE_HREF", "' . addslashes($BASE_HREF) . '");
$arr = parse_url(BASE_HREF);
$temp = substr( $_SERVER["PHP_SELF"], strlen($arr["path"]) );
define("THIS_DIR", dirname($temp) . "/");
define("THIS_PAGE", basename($_SERVER["PHP_SELF"]));

$this->cfg["default_currency"] = "' . addslashes($default_currency) . '";
$this->cfg["shop_invoice_info"] = "' . addslashes($shop_invoice_info) . '"; // this will appear in proforma
$this->cfg["openssl_key"] = "' . addslashes($openssl_key) . '";

$this->cfg["db"] = array(
	"host" => "' . addslashes($db_host) . '",
	"user" => "' . addslashes($db_user) . '",
	"pass" => "' . addslashes($db_password) . '",
	"name" => "' . addslashes($db_name) . '"
);

define("INSTALL_DONE", true);

?>';
					$config_contents .= $config_install_s;
					if(!file_put_contents($config_filename, $config_contents))
						$error = 'Could not write config/config.php file after successful install. ';
					
					if(empty($error)) {
						if(!unlink(__FILE__))
							$error .= 'Could not delete the installation script after successful install. You must manually delete ' . __FILE__ . '. ';
						if(!rmdir(dirname(__FILE__)))
							$error .= 'Could not remove the installation directory after successful install. You must manually delete ' . dirname(__FILE__) . '. ';
					}
					
					if(empty($error)) {
						header("location: " . $BASE_HREF . "/login.php");
						exit;
					}
				}
			}
			else {
				$error .= 'Table names conflicts. ';
				$error .= 'This installation script is attempting to create tables in the database, but some of them already exist and cannot be overwritten. ';
				$error .= 'You need to create a new database with no tables in it. ';
				$error .= 'There are ' . count($conflicts) . ' table names conflicts: ';
				$error .= implode(', ', $conflicts);
				$error .= '. No changes have been made to the database. ';
			}
		}
		else {
			$error .= 'Could not connect to the database server. Configuration not completed. ';
		}
	}
}
?>
<html>
<head>
<base href="<?php echo $BASE_HREF; ?>">
<title>Katyshop2 configuration</title>
<style>
h1 {
	background-color: #aaaaaa;
	padding: 10px;
}
h2 {
	background-color: #dddddd;
	padding: 10px;
}
label {
	display: block;
	margin-bottom: 10px;
}
input.text {
	width: 250px;
	padding: 5px;
	display: block;
	font-size: 1.2em;
}
input.submit {
	padding: 10px;
	font-size: 1.2em;
}
textarea {
	display: block;
	font-size: 1.2em;
}
.error {
	color: red;
}
</style>
</head>

<body>
<h1>Katyshop2 configuration</h1>
<p>Welcome to the configuration script. All you need to do is enter the informations below and the site will be ready for use right away. Make sure config/config.php file is writable. Make it read-only after this configuration is done. </p>

<?php
if(!empty($error)) {
	?>
	<p class="error"><?php echo htmlspecialchars($error); ?></p>
	<?php
}
?>
<form action="install/index.php" method="post">
<div style="width: 300px; float: left; margin-right: 30px; ">
<h2>Shop info</h2>
<label>How do you want your site to be called? <input type="text" name="APP_NAME" value="<?php echo htmlspecialchars($APP_NAME); ?>" class="text"></label>
<label>Default currency: <input type="text" name="default_currency" value="<?php echo htmlspecialchars($default_currency); ?>" class="text"></label>
<label>Shop invoice info: 
	<textarea name="shop_invoice_info" style="width: 250px; height: 100px; "><?php echo htmlspecialchars($shop_invoice_info); ?></textarea>
	(this will appear in the invoices issued by your shop; it should contain your shop address, tax code, bank and IBAN)
</label>
</div>

<div style="width: 300px; float: left; margin-right: 30px; ">
<h2>Database connection</h2>
<label>MySQL server: <input type="text" name="db_host" value="<?php echo htmlspecialchars($db_host); ?>" class="text"></label>
<label>MySQL user: <input type="text" name="db_user" value="<?php echo htmlspecialchars($db_user); ?>" class="text"></label>
<label>MySQL password: <input type="password" name="db_password" value="<?php echo htmlspecialchars($db_password); ?>" class="text"></label>
<label>MySQL name: <input type="text" name="db_name" value="<?php echo htmlspecialchars($db_name); ?>" class="text"></label>
</div>

<div style="width: 300px; float: left; ">
<h2>Administrator account</h2>
<label>Username: <input type="text" name="admin_username" value="<?php echo htmlspecialchars($admin_username); ?>" class="text"></label>
<label>Password: <input type="password" name="admin_password" class="text"></label>
<label>Confirm password: <input type="password" name="admin_confirm_password" class="text"></label>
<label>Email: <input type="text" name="admin_email" value="<?php echo htmlspecialchars($admin_email); ?>" class="text"></label>
<p>The account you will be using to enter the admin area of your website.</p>
<input type="submit" name="submit" value="Submit" class="submit">
</div>

</form>
</body>
</html>