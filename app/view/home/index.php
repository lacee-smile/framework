<script language="javascript" src="script/login.js"></script>
<?php
echo '
	<form method="post" action="home/login">
		<div class="login_wrapper">
		<input type="text" placeholder="Felhasználónév" name="username"/>
		<input type="text" placeholder="Jelszó" name="password"/>
		<button type="submit">Bejelentkezés</button>
		</div>
	</form>';

?>