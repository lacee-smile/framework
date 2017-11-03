<?php
class login extends Capsule
{
	public function request()
	{
		return $this -> LoginRequest($_POST['username'], hash("md5", $_POST["password"]));
	}
}
?>