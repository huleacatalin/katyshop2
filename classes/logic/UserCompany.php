<?php

/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

require_once(dirname(__FILE__) . "/UserPerson.php");

class UserCompany extends UserPerson
{
	// database stored properties
	var $id = 0;
	var $company_name = "";
	var $tax_code = "";
	var $bank = "";
	var $iban = "";
	var $comp_phone = "";
	var $comp_fax = "";
	var $comp_email = "";

	function __construct()
	{
		parent::__construct();
	}
	
	function validateCommonFields() {
		$errors = parent::validateCommonFields();
		
		if(strlen($this->company_name) < 3)
			$errors[] = "Company name must have at least 3 characters";
	
		$fields = array('company_name', 'tax_code', 'bank', 'iban', 'comp_phone', 'comp_fax', 'comp_email');
		$fieldNames = array('Company name', 'Tax code', 'Bank', 'IBAN', 'Company phone', 'Fax', 'Company email');
		for($i = 0; $i < count($fields); $i++) {
			$field = $fields[$i];
			if(strlen($this->$field) > 177)
				$errors[] = translate($fieldNames[$i]) . " " . translate("must have maximum 177 characters");
		}
		return $errors;
	}
	
	function toStr($humanReadable = false, $brief = false)
	{
		if($humanReadable)
		{
			$s = parent::toStr($humanReadable, $brief);
			if($brief)
			{
				$s .= "
" . translate("Company name") . ": {$this->company_name}
" . translate("Bank") . ": {$this->bank}
" . translate("IBAN") . ": {$this->iban}";
			}
			else
			{
				$s .= "
" . translate("Company account with details") . ":
" . translate("Company name") . ": {$this->company_name}
" . translate("Tax code") . ": {$this->tax_code}
" . translate("Bank") . ": {$this->bank}
" . translate("IBAN") . ": {$this->iban}
" . translate("Company phone") . ": {$this->comp_phone}
" . translate("Company fax") . ": {$this->comp_fax}
" . translate("Company email") . ": {$this->comp_email}
";
			}
			return $s;
		}
		else
		{
			return parent::toStr();
		}
	}

	function encrypt()
	{
		$arr = array('company_name', 'tax_code', 'bank', 'iban', 'comp_phone', 'comp_fax', 'comp_email');
		foreach($arr as $prop) {
			$this->$prop = Tools::encrypt($this->$prop, Application::getConfigValue('openssl_key'));
		}
		parent::encrypt();
	}
	
	function decrypt()
	{
		$arr = array('company_name', 'tax_code', 'bank', 'iban', 'comp_phone', 'comp_fax', 'comp_email');
		foreach($arr as $prop) {
			$this->$prop = Tools::decrypt($this->$prop, Application::getConfigValue('openssl_key'));
		}
		parent::decrypt();
	}
}









?>