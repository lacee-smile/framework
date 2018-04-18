<?php
//$view = new home_view;
//foreach($data as $func)
//$view -> $func();

use App\Core\View;

class homeview extends View
{

	public function homeview()
	{
        // css a head-be
        $this -> teszt();
		//$this -> CSS("home");
	}

	public function LoginForm()
	{
		echo '<form method="post">
			<div class="login_wrapper">
				<input type="text" placeholder="Felhasználónév" name="username" />
				<input type="text" placeholder="Jelszó" name="password" />
				<button name="login" type="submit">Bejelentkezés</button>
				<p id="text"></p>
			</div>
			</form>
			';
	}
	public function __destruct()
	{
        //js oldalbetöltés után -> nem kell a window.onload/$(document).ready();
		$this -> JS('home'); 
	}
}

?>