<?php
/*
*	default oldalt nem bejelentkezett felhasználóknak
*/
class home extends Controller
{
	public function index()
	{		
		if(file_exists("../app/controller/install.php"))
			header("Location: /install");
		/*
		* 	
		*/
		else $this -> view('home/index');
	}

	public function login()
	{
		$login = $this -> model("login");
		$result = $login -> request();
		if($result)
		{
			/*
			*	
			*/
			$this -> model("user") -> Save($result);
			/*session_start();
			$_SESSION["logged_in"] = true;
			$_SESSION["psw"] = $result[0];
			$_SESSION["name"] = $result[1];
			$_SESSION["beosztas"] = $result[2];
			$_SESSION["iroda"] = $result[3];*/
			header("Location: /user");
		}
		else
		{
			header("Location: ../");
		}
	}
}
?>