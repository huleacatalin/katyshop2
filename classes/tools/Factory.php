<?php

/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

class Factory
{
	/**
	 * @param User $user
	 * @return User
	 */
	static function instantiateUser($user)
	{
		$db = Application::getDb();
		$ret = new User();
		switch (@$user->acc_type)
		{
			case "person":
				$ret = $db->tbUserPerson->getRecordById($user->id);
				break;
			case "company":
				$ret = $db->tbUserCompany->getRecordById($user->id);
				break;
			case "admin":
				$ret = $db->tbAdmin->getRecordById($user->id);
				break;
			default:
				break;
		}
		return $ret;
	}
	
}

?>