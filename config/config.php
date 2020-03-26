<?php

/**
 * Product: Katyshop2
 * @version 2.4
 * @author Catalin Hulea - catalinhulea@users.sourceforge.net
 * @copyright Copyleft 2020 Catalin Hulea
 * @license GNU General Public License version 3
 * 			You can find a copy of GNU GPL v3 in the main folder
 * @link https://sourceforge.net/projects/katyshop2
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * THIRD PARTY
 * classes/common/date http://pear.php.net/package/Date
 * classes/common/phpmailer http://phpmailer.sourceforge.net
 * classes/common/resizeimage.php http://phpclasses.solarix.biz/browse/package/2179.html
 */

// this file has no global variables because it is required()
// in Application::loadConfig()
// That means all variables in this file have local scope,
// restricted to Application::loadConfig()
if(empty($this) || !is_a($this, "Application")) 
	die("config file may only be included from Application::loadConfig()"); // don't edit this

error_reporting(E_ALL);
$this->cfg = array(); //main configuration

header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

//###############################################
//# CONSTANTS									#
//###############################################
define("DATA_DIR", dirname(dirname(__FILE__)) . "/data");
define("WEB_DIR", dirname(dirname(__FILE__)));

//###############################################
//# LOGGER										#
//###############################################
$this->cfg["logger"] = array(
	"active" => false,
	"errors_active" => true,
	"messages_active" => false,
	"vardump_active" => false,
	"request_active" => false,

	"filename" => "logger.log",
	"errors_filename" => "errors.log",
	"messages_filename" => "messages.log",
	"vardump_filename" => "vardump.log",
	"request_filename" => "request.log"
);

//###############################################
//# DATE FORMAT									#
//###############################################
// how should dates be displayed on the website?
$this->cfg["date_format"] = array(
	"date" => "MM/DD/YYYY",
	"time" => "H:i:s",
	"date_time" => "MM/DD/YYYY H:i:s",
	"separator_date" => "/",
	"separator_time" => ":",
	"separator_date_time" => " "
);

//###############################################
//# MAIL AGENT									#
//###############################################
$this->cfg["mail_agent"] = array(
	"CharSet" => "iso-8859-1",
	"ContentType" => "text/plain",
	"From" => "noreply@" . $_SERVER['SERVER_NAME'],
	"FromName" => "Support Team", 

	// Method to send mail: ("mail", "sendmail", or "smtp").
	"Mailer" => "mail",
	"Sendmail" => "/usr/sbin/sendmail",

	// absolute path to dir where the class.smtp.php file is located
	"PluginDir" => dirname(dirname(__FILE__)) . "/classes/common/phpmailer",
	"Hostname" => $_SERVER['SERVER_NAME'], // *important*

	// for SMTP:
	"Host" => "localhost",
	"Port" => 25,
	"SMTPAuth" => false,
	"Username" => "",
	"Password" => ""
);
?>