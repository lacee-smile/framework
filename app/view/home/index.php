<?php
$view = new home_view;
foreach($data as $func)
$view -> $func();
class home_view
{
	public function heading()
	{
		echo '
			<script language="javascript" src="script/jQuery.js"></script>
			<script language="javascript" src="script/home.js"></script>
			<link rel="stylesheet" type="text/css" href="css/home.css"/>
			';
	}

	public function LoginForm()
	{
		echo '
			<div class="login_wrapper">
				<input type="text" placeholder="Felhasználónév" name="username"/>
				<input type="text" placeholder="Jelszó" name="password"/>
				<button>Bejelentkezés</button>
				<p id="text"></p>
			</div>

			';
	}
}

?>