<?php
/*
*	default oldalt nem bejelentkezett felhasználóknak
*/


// change this to router
/*if(isset($_POST["login"]))
{
	$TryLogin = new home;
	$TryLogin -> login();
	$_POST["login"] = null;
}*/


class home extends Controller
{
	protected $user;
	public function __construct()
	{
		/*global $AjaxHandler;
		$AjaxHandler = get_called_class();*/
		if (session_status() == PHP_SESSION_NONE)
		{
			// ha még nem megy a session, elindítja
			session_start();
		}
		//$this -> user = $this -> model("user");
		// linuxon cron van beállítva minden vasárnap este 23:59-kor cserél sót, amiket random generál (32 char hosszú)
		// a pontos titkostási algoritmust még megtervezem
		// további feladatok:
		//	- táblázatok és sorra kattintva adatok betöltése (módosítás/szerkesztés)
		//	- a feltöltések működjenek
		//	- sütik kezelésének elsajátítása és használata
		//	- legalább az admin oldalon a formok működjenek
		//	- a user oldalon a szabadság kérelmek feltöltése
		//	- a főnöki oldalon az értesítés megjelenítése a config szerint időközönként
        //	- ha valaki sikeresen bejelentkezik, automatikusan töltse le a hozzátartozó irodai beállításokat
        //  - pls add night mode, at least for developer site  :( 
		//	- a user oldalon funkciók hozzáadása:
		//		- eddig kivett
		//		- még kivehető napok száma
		//		- ünnepnapok (ha össze lehet valahonnan kukázni..., bár ez fontos lenne, api vagy valami keresése)
		//	- főnoki oldal:
		// 		- értesítések
		//		- válogatás
        // 		- előléptetés/lefokozás (adminról másolható)
        //  - adatbázis telepítés ajax fixálás
	}

	public function index()
	{
		if(file_exists(Control."install.php"))
		{
			// a sikeres telepítés végén átnevezi önmagát a telepítő fájl.
			// tehát ha az eredeti nevén létezik, meg nem volt sikeres telepítés
			// ergó lehet ezzel ellenőrizni, és ha létezik átirányítani oda.
			header("Location: /install");
		}

		elseif(empty($_SESSION['user']['username']))
		{
			///
			//	installed database, home screen
			//
            //$this -> user = $this -> model('user');
            //print_pre(get_declared_classes());
            //Controller::view('home/index', ["LoginForm"]);
		}

		else
		{
			/*switch($this -> user -> getUser()['beosztas'])
			{
				case 1: $inc = 'user'; break;
				case 2: $inc = 'boss'; break;
				case 3: $inc = 'admin'; break;
				//default: $inc = 'home';
            }
			include Control.$inc.'.php';
			$controll = new $inc();*/
			switch($_SESSION['user']['beosztas'])
			{
				case 1: $inc = 'user'; break;
				case 2: $inc = 'boss'; break;
				case 3: $inc = 'admin'; break;
				//default: $inc = 'home';
            }
			include Control.$inc.'.php';
			$controll = new $inc();
		}
	}

	public function login()
	{
		if(!isset($_POST['login'])) 
		{
			header("Location: /");
		}
		else 
		{
			$result = $this -> model("user") -> login();
		}
		if($result)
		{
			//$this -> user = $result;
			//print_pre($result, true);
			header("Location: " . UrlBase . $_SESSION['user']['username']);
			/*print_pre($result);
			switch($result -> beosztas)
			{
				case 1: $inc = 'user'; break;
				case 2: $inc = 'boss'; break;
				case 3: $inc = 'admin'; break;
				//default: $inc = 'home';
            }
			include Control.$inc.'.php';
			$controll = new $inc();*/

			//header("Location: " . UrlBase . $_SESSION["username"]);
			///****************************************
			//*			sikeres bejelentkezés		  *
			// ****************************************/
		}
		else
		{
			//unset($_POST);
			//echo json_encode([false, 'Hibás felhasználónév vagy jelszó!']);
            //if(!isset($_POST['ajax']))
			$this -> view('home/index', ["LoginForm"]);
			echo 'Hibás felhasználónév vagy jelszó!';
			session_destroy();	// amíg nincs logout, addig ez jelentkeztet ki /home/login bárhonnan
				///********************************************
				// *		sikertelen bejelentkezés		  *
				// ********************************************/
			//exec("poweroff");
		}
	}
		public function ajax()
		{
			$arr = $this -> getQueryArray();
		}
	}
	?>