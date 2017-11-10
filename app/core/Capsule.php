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
		global $server, $db, $user, $pw;
		try
		{
			$conn = new PDO("mysql:host=$server;dbname=$db;charset=utf8", $user, $pw);
			$conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $conn;
    	}
		catch(PDOException $e)
		{
			echo "Connecion failed: " . $e -> getMessage();
		}
	}

	private function Download($str)
	{
		$pdo = $this -> Connect();
		$result = $pdo -> query($str);
		$result = $result -> fetchAll();
		if(empty($result))
			{
				// nincs eredménye a lekérdezésnek
				return false;
			}
		else
			{
				return $result;
			}
	}

	public function AddUser($datas)
	{
		if(self::CheckExistsUser($datas["username"])) return false;
		$sql = $this -> Connect() -> prepare("
			insert into users 
			(
				name,
				username,
				beosztas,
				password,
				irodahaz
			)
			values
			(
				:name,
				:username,
				:type,
				:password,	
				:office
			)");
		$sql -> execute($datas);
		$sql = null;
		return true;
	}

	private function CheckExistsUser($username)
	{
		$result = $this -> Download("select * from users where username like '$username'");
		return $result ? true : false;
	}

	public function AddNewOffice($datas = ["name", "address"])
	{
		if(self::CheckExistsOffice($datas["name"], $datas["address"])) return false;
		$sql = $this -> Connect() -> prepare("
			insert into irodahaz
			(
				neve,
				cime,
				prevmonth,
				nextmonth,
				a_consolerefresh,
				a_errorrefresh,
				userrefresh,
				bossrefresh
			)
			values
			(
				:name,
				:address,
				6,
				6,
				30,
				30,
				120,
				5
			);");
		$sql -> execute($datas);
		$sql = null;
		return true;
	}

	private function CheckExistsOffice($name, $address)
	{
		$result = $this -> Download("select * from irodahaz where neve like '$name'");
		if($result) return true; // irodanév foglalt
		$result = $this -> Download("select * from irodahaz where cime like '$address'");
		if($result) return true; // iroda cím foglalt
		return false; // iroda még nincs hozzáadva
	}

	public function LoginRequest($username, $pw)
	{
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) $ip = $_SERVER['HTTP_CLIENT_IP'];
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else $ip = $_SERVER['REMOTE_ADDR'];
		/*$sql = "select password, name, beosztas, irodahaz from users where username = '$username' ";
		$result = $this -> Download($sql);*/
		$sql = $this -> Connect() -> prepare("select password, name, beosztas, irodahaz from users where username = :username ");
		$sql -> bindParam(':username', $username);
		$result = $this -> Process($sql -> execute());
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
	}
}
?>