<?php

use App\Core\Capsule;
use App\Core\Controller;
use App\Controller\View;

class admin extends Controller
{
	public function __construct()
	{
		$this -> view("home");


		
		/*require_once Control.$class.D."model".D."model.php";
		$this -> model = new Model();

		require_once Control.$class.D."component".D."component.php";
		$this -> component = new Component();*/
	}

    public function index()
    {
        $this -> view -> addCss("home");
	}

	public function ajax()
	{
		global $formID;
		$arr = $this -> GetQueryArray();
		$func = $tempArr = null;
		switch($formID)
		{
			case 1:
			{
				$tempArr = array(
					"name" => $arr['fullname'],
					"username" => $arr['username'],
					"type" => $arr['beosztas'],
					"office" => $arr['office'],
					"password" => $arr['password']
				);
				$func = "AddUser";
			}break;
			case 2:
			{
				$tempArr = array(
					"name"	=>	$arr['name'],
					"address"	=>	$arr['address']
				);
				$func = "AddNewOffice";
			}break;
			/*default:
			{
				ConsoleStr("Something went wrong! :( ");
			}*/
		}
		/*$mysql = new Capsule;
		$result = call_user_func_array([$mysql, $func], $tempArr);
		$mysql = $tempArr = null;*/
        //print_c($arr['password']);
		//echo json_encode(extractPreformatedText($RenamedArr, true));
	}
}
?>