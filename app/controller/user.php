<?php
/*
*	ez csak a bejelentkezett felhasználóknak látható
*/
class user extends Controller
{
	public function index()
	{
		$user = $this -> model("usermodel");
		echo "bejelentkezett mint " . $user -> name;
		//$this -> view("user/logoutbutton");
	}
}
?>