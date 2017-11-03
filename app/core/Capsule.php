<?php

class Capsule
{
	public function Log($log = null, $message = [])
	{
		/*
		*
		*	0 -> mysql hibaüzenet (mysql hibaüzenet, file, fájlsor)
		*	1 -> log in (név, ipcím)
		*	2 -> log out (név, ipcím)
		*	3 -> failed log (név, ip, vpnip)
		*	4 -> admin művelet (név, művelet)
		*	5 -> kérések (név, dátumok)
		*
		*/
		global $log_enabled;
		if($log_enabled)
		{
			$Logging = new Logging;
			$Logging -> log_type = $log;
			$Logging -> WriteLog($message);
			unset($log, $message, $Logging);
		}
		//else echo "Nincs engedélyezve a logolás";
		//return null;
	}

	private function Connect()
	{
		global $server, $user, $pw, $db;
		$connect = new mysqli($server, $user, $pw, $db);
		if ($connect -> connect_errno)
    	{
           $this -> Log(0, [$connect -> connect_error, basename(__FILE__), basename(__LINE__-3)]);
           echo $connect -> connect_error;
           die();
        }
        $connect -> set_charset("utf8");
		return $connect;
	}

	private function Process($obj)
	{
		while($row = $obj -> fetch_array(MYSQL_NUM)) $arr[] = $row;
		return $arr;
	}

	private function Download($str)
	{
		$result = $this -> Connect() -> query($str);
		$result = $this -> Process($result);
		$this -> Connect() -> close();
		return $result;
	}

	public function Upload($str)
	{
		$this -> Connect() -> query($str);
	}

	public function LoginRequest($username, $pw)
	{
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) $ip = $_SERVER['HTTP_CLIENT_IP'];
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else $ip = $_SERVER['REMOTE_ADDR'];
		$sql = "select password, name, beosztas, irodahaz from users where username = '$username' ";
		$result = $this -> Download($sql);
		$result = $result[0];
		if($pw === $result[0])
			{
				$this -> Log(1, [$username, $ip]);
				return $result;
			}
		else
			{
				$this -> Log(3, [$username, $ip]);
				return false;
			}
	}

	public function GetConf($iroda)
	{
		$sql = "select settings from irodahaz where iroda_id = " . $iroda;
		$result = $this -> Download($sql);
		var_dump($result);die();
		return $result[0];
	}
}
?>