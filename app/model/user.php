<?php
class user extends Capsule
{
	public $name = "";
	public $pw = "";
	public $iroda = "";
	public $beosztas = "";
	public $config = [];

	public function Save($arr)
	{
		/*$_SESSION["logged_in"] = true;
		$_SESSION["psw"] = $result[0];
		$_SESSION["name"] = $result[1];
		$_SESSION["beosztas"] = $result[2];
		$_SESSION["iroda"] = $result[3];*/
		$this -> name = $arr[1];
		$this -> pw = $arr[0];
		$this -> beosztas = $arr[2];
		$this -> iroda = $arr[3];
		$this -> config = $this -> GetConf($this -> iroda);
	}

}
?>