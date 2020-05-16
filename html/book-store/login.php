<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

?>
<html>
<head>
<title><?php echo htmlspecialchars(APP_NAME); ?></title>
<?php require_once(dirname(__FILE__) . "/includes/html_head.php"); ?>
</head>

<body>
<!--  Free CSS Templates from www.templatemo.com -->
<div id="templatemo_container">
<?php require_once(dirname(__FILE__) . "/includes/header.php"); ?>
    <div id="templatemo_content">
<?php require_once(dirname(__FILE__) . "/includes/left.php"); ?>
        <div id="templatemo_content_right">
<main>
<h1><?php echo htmlspecialchars(translate("Login")); ?></h1>
<?php require_once(dirname(__FILE__) . "/includes/print_messages.php"); ?>

<form action="formparser/user.php?action=login" method="post">
<label><?php echo htmlspecialchars(translate("Username")); ?>: <input type="text" name="username" required class="text"></label>
<label><?php echo htmlspecialchars(translate("Password")); ?>: <input type="password" name="password" required class="text"></label>
<label><input type="checkbox" name="remember_password" value="1"> <?php echo htmlspecialchars(translate("Remember my password")); ?></label>
<input type="submit" value="<?php echo htmlspecialchars(translate("Login")); ?>" class="button">
</form>

<ul>
<li><a href="register.php" style="font-weight: bold; font-size: 1.4em; "><?php echo htmlspecialchars(translate("Register new account")); ?></a></li>
<li><a href="forgot_password.php"><?php echo htmlspecialchars(translate("Password or activation code forgotten?")); ?></a></li>
<li><a href="activate.php"><?php echo htmlspecialchars(translate("Activation link")); ?></a></li>
</ul>

</main>
            <div class="cleaner_with_height">&nbsp;</div>
        </div> <!-- end of content right -->
<?php /* require_once(dirname(__FILE__) . "/includes/right.php"); */ ?>

    	<div class="cleaner_with_height">&nbsp;</div>
    </div> <!-- end of content -->
    
<?php require_once(dirname(__FILE__) . "/includes/footer.php"); ?>
<!--  Free CSS Template www.templatemo.com -->
</div> <!-- end of container -->
<!-- templatemo 086 book store -->
<!-- 
Book Store Template 
http://www.templatemo.com/preview/templatemo_086_book_store 
-->
</body>
</html>