<?php
class usermodel extends Capsule
{
	/*public $name = "";
	public $pw = "";
	public $iroda = "";
	public $beosztas = "";
	public $username = "";
	public $config = [];*/

	public function Save($arr)
	{
		session_start();
		/*$this -> name = $arr[1];
		$this -> pw = $arr[0];
		$this -> beosztas = $arr[2];
		$this -> iroda = $arr[3];
		$this -> username = $arr[5];
		$this -> config = $this -> GetConf();*/
		$_SESSION['name'] = $arr[1];
		$_SESSION['pw'] = $arr[0];
		$_SESSION['beosztas'] = $arr[2];
		$_SESSION['iroda'] = $arr[3];
		$_SESSION['username'] = $arr[5];
		$_SESSION['config'] = $this -> GetConf();
		session_write_close();
	}

}
?>