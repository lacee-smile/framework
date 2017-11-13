<?php
class login extends Capsule
{
	public function request()
	{
		$result = $this -> LoginRequest($_POST['username'], hash("md5", $_POST["password"]));
		if($result)
		{
			switch($result[2])
			{
				case 'user': $result[2] = 1; break;
				case 'boss': $result[2] = 2; break;
				case 'admin': $result[2] = 3; break;
				default: "Valami hiba történt. Hibajelentés elküldve az adminnak!";
			}
			$result[5] = $_POST['username'];
			return $result;
		}
		else return false;
	}

}
?>