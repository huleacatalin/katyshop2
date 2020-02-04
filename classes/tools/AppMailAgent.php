<?php

/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

class AppMailAgent extends PHPMailer
{
	function __construct()
	{
		$cfg = Application::getConfigValue("mail_agent");

		// get default configuration from $cfg["mail_agent"]
		$arr = get_class_vars(get_class($this));
		foreach ($arr as $key => $value)
		{
			if(array_key_exists($key, $cfg))
				$this->$key = $cfg[$key];
		}
	}

	//###################################
	//# OVERRIDE BASE CLASS METHODS		#
	//###################################

	function clear()
	{
		parent::ClearAddresses();
		parent::ClearAllRecipients();
		parent::ClearAttachments();
		parent::ClearBCCs();
		parent::ClearCCs();
		parent::ClearCustomHeaders();
		parent::ClearReplyTos();
	}

	function Send()
	{
		$ret = parent::Send();
		$this->clear();
		return $ret;
	}

	//###################################
	//# CUSTOM APPLICATION METHDOS		#
	//###################################

	/**
	 * @param User $user
	 */
	function registrationMail($user, $pass)
	{
		$escPass = htmlspecialchars($pass);
		$this->AddAddress($user->email2);
		$this->AddReplyTo($this->From, $this->FromName);
		$this->Subject = APP_NAME . " - account created";

		$this->Body = "
			<div style=\"padding: 10px; background-color: #fffaf4; color: #582f06; font-family: verdana; font-size: 10pt;\">
			<h1 style=\"font-size: 10pt; border: 1px solid #a17f60;	padding: 5px; \">Hello {$user->username},</h1>

			<p>Welcome to " . APP_NAME . ", thank you for your registration.</p>
			<pre>
			----------------------------
			Username: {$user->username}
			Password: $escPass
			Activation code: {$user->activation_code}
			----------------------------
			</pre>

			<p>Please click the following link in order to activate your account:</p>

			<a href=\"" . BASE_HREF . "activate.php?username={$user->username}&activation_code={$user->activation_code}\" style=\"color: #582f06; font-family: verdana; font-size: 10pt;\">
			" . BASE_HREF . "activate.php?username={$user->username}&activation_code={$user->activation_code}
			</a>
			</div>
			";
		
		$this->AltBody = "
			Hello {$user->username},

			Welcome to " . APP_NAME . ", thank you for your registration.

			----------------------------
			Username: {$user->username}
			Password: $escPass
			Activation code: {$user->activation_code}
			----------------------------

			Please click the following link in order to activate your account:

			" . BASE_HREF . "activate.php?username={$user->username}&activation_code={$user->activation_code}
			";
		Logger::vardump($this->AltBody, "mail body from mailagent->registrationMail()", __FILE__, __LINE__);
		return $this->Send();
	}

	/**
	 * @param User $user
	 */
	function forgotPasswordMail($user, $pass)
	{
		$escPass = htmlspecialchars($pass);
		$this->AddAddress($user->email2);
		$this->AddReplyTo($this->From, $this->FromName);
		$this->Subject = APP_NAME . " - password changed";

		$shortActCode = "Activation code: {$user->activation_code}";
		$htmlActCode = "";
		$textActCode = "";
		if(!$user->wasActivated())
		{
			$shortActCode = "";

			$htmlActCode = "
			<p>Please click the following link in order to activate your account:</p>

			<a href=\"" . BASE_HREF . "activate.php?username={$user->username}&activation_code={$user->activation_code}\" style=\"color: #582f06; font-family: verdana; font-size: 10pt;\">
			" . BASE_HREF . "activate.php?username={$user->username}&activation_code={$user->activation_code}
			</a>";

			$textActCode = "
			Please click the following link in order to activate your account:

			" . BASE_HREF . "activate.php?username={$user->username}&activation_code={$user->activation_code}
			";
		}

		$this->Body = "
			<div style=\"padding: 10px; background-color: #fffaf4; color: #582f06; font-family: verdana; font-size: 10pt;\">
			<h1 style=\"font-size: 10pt; border: 1px solid #a17f60;	padding: 5px; \">Hello {$user->username},</h1>

			<p>Your password has been changed.</p>
			<pre>
			----------------------------
			Username: {$user->username}
			Password: $escPass
			$shortActCode
			----------------------------
			</pre>

			<p>This email is sent automatically because the 'forgot password' form
			on our site was used to change your password. You can see this form here:</p>
			<a href=\"" . BASE_HREF . "forgot_password.php\">" . BASE_HREF . "forgot_password.php</a>

			<p>You may now click on this link to login using the new random generated password:</p>
			<a href=\"" . BASE_HREF . "login.php\">" . BASE_HREF . "login.php</a>

			<p>After you login you can change your profile preferences here:</p>
			<a href=\"" . BASE_HREF . "profile_view.php\">" . BASE_HREF . "profile_view.php</a>

			$htmlActCode
			</div>
			";

		$this->AltBody = "
			Hello {$user->username},

			Your password has been changed

			----------------------------
			Username: {$user->username}
			Password: $escPass
			$shortActCode
			----------------------------

			This email is sent automatically because the 'forgot password' form
			on our site was used to change your password. You can see this form here:
			" . BASE_HREF . "forgot_password.php

			You may now click on this link to login using the new random generated password:
			" . BASE_HREF . "login.php

			After you login you can change your profile preferences here:
			" . BASE_HREF . "profile_view.php

			$textActCode
			";

		Logger::vardump($this->AltBody, "mail body from mailagent->forgotPasswordMail()", __FILE__, __LINE__);
		return $this->Send();
	}

