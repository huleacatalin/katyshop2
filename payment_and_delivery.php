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
<div id="content">
<h1><?php echo translate("Payment and delivery"); ?></h1>
<?php require_once(WEB_DIR . "/includes/print_messages.php"); ?>

<h2><?php echo translate("How do I pay?"); ?></h2>
<p>You can pay:
<ul>
<li>in cache, at delivery (for persons);</li>
<li>by bank payment order (persons or companies customers);</li>
</ul>
</p>

<p>Cache payment, for products delivered from the stock is made at delivery moment,
at the value from phone confirmation of the order. You pay the money to the
messenger who delivers you the products.</p>

<h2>Products delivery</h2>
<p>We deliver our product to locations from the entire country.
The products are stored as they were packaged and sealed by manufacturer
and they are under assurance on the route to delivery.</p>

<p>Minimal order value is 100 USD (without delivery taxes).</p>

<p>Delivery in New York:
<ul>
<li>FOR FREE to your address - if the value is more than 500 USD;</li>
<li>10 USD delivery fee - if the value is less than 500 USD; </li>
</ul>
</p>

<p>Delivery outside New York:
<ul>
<li>FOR FREE to your address - if the value is more than 500 USD;</li>
<li>20 USD delivery fee - if the value is less than 500 USD; </li>
<li>Return fee 20 USD - only if you pay in cache at delivery (fee required by courier delivery company);</li>
</ul>
</p>

</div>
<?php require_once(WEB_DIR . "/includes/right.php"); ?>
<?php require_once(WEB_DIR . "/includes/footer.php"); ?>
</body>
</html>