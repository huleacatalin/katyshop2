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

function validate_admin($admin) {
	$error = '';
	if(strlen($admin['username']) < 5 || strlen($admin['username']) > 20)
		$error .= 'Admin username can have between 5 and 20 characters. ';
	if(preg_match('/[^a-zA-Z0-9_]/', $admin['username']))
		$error .= "Admin username must only have letters, numbers or underscore characters. ";
	if(strlen($admin['password']) < 5 || strlen($admin['password']) > 255)
		$error .= 'Admin password can have between 5 and 255 characters. ';
	if($admin['password'] != $admin['confirm_password'])
		$error .= 'Admin password and confirmation password do not match. ';
	if(!filter_var($admin['email'], FILTER_VALIDATE_EMAIL))
		$error .= 'Admin email is not valid. ';
	
	return $error;
}

function table_names_conflicts($mysqli) {
	$error = '';
	$tables = array('address', '_admins', 'category', 'contact_message', 'manufacturer', 
					'order_product', '_orders', 'product', 'product_image', '_users', 'user_company', 'user_person');
	$q = "show tables";
	$res = $mysqli->query($q);
	$arr = $res->fetch_all();
	$conflicts = array();
	foreach($arr as $row)
		if(in_array($row[0], $tables))
			$conflicts[] = $row[0];
	
	if(count($conflicts) > 0) {
		$error .= 'Table names conflicts. ';
		$error .= 'This installation script is attempting to create tables in the database, but some of them already exist and cannot be overwritten. ';
		$error .= 'You need to create a new database with no tables in it. ';
		$error .= 'There are ' . count($conflicts) . ' table names conflicts: ';
		$error .= implode(', ', $conflicts);
		$error .= '. No changes have been made to the database. ';
	}
	return $error;
}

function create_sql_tables($mysqli) {
	$error = '';
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
	return $error;
}

function insert_admin($mysqli, $admin_username, $admin_password, $admin_email, $openssl_key) {
	$error = '';
	$user = array('id' => 1,
		'username' => $admin_username,
		'password' => password_hash($admin_password, PASSWORD_DEFAULT),
		'email' => md5($admin_email),
		'email2' => tools_encrypt($admin_email, $openssl_key),
		'acc_type' => "admin",
		'active' => 1
	);
	$q = "insert into _users(id, username, password, email, email2, acc_type, active) values(
		'" . $mysqli->real_escape_string($user['id']) . "',
		'" . $mysqli->real_escape_string($user['username']) . "',
		'" . $mysqli->real_escape_string($user['password']) . "',
		'" . $mysqli->real_escape_string($user['email']) . "',
		'" . $mysqli->real_escape_string($user['email2']) . "',
		'" . $mysqli->real_escape_string($user['acc_type']) . "',
		'" . $mysqli->real_escape_string($user['active']) . "')";
	if(!$mysqli->query($q))
		$error .= 'Could not insert admin account into the database. ' . $mysqli->error . '. ';
	
	if(!$mysqli->query('insert into _admins(id_admin, is_admin) values(1, 1) '))
		$error .= 'Error while creating the admin account. ' . $mysqli->error . '. ';
	
	return $error;
}

function write_config_contents($config_filename, $cfg) {
	$error = '';
	$config_contents = file_get_contents($config_filename);
	$config_install_s = '<?php
//###############################################
//# INSTALL										#
//###############################################
define("APP_NAME", "' . addslashes($cfg['APP_NAME']) . '"); // how do you want your site to be called?

define("BASE_HREF", "' . addslashes($cfg['BASE_HREF']) . '");
$arr = parse_url(BASE_HREF);
$temp = substr( $_SERVER["PHP_SELF"], strlen($arr["path"]) );
define("THIS_DIR", dirname($temp) . "/");
define("THIS_PAGE", basename($_SERVER["PHP_SELF"]));

$this->cfg["default_currency"] = "' . addslashes($cfg['default_currency']) . '";
$this->cfg["shop_invoice_info"] = "' . addslashes($cfg['shop_invoice_info']) . '"; // this will appear in proforma
$this->cfg["openssl_key"] = "' . addslashes($cfg['openssl_key']) . '";

$this->cfg["db"] = array(
	"host" => "' . addslashes($cfg['db_host']) . '",
	"user" => "' . addslashes($cfg['db_user']) . '",
	"pass" => "' . addslashes($cfg['db_password']) . '",
	"name" => "' . addslashes($cfg['db_name']) . '"
);

define("INSTALL_DONE", true);

?>';
	$config_contents .= $config_install_s;
	if(!file_put_contents($config_filename, $config_contents))
		$error = 'Could not write config/config.php file after successful install. ';
	
	return $error;
}

function delete_install() {
	$error = '';
	if(!unlink(__FILE__))
		$error .= 'Could not delete the installation script after successful install. You must manually delete ' . __FILE__ . '. ';
	if(!rmdir(dirname(__FILE__)))
		$error .= 'Could not remove the installation directory after successful install. You must manually delete ' . dirname(__FILE__) . '. ';
	return $error;
}

function redirect($BASE_HREF) {
	header("location: " . $BASE_HREF . "/login.php");
	exit;
}

