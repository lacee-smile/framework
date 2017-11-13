<?php
/*
*	default oldalt nem bejelentkezett felhasználóknak
*/
class home extends Controller
{
	public $user = null;

	public function index()
	{
		session_start();
		if(file_exists("../app/controller/install.php"))
		{
			/*
				not installed database
			*/
			header("Location: /install");
		}
		elseif(empty($_SESSION["username"]))
		{
			/*
				installed database, home screen
			*/
			$this -> view('home/index', ["heading", "LoginForm"]);
		}
		else
		{
			echo json_encode([true, $_SESSION["username"]]);
			header("Location: /".$this ->username);
		}
	}

	public function login()
	{
		if(!isset($_POST['username'])) header("Location: /");
		else $result = $this -> model("login") -> request();
		if($result)
		{
			$this -> user = $this -> model("usermodel");
			$this -> user -> Save($result);
			header("Location: /" . $_SESSION["username"]);

			/*$this -> model("usermodel") -> Save($result); 
			header("Location: /" . $result["name"]);
			/******************************************
			*		sikertes bejelentkezés
			********************************************/
		}
		else
		{
			unset($_POST);
			echo json_encode([false, 'Hibás felhasználónév vagy jelszó!']);
			$this -> view('home/index');
			session_start();
			session_destroy();	// amíg nincs logout, addig ez jelentkeztet ki /home/login bárhonnan
			/******************************************
			*		sikertelen bejelentkezés
			********************************************/
		}
	}
}
?>