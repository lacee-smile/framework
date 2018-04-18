<?php
class usermodel //extends login
{
    protected $name = "";
    protected $pw = "";
    protected $iroda = "";
    protected $beosztas = "";
    protected $username = "";
    protected $settings = [];

	public function Save($arr)
	{
        
		//session_start();
		$this -> name = $arr['name'];
		$this -> pw = $arr['password'];
		$this -> beosztas = $arr['beosztas'];
		$this -> iroda = $arr['iroda_id'];
		$this -> username = $arr['username'];
        $this -> settings = $arr['settings'];
		/*$_SESSION['name'] = $arr['name'];
		$_SESSION['pw'] = $arr['pw'];
		$_SESSION['beosztas'] = $arr['beosztas'];
		$_SESSION['iroda'] = $arr['iroda'];
        $_SESSION['username'] = $arr['username'];
        $_SESSION['config'] = $arr['config'];*/
		//session_write_close();
	}

}
?>