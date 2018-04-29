<?php
namespace App\Core;

class Capsule
{
	public $source = null;
	
	public function Log($datas = [])
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
            $Logging -> WriteLog($datas);
            unset($datas, $Logging);
            
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

	public function AddUser($datas)
	{
		/*
		
		*		used by new user registration
		*		or user addition by admin
		
		*/
		if(self::SearchUser($datas["username"])) return false;
		$sql = $this -> Connect() -> prepare("
			insert into users 
			(
				name,
				username,
				beosztas,
				password,
				iroda_id,
				registry_date
			)
			values
			(
				:name,
				:username,
				:type,
				:password,	
				:office,
				'".date("Y-m-d H:i:s")."'
			)");
		$sql -> execute($datas);
		$sql = null;
        return true;
	}

	public function SearchUser($str)
	{
		/*

		*		if username reserved, return name
		*		else return false
		*		working with full username or replace character (%)
		*		used by AddUset and searching user by admin or boss

		*/
		$result = $this -> Download(5, ["username" => $str]);
		return $result ? array_map('current', $result) : false;
	}

	


	public function AddNewOffice($datas = ["name" => "", "address" => "", "config" => array()])
	{
		/*
		
		*		used by admin and boss site (and install ofc)

        */
        if(self::SearchOffice($datas["name"], $datas["address"])) return false;
        $config = empty($datas['config']) ? $GLOBALS['DefaultConfig'] : $datas['config'];
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
				".join(",",$config)."
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

	private function Download($func, $data)
	{
		$sql = $this -> Connect() -> prepare( $this -> SelectDownQuery($func) );
		$sql -> execute($data);
		// ha csak sor az eredmény, csak egy sorként adja vissza, ha nincs eredmény -> false
		$sql = $sql -> fetchAll(PDO::FETCH_ASSOC);
		return count($sql) > 1 ? $sql : count($sql) == 0 ? false : $sql[0];
	}

	protected function NoVarDownload($str)
	{
		$sql = $this -> Connect() -> prepare( $str );
        $sql -> execute();
        /*$sql = $sql -> fetchAll(PDO::FETCH_ASSOC);
        return count($sql) > 1 ? $sql : count($sql) == 0 ? false : $sql[0];*/
		return $sql -> fetchAll(PDO::FETCH_ASSOC);
		/*
		$sql = $sql -> fetchAll(PDO::FETCH_ASSOC);
		return count($sql) > 1 ? $sql : count($sql) == 0 ? false : $sql[0];
		// nem biztos hogy ide is kelleni fog
		*/
	}

	private function SelectDownQuery($func)
	{
		$str = '';
		switch($func)
		{
			case 0:		// user datas, bejelentkezésnél is ezt használom
				$str = "select password, name, beosztas, iroda_id from users where username = :username";
					break;

			case 1:		// user office config
				$str = "select prevmonth, nextmonth, userrefresh from irodahaz where id = :iroda_id";
					break;

			case 2:		// boss office config
				$str = "select prevmonth, nextmonth, bossrefresh from irodahaz where id = :iroda";
					break;

			case 3:		// admin office config
				$str = "select * from irodahaz where id = :iroda_id";
					break;

			case 4:		// search office which already exists
				$str = "select neve, cime, id from irodahaz where neve like :name or cime like :address";
					break;

			case 5:		// select all from a specified user
				$str = "select * from users where username like :username";
					break;
		}
		return $str;
	}

	private function Upload($func, $data)
	{
		$sql = $this -> Connect() -> prepare( $this -> SelectUpQuery($func) );
		return $sql -> execute($data) ? true : false;
	}

	private function SelectUpQuery($func)
	{
		$str = '';
		switch($func)
		{
			case 0:		// update last login date
				$str = "update users set last_login = '".date("Y-m-d H:i:s")."' where username = :username";
					break;
			case 1: // update user access level
				$str = "update users set beosztas = :beosztas where id = :user_id";
					break;
			case 2: // add new user // a hozzásférési szint listából választható, alaból sima user
				$str = " inserst into users (name, username, beosztas, password, iroda_id) values(:name, :username, :beosztas, :password, :iroda_id)";
					break;
			case 3: // add new office // default konfig használata pipa, ha nincs akkor kis táblázatba minden megadható, de kitöltve az alap értékekkel
				$str = "inset into irodahaz (neve, cime, prevmonth, nextmonth, a_consolerefresh, a_errorrrefresh, userrefresh, bossrefresh) values(:neve, :cime, :prevmonth, :nextmonth, :a_consolerefresh, :a_errorrrefresh, :userrefresh, :bossrefresh)";
					break;
			/*case 4: // upload days // a szrting másik felét a public function-be rakja össze
				$str = "insert into napok (request_id, day) VALUES";
                    break;*/
            case 5:
                $str = "insert into log_all values()";
                    break;
				
		}
		return $str;
	}

	public function DownloadOfficeConfig($func = null, $arr = [])
	{
		return $this -> Download($func, $arr);
    }

    public function LoginRequest($username = "", $pw = "")
	{
		/*if (!empty($_SERVER['HTTP_CLIENT_IP'])) $ip = $_SERVER['HTTP_CLIENT_IP'];
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else $ip = $_SERVER['REMOTE_ADDR'];*/


		$result = $this -> Download(0, ["username" => $username]);
        if(empty($result))
        {
            // nincs ilyen nevű felhasználó
            return false;
            //$this -> Log();
        }	
		if($pw == $result['password'])	// van ilyen felhasználó, jelszó ellenőrzés
		{
			$this -> Upload(0, ["username" => $username]); // dátum frissítés
			$result['username'] = $username;
            $result['settings'] = $this -> Download($result['beosztas'], array("iroda_id" => $result['iroda_id']));
			return $result;
		}
		else return false;
    }

	/**
	 * Get the value of source
	 */ 
	public function getSource()
	{
		return $this->source;
	}

	/**
	 * Set the value of source
	 *
	 * @return  self
	 */ 
	public function setSource($source)
	{
		$this->source = $source;

		return $this;
	}
}
?>