	/**
	 * @param User $user
	 * @param Order $order
	 */
	function newOrder($user, $order)
	{
		$currency = Application::getConfigValue("default_currency");
		$this->AddAddress($user->email2);
		$this->AddCC($this->From, $this->FromName);
		$this->AddReplyTo($this->From, $this->FromName);
		$this->Subject = APP_NAME . " - new order";

		$s = "
			<h1>" . htmlspecialchars(APP_NAME) . " New order!</h1>

			<p>User " . htmlspecialchars($user->username) . " (" . htmlspecialchars($user->first_name . " " . $user->last_name) . ")
			has sent a new order with total value {$order->total} $currency. Ordered products are:
			";
		for($i = 0; $i < $order->getProductsCount(); $i++)
		{
			if($i > 0)
				$s .= ", ";
			$op = $order->getOrderProduct($i + 1);
			$s .= $op->quantity . " " . htmlspecialchars($op->measuring_unit) . " " . htmlspecialchars($op->product_name);
		}
		$s .= ".</p>
			<p>The proforma invoice is attached.</p>
			";
		$this->Body = $s;

		$s = "
			" . APP_NAME . " New order!

			User " . $user->username . " (" . $user->first_name . " " . $user->last_name . ")
			has sent a new order with total value " . displayPrice($order->total) . " $currency. Ordered products are:
			";
		for($i = 0; $i < $order->getProductsCount(); $i++)
		{
			if($i > 0)
				$s .= ", ";
			$op = $order->getOrderProduct($i + 1);
			$s .= $op->quantity . " " . $op->measuring_unit . " " . $op->product_name;
		}
		$s .= ".
			Attached is the proforma invoice.";
		$this->AltBody = $s;

		$filename = DATA_DIR . "/orders/{$order->code}.html";
		if(!is_file($filename))
		{
			Logger::err("could not find proforma file to attach to mail", __FILE__, __LINE__);
		}
		else
		{
			$encrypted = file_get_contents($filename);
			$decrypted = Tools::decrypt($encrypted, Application::getConfigValue('openssl_key'));
			$this->AddStringAttachment($decrypted, $order->code . ".html");
		}

		Logger::vardump($this->AltBody, "mail body from mailagent->newOrder()", __FILE__, __LINE__);
		return $this->Send();
	}

	function orderStatusChanged($id_order, $newStatus)
	{
		$db = Application::getDb();
		$order = $db->tbOrder->getRecordById($id_order);
		$u = $db->tbUser->getUserById($order->id_user);
		$u = Factory::instantiateUser($u);


		$currency = Application::getConfigValue("default_currency");
		$this->AddAddress($u->email2);
		$this->AddCC($this->From, $this->FromName);
		$this->AddReplyTo($this->From, $this->FromName);
		$this->Subject = APP_NAME . " - order status update";

		$this->Body = "
			<h1>" . htmlspecialchars(APP_NAME) . " Order status changed!</h1>

			<p>The status of the order {$order->code} sent by user " . htmlspecialchars($u->username) . " (" . htmlspecialchars($u->first_name . " " . $u->last_name) . ") has changed.
			The old status was '" . htmlspecialchars($order->status) . "', and now the new status is '" . htmlspecialchars($newStatus) . "'.</p>

			<p>The proforma invoice is attached to this mail.</p>
			";

		$this->AltBody = "
			" . APP_NAME . " order status update!

			The status of the order {$order->code} sent by user " . $u->username . " (" . $u->first_name . " " . $u->last_name . ") has changed.
			The old status was '" . $order->status . "', and now the new status is '" . $newStatus . "'.

			The proforma invoice is attached.
			";

		$filename = DATA_DIR . "/orders/{$order->code}.html";
		if(!is_file($filename))
		{
			Logger::err("could not find proforma file to attach to mail", __FILE__, __LINE__);
		}
		else
		{
			$this->AddAttachment($filename, $order->code . ".html", "base64", "text/html");
		}

		Logger::vardump($this->AltBody, "mail body from mailagent->orderStatusChanged()", __FILE__, __LINE__);
		return $this->Send();
	}

	/**
	 * @param ContactMessage $m
	 */
	function contactMessage($m)
	{
		$this->AddAddress($this->From, $this->FromName);
		$this->AddReplyTo($this->From, $this->FromName);
		$this->Subject = APP_NAME . " - contact message";

		$this->Body = '
			<h1>' . htmlspecialchars(APP_NAME) . ' - contact message</h1>
			<p>Visitor: ' . htmlspecialchars($m->sender_name) . ' (<a href="mailto:' . htmlspecialchars($m->sender_email) . '">' . htmlspecialchars($m->sender_email) . '</a></p>
			<p>Subject: <b>' . htmlspecialchars($m->subject) . '</b></p>
			<p>Message: <br><br>' . htmlspecialchars($m->message) . '</p>
			<br>
			<br>
			<h2>User details</h2>
			<p>' . htmlspecialchars($m->user_details) . '</p>
			';

		$this->AltBody = '
			' . APP_NAME . ' - contact message
			Visitor: ' . $m->sender_name . ' (' . $m->sender_email . ')
			Subject: ' . $m->subject . '
			Message:
			' . $m->message . '

			User details
			' . ($m->user_details) . '
			';

		Logger::vardump($this->AltBody, "mail body from mailagent->contactMessage()", __FILE__, __LINE__);
		return $this->Send();
	}


}


?>