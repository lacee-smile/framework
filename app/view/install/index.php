<?php
class install_view
{
	public function heading()
	{
		echo '
		<script language="javascript" src="script/jQuery.js"></script>
		<script language="javascript" src="script/install.js"></script>
		<link rel="stylesheet" type="text/css" href="css/install.css"/>';
	}
	public function ServerDatasForm()
		{
			$str = '
			<div class="indexDatas">
				<div id="dataHolder">
					<p class="indexTitle">A programnak szüksége van néhány alapvető információra</p>
					<input type="text" placeholder="Szerver címe" name="server" class="form-control"/>
					<input type="text" placeholder="Szerver felhasználó" name="user" class="form-control"/>
					<input type="password" placeholder="Szerver jelszó" name="password" class="form-control"/>
				</div>
				<button class="btn"> Tovább </button>
				<div class="EndText indexTitle" id="end"></div>
			</div>
			';
			echo $str;
		}


	public function AdminDatasForm()
		{
			$str = '
				<p class="indexTitle">Kérem adjon hozzá egy adminisztrátort!</p>
				<input type="text" placeholder="Teljes név" name="adminname" class="form-control"/>
				<input type="text" placeholder="Bejelentkezési név" name="user" class="form-control"/>
				<input type="password" placeholder="Jelszó" name="password" class="form-control"/>
				<input type="password" placeholder="Jelszó újra" name="password" class="form-control"/>
				';
			return $str;
		}
	public function AddOffice()
	{
		$str = '<p class="indexTitle">Kérem adjon hozzá egy irodaházat!</p>
				<input type="text" placeholder="Iroda neve" name="officename" class="form-control"/>
				<input type="text" placeholder="Iroda címe" name="officeaddress" class="form-control"/>';
		return $str;
	}

	public function EndInstall()
	{
		$str = '<p class="indexTitle">A telepítés sikeres, minden megadott adat mentésre került!</p>
		<a href="/" class="btn">Weboldal megtekintése</a>
		<div class="EndText indexTitle" id="end"></div>';
		return $str;
	}

	public function ErrorDeleteFile()
	{
		$str = '<div class="EndText indexTitle" id="end">Az install fájl törléséhez manuális beavatkozásra van szükség!</div>';
		return $str;
	}

}
?>