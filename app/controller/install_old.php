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
        self::CSS("install");
		self::JS('install');
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
			else 		// sikertelen fájltörlés
			{
				echo json_encode([true, $this -> appears -> EndInstall() . $this -> appears -> ErrorDeleteFile()]);
			}
		}
		else echo json_encode([false,"Ez az iroda már hozzá van adva!"]);
	}

	private function StopInstall()
	{
		return rename(Control."install.php",Control."install_old.php");
	}


	private function WriteToFile()
	{
		$file = fopen(AppDir."database.php","w") or die("Kérem engedélyezze a program fájlhozzáférését!");
		$str = '<?php
namespace database
	{
		$server = "' . $_POST["datas"][0] . '";
		$user = "' . $_POST["datas"][1] . '";
		$pw = "' . $_POST["datas"][2] . '";
		$db = "' . $this -> db . '";
	}
?>';
//print_pre($_POST);
		fwrite($file,$str);
		fclose($file);
    }
    
    /*public function CSS($files)
	{
		if(count($files) == 0)
		{
			print_c('this function called with 0 parameter. ignoring!');
		}
		elseif(gettype($files) == 'string')
		{
			include CSS . $files . ".php";
		}
		else
		foreach($files as $file)
		include CSS . $file . ".php";
	}
	public function JS($files)
	{
		echo '<script language="javascript" src="script/jQuery.js"></script>';
		if(count($files) == 0)
		{
			print_c('this function called with 0 parameter. ignoring!');
		}
		elseif(gettype($files) == 'string')
		{
			include JS . $files . ".php";
		}
		else
		foreach($files as $file)
		include JS . $file . ".php";
	}*/
}
?>