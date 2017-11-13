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

	/*public function AddUser($datas)
	{
		if(self::SearchUser($datas["username"])) return false;
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


	public function AddNewOffice($datas = ["name" => "", "address" => ""])
	{
		if(self::SearchOffice($datas["name"], $datas["address"])) return false;
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

	public function SearchOffice($name, $address)
	{
		return $this -> Download(4, ["name" => $name, "address" => $address]) ? true : false;
		// return true, ha az iroda neve vagy címe már használatban van
	}

	public function CustomSQL($letsee = [], $condition = [])
	{
		/*******************************
		*	how to use
		*	- az első tömbbre csak írd bele h melyik mezőket akarod látni
		*	- a másidik tömbbe írd bele, h melyik mező minek feleljen meg (where feltétel)
		*	- sehol nem kell táblanevet írni, megkeresi magának a program.
		*	- csak akkor működik, ha az adatbázisba nincs 2 egyforma nevű oszlop!!!
		********************************/
	/*	$tables = $this -> SearchTable($letsee);
		$already_joined = false;
		$join = "";
		if(count($tables) > 1)	// ha az elsőben több van felsorolva, működik
		{
			$table = "users";
			$others = array_filter($tables,function($str){return $str != "users";});
			if(count($others) > 1)
			{
				$join = $this -> SelectJoiner("each");
				$already_joined = true;
			}
			else
				$join = $this -> SelectJoiner($others[0]);
		}
		else $table = $tables[0];

		$c_table = $this -> SearchTable([$condition[0]]);
		if(!$already_joined) $join .= $this -> SelectJoiner($c_table);
		$condition = "where " . $c_table[0] . ".$condition[0] like '$condition[1]'";

		$sql = "select " .  join(", ",$letsee) . " from " . $table . " " . $join . " " . $condition;
		$table = $this -> Connect() -> query($sql) -> fetchAll(PDO::FETCH_NUM);
		return $table[0];
//	}

	private function SearchTable($arr)
	{
		global $db;
		$sql = "SELECT TABLE_NAME FROM information_schema.columns WHERE column_name in ('" . join("', '", $arr) . "') and TABLE_SCHEMA like '$db'";
		$table = $this -> Connect() -> query($sql) -> fetchAll(PDO::FETCH_NUM);
		return array_map('current', $table);
	}

	private function SelectJoiner($str)
	{
		$joiner = 
		[
			"inner join szabadsag on users.username = szabadsag.user_name ",
			"inner join irodahaz on users.irodahaz = irodahaz.iroda_id "
		];
		if($str == "szabadsag")
			return $joiner[0];
		elseif($str == "each")
			return implode(' ', $joiner);
		else
			return $joiner[1];
	}

	public function SearchUser($str)
	{
		$result = $this -> Download(6, ["username" => $str]);
		return $result ? array_map('current', $result) : false;
	}*/
	private function Download($func, $data)
	{
		$sql = $this -> Connect() -> prepare( $this -> SelectQuery($func) );
		$sql -> execute($data);
		return $sql -> fetchAll(PDO::FETCH_NUM);
	}

	private function SelectQuery($func)
	{
		$str = '';
		switch($func)
		{
			case 0:
				$str = "select password, name, beosztas, irodahaz from users where username like :username";
					break;

			case 1:
				$str = "select prevmonth, nextmonth, userrefresh from irodahaz where iroda_id = :iroda";
					break;

			case 2:
				$str = "select prevmonth, nextmonth, bossrefresh from irodahaz where iroda_id = :iroda";
					break;

			case 3:
				$str = "select * from irodahaz where iroda_id = :iroda";
					break;

			case 4:
				$str = "select neve, cime, iroda_id from irodahaz where neve like :name or cime like :address";
					break;

			case 5:
				$str = "select * from users where username like :username";
					break;

			case 6:
				$str = "select username from users where username like :username";
					break;
		}
		return $str;
	}

	public function LoginRequest($username = "", $pw="")
	{
		/*if (!empty($_SERVER['HTTP_CLIENT_IP'])) $ip = $_SERVER['HTTP_CLIENT_IP'];
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else $ip = $_SERVER['REMOTE_ADDR'];*/


		$result = $this -> Download(0, ["username" => $username]);

		if(empty($result))	return false;	// nincs ilyen nevű felhasználó
		else $result = $result[0];
		if($pw == $result[0])	// van ilyen felhasználó, jelszó ellenőrzés
			return $result;
		else return false;
	}

	public function GetConf()
	{
		$result = $this -> Download($_SESSION["beosztas"], ["iroda" => $_SESSION['iroda']]);
		return $result[0];
	}
}
?>