$step = (int) @$_POST['step'];
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

$mysqli = new mysqli();
$connected = false;
if($step > 0) {
	if(empty($error))
		$connected = @$mysqli->real_connect($db_host, $db_user, $db_password, $db_name);
	if(!$connected)
		$error .= 'Could not connect to the database server. Configuration not completed. ';
}
if($step == 1) {
	if(empty($error))
		$error .= table_names_conflicts($mysqli);
	
	if(empty($error))
		$error .= create_sql_tables($mysqli);
	
	if($connected)
		$mysqli->close();
	
	if(!empty($error))
		$step = 0;
}
elseif($step == 2) {
	$admin = array('username' => $admin_username,
		'password' => $admin_password,
		'confirm_password' => $admin_confirm_password,
		'email' => $admin_email
	);
	$error .= validate_admin($admin);
	
	if(empty($error))
		$error .= insert_admin($mysqli, $admin_username, $admin_password, $admin_email, $openssl_key);
	
	if($connected)
		$mysqli->close();
	
	if(empty($error)) {
		$cfg = array('APP_NAME' => $APP_NAME,
			'BASE_HREF' => $BASE_HREF,
			'default_currency' => $default_currency,
			'shop_invoice_info' => $shop_invoice_info,
			'openssl_key' => $openssl_key,
			'db_host' => $db_host,
			'db_user' => $db_user,
			'db_password' => $db_password,
			'db_name' => $db_name
		);
		$error .= write_config_contents($config_filename, $cfg);
	}

	if(empty($error))
		$error .= delete_install();
	
	if(!empty($error))
		$step = 1;
	
	if(empty($error))
		redirect($BASE_HREF);
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
div.block {
	width: 300px; 
	float: left; 
	margin-right: 30px;
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
h3.step_1 {
	background-color: cccccc;
	width: 630px;
	padding: 10px;
}
h3.step_1 input.submit {
	float: right;
}
h3.step_2 {
	background-color: cccccc;
	width: 930px;
	padding: 10px;
}
h3.step_2 input.submit {
	float: right;
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
<p>Welcome to the configuration script. Make sure config/config.php file is writable. Make it read-only after this configuration is done. </p>

<?php
if(!empty($error)) {
	?>
	<p class="error"><?php echo htmlspecialchars($error); ?></p>
	<?php
}
?>
<form action="install/index.php" method="post">
<div class="block">
<h2>Shop info</h2>
<label>How do you want your site to be called? <input type="text" name="APP_NAME" value="<?php echo htmlspecialchars($APP_NAME); ?>" class="text"></label>
<label>Default currency: <input type="text" name="default_currency" value="<?php echo htmlspecialchars($default_currency); ?>" class="text"></label>
<label>Shop invoice info: 
	<textarea name="shop_invoice_info" style="width: 250px; height: 100px; "><?php echo htmlspecialchars($shop_invoice_info); ?></textarea>
	(this will appear in the invoices issued by your shop; it should contain your shop address, tax code, bank and IBAN)
</label>
</div>

<div class="block">
<?php
$readonly = ($step == 1) ? 'readonly' : '';
?>
<h2>Database connection</h2>
<label>MySQL server: <input type="text" name="db_host" value="<?php echo htmlspecialchars($db_host); ?>" class="text" <?php echo $readonly; ?>></label>
<label>MySQL user: <input type="text" name="db_user" value="<?php echo htmlspecialchars($db_user); ?>" class="text" <?php echo $readonly; ?>></label>
<label>MySQL password: <input type="password" name="db_password" value="<?php echo htmlspecialchars($db_password); ?>" class="text" <?php echo $readonly; ?>></label>
<label>MySQL database name: 
	<input type="text" name="db_name" value="<?php echo htmlspecialchars($db_name); ?>" class="text" <?php echo $readonly; ?>>
	(the name of an existing empty database)
</label>
</div>

<?php
$hidden = ($step == 0) ? 'style="display: none; "' : '';
?>
<div class="block" <?php echo $hidden; ?>>
<h2>Administrator account</h2>
<label>Username: <input type="text" name="admin_username" value="<?php echo htmlspecialchars($admin_username); ?>" class="text"></label>
<label>Password: <input type="password" name="admin_password" class="text"></label>
<label>Confirm password: <input type="password" name="admin_confirm_password" class="text"></label>
<label>Email: <input type="text" name="admin_email" value="<?php echo htmlspecialchars($admin_email); ?>" class="text"></label>
<p>The account you will be using to enter the admin area of your website.</p>
</div>

<br clear="all">
<?php
if($step == 0) {
	?>
	<h3 class="step_1">
	Step 1: Creating the database
	<input type="hidden" name="step" value="1">
	<input type="submit" value="Next &gt;" class="submit">
	<br clear="all">
	</h3>
	<?php
}
elseif($step == 1) {
	?>
	<h3 class="step_2">
	Step 2: Creating the website admin account
	<input type="hidden" name="step" value="2">
	<input type="submit" value="Next &gt; " class="submit">
	<br clear="all">
	</h3>
	<?php
}
?>

</form>
</body>
</html>