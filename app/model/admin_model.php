<?php
class admin_model extends Capsule
{
	public function GetUsersList()
	{
		return $this -> NoVarDownload("select name, username, beosztas, iroda_id, last_login from users");
	}

	public function GetOfficesList()
	{
		return $this -> NoVarDownload("select neve, id from irodahaz");
	}

	public function AddNewUser()
	{
		// adatok feldolgozása biztonságos formátumra
		/* $this -> AddUser(array(
			"name"	=> ,
			"username"	=> ,
			"type"	=> ,
			"password" => ,	
			"office" => ,
		));*/
	}

}
?>