<?php
/*
*	ez csak a bejelentkezett felhasználóknak látható
*/
class user extends Controller
{
	public function index()
	{
		$this -> model("user");
		echo "bejelentkezett mint " . $this -> name;
		//$this -> view("user/logoutbutton");
	}
}
?>