<?php
/*
*	ez csak a bejelentkezett felhasználóknak látható
*/
if(session_status() != 2)
die();
//$user = new user;
class user extends Controller
{
	public function user()
	{
		$this -> view("user/user");
		$view = new user_view;
		$view -> index();
		$calendar = $this -> moduls('calendar');
		$calendar -> Start(date("Y"),$_SESSION['config'][3],$_SESSION['config'][4]);
		echo "Bejelentkezett mint " . $_SESSION['name'];
		$this -> view('user/logoutbutton',null);
	}
}
?>