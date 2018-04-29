<?php
use App\Core\Capsule;
class Logging extends Capsule
{
    // alakítsd át, hogy ne fájlba mentse, hanem adatbázisba
    // adatbázis tábla neve: log_all
    // használd a $this -> Upload(5, $datas = []);
    // return value (debughoz) az sql lesz.
	private $file = null;
	public $log_type = null;

	public function WriteLog($datas)
	{
		$message = "";
		switch($this -> log_type)
			{
				case 0: 
				{
					$this -> file = "mysql_logs";
					$message = "MySQL query error, message: " . $datas[0] . " in " . $datas[1] . " on line " . $datas[2];
				}break;
				case 1: 
				{
					$this -> file = "login_and_logout";
					$message = $datas[0] . " logged in from " . $datas[1];
				}break;
				case 2: 
				{
					$this -> file = "login_and_logout";
					$message = $datas[0] . " logged out from " . $datas[1];
				}break;
				case 3: 
				{
					$this -> file = "failed_login";
					$message = $datas[0] . " tried to log in with incorrent password from: " . $datas[1];
				}break;
				case 4: 
				{
					$this -> file = "admin_actions";
					$message = $datas[0] . $datas[1] . " from " . $datas[2];
				}break;
				case 5: 
				{
					$this -> file = "logs/petitions";
					$message = $datas[0] . " requested a day(s) off to : " . join(', ',$datas[1]);
				}break;
				default: echo "Ezt a típusú hibaüzenetet még nem ismerem :D";
			}

		$date = date("Y.m.d H:i:s");
		$this -> Write_Error($date . " " . $message);
		unset($date,$message);
	}
	private function Write_Error($message)
	{
		$file = fopen("../app/logs/" . $this -> file . ".log","a");
        fwrite($file,$message.PHP_EOL);
		fclose($file);
		unset($file);
	}
}
?>