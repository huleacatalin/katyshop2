
/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */

function showCompanyForm()
{
	document.getElementById("div_company").style.display = "block";
}

function hideCompanyForm()
{
	document.getElementById("div_company").style.display = "none";
}

function showPersonForm()
{
	document.getElementById("div_person").style.display = "block";
}

function hidePersonForm()
{
	document.getElementById("div_person").style.display = "none";
}

function changePassword()
{
	document.getElementById("tbl_change_password").style.display = "none";
	document.getElementById("tbl_new_password").style.display = "block";
}

function logout()
{
	var frm = document.getElementById("logout_form");
	frm.submit();
}
