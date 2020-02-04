<?php
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

$dir = dirname(__FILE__);
require_once("$dir/classes/Application.php");

require_once("$dir/classes/common/BaseClass.php");
require_once("$dir/classes/common/BaseObject.php");
require_once("$dir/classes/common/Compat.php");
require_once("$dir/classes/common/DateFormat.php");
require_once("$dir/classes/common/Logger.php");
require_once("$dir/classes/common/LogicObject.php");
require_once("$dir/classes/common/MysqlDatabase.php");
require_once("$dir/classes/common/MysqlTable.php");
require_once("$dir/classes/common/resizeimage.php");
require_once("$dir/classes/common/SessionWrapper.php");
require_once("$dir/classes/common/Tools.php");
require_once("$dir/classes/common/UploadFile.php");

require_once("$dir/classes/common/phpmailer/class.phpmailer.php");
require_once("$dir/classes/common/phpmailer/class.smtp.php");

require_once("$dir/classes/dblayer/Database.php");
require_once("$dir/classes/dblayer/TableAddress.php");
require_once("$dir/classes/dblayer/TableAdmin.php");
require_once("$dir/classes/dblayer/TableCategory.php");
require_once("$dir/classes/dblayer/TableContactMessage.php");
require_once("$dir/classes/dblayer/TableManufacturer.php");
require_once("$dir/classes/dblayer/TableOrder.php");
require_once("$dir/classes/dblayer/TableOrderProduct.php");
require_once("$dir/classes/dblayer/TableProduct.php");
require_once("$dir/classes/dblayer/TableProductImage.php");
require_once("$dir/classes/dblayer/TableUser.php");
require_once("$dir/classes/dblayer/TableUserCompany.php");
require_once("$dir/classes/dblayer/TableUserPerson.php");

require_once("$dir/classes/logic/Address.php");
require_once("$dir/classes/logic/Admin.php");
require_once("$dir/classes/logic/Category.php");
require_once("$dir/classes/logic/ContactMessage.php");
require_once("$dir/classes/logic/Manufacturer.php");
require_once("$dir/classes/logic/Order.php");
require_once("$dir/classes/logic/OrderProduct.php");
require_once("$dir/classes/logic/Product.php");
require_once("$dir/classes/logic/ProductImage.php");
require_once("$dir/classes/logic/User.php");
require_once("$dir/classes/logic/UserCompany.php");
require_once("$dir/classes/logic/UserPerson.php");
require_once("$dir/classes/logic/Visitor.php");

require_once("$dir/classes/tools/AppMailAgent.php");
require_once("$dir/classes/tools/Factory.php");

require_once("$dir/includes/functions.php");

$Application = Application::createInstance();
?>