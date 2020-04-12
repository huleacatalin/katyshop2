<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(__FILE__) . "/init.php");
?>
<html>
<head>
<title><?php echo APP_NAME; ?></title>
<?php require_once(WEB_DIR . "/includes/html_head.php"); ?>
</head>

<body>
<?php require_once(WEB_DIR . "/includes/header.php"); ?>
<?php require_once(WEB_DIR . "/includes/left.php"); ?>
<main>
<h1><?php echo translate("Terms and conditions"); ?></h1>
<?php require_once(WEB_DIR . "/includes/print_messages.php"); ?>
<article>
<h2>1. Introductions</h2>

<p>Add here your introductory paragraph about terms and conditions.</p>

<h2>2. Security and confidentiality personal informations</h2>

<p>Add here your legal text about...</p>

<h2>3. Partners</h2>

<p>text here....</p>

<h2>4. Waranty</h2>

<p>text here...</p>

<h2>5. Promotions and contests</h2>

<p>text here...</p>

<h2>6. Typos</h2>

<p>text here...</p>

<h2>7. Taxes</h2>

<p>text here...</p>

<h2>8. Conflicts</h2>

<p>oh no no no...</p>

</article>
</main>
<?php require_once(WEB_DIR . "/includes/right.php"); ?>
<?php require_once(WEB_DIR . "/includes/footer.php"); ?>
</body>
</html>