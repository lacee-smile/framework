<?php
class install extends Controller
{
	public function index()
	{
		$this -> view("install/index");
	}

	public function database()
	{
		$db = "szabadsagolas";
		$file = fopen("../app/database.php","w") or die("Kérem engedélyezze a program fájlhozzáférését!");
		$str = '<?php
namespace database
	{
		$'.'server = "' . $_POST['server'] . '";
		$'.'user = "' . $_POST['user'] . '";
		$'.'pw = "' . $_POST['pass'] . '";
		$'.'db = "' . $db . '";
	}
?>';
		fwrite($file,$str);
		fclose($file);

		$mysql = $this -> model("mysql");
		$mysql -> install_database($db);
	}
}
?>