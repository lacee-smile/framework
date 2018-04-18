<?php
class user extends Capsule
{
    public $name = "def value";
    public $pw;
    public $iroda;
    public $beosztas;
    public $username;
    public $settings;

	public function login()
	{
        $result = $this -> LoginRequest($_POST['username'], hash("md5", $_POST["password"]));
		if($result)
		{
            $_SESSION['user'] = $result;
           // print_pre($_SESSION, true);
            /*
            $this -> name = $result['name'];
            $this -> pw = $result['password'];
            $this -> beosztas = $result['beosztas'];
            $this -> iroda = $result['iroda_id'];
            $this -> username = $result['username'];
            $this -> settings = $result['settings'];
            // save to session with specific key, and hashed values
            $_SESSION["username"] = $result['username'];*/
            session_write_close();
			return true;
		}
		else
		{
			return false;
		}
    }

    public function getUser()
    {
        return array(
            "username" =>   $this -> username,
            "name"  =>  $this -> name,
            "beosztas"  =>  $this -> beosztas
        );
    }
}

?>