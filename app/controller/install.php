<?php
class install extends Controller
{
	private $db = "szabadsagolas";
	private $appears = null;
	private $mysql = null;

	public function install()
	{
		// set variables
		$this -> view("install/index");
		$this -> appears = new install_view;
		$this -> mysql = $this -> model("mysql");
		
	}

	public function index()
	{
		$this -> appears -> heading();
		$this -> appears -> ServerDatasForm();

	}

	public function database()
	{
		$this -> mysql -> db = $this -> db;
		if($this -> mysql -> install_database())  //sikeres adatbázis létrehozás után változók fájlba írása => védelem a rossz változók kiírása ellen
		{
			self::WriteToFile();
			echo json_encode([true, $this -> appears -> AdminDatasForm()]);
		}
		else// sikertelen mysql kapcsolódás
			echo json_encode([false, "Sikertelen kapcsolódás a szerverre. Kérem ellenőrizze az adatokat!"]);
	}

	public function admin()
	{
		if($this -> mysql -> AddAdmin())
			echo json_encode([true, $this -> appears -> AddOffice()]);
		else echo json_encode([false,"Felhasználónév foglalt, kérlek válassz másikat!"]);
	}

	public function office()
	{
		if($this -> mysql -> AddOffice())	//sikeres telepítés
		{
			if(self::StopInstall())	// sikeres fájlátnevezés/törlés
				echo json_encode([true, $this -> appears -> EndInstall()]);
			else 		// sikerteln fájltörlés
			{
				echo json_encode([true, $this -> appears -> EndInstall() . $this -> appears -> ErrorDeleteFile()]);
			}
		}
		else echo json_encode([false,"Ez az iroda már hozzá van adva!"]);
	}

	private function StopInstall()
	{
		return rename("../app/controller/install.php","../app/controller/install_old.php");
	}


	private function WriteToFile()
	{
		$file = fopen("../app/database.php","w") or die("Kérem engedélyezze a program fájlhozzáférését!");
		$str = '<?php
namespace database
	{
		$server = "' . $_POST["datas"][0] . '";
		$user = "' . $_POST["datas"][1] . '";
		$pw = "' . $_POST["datas"][2] . '";
		$db = "' . $this -> db . '";
	}
?>';
		fwrite($file,$str);
		fclose($file);
	}
}
?>