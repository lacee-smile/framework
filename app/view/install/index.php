<script language="javascript" src="script/install.js"></script>
<link rel="stylesheet" type="text/css" href="css/install.css"/>
<div class="indexDatas">
	<p class="indexTitle">A programnak szüksége van néhány alapvető információra</p>
	<input type="text" placeholder="Szerver címe" name="server" class="form-control"/>
	<input type="text" placeholder="Szerver felhasználó" name="user" class="form-control"/>
	<input type="password" placeholder="Szerver jelszó" name="password" class="form-control"/>
	<input type="button" value="Tovább" class="btn" onclick="start()" />
	<div class="EndText indexTitle" id="end"></div>
</div>
<div class="indexDatas" style="display: none;">
	<p class="indexTitle">Kérem adjon hozzá egy adminisztrátort!</p>
	<input type="text" placeholder="Teljes név" name="adminname" class="form-control"/>
	<input type="text" placeholder="Bejelentkezési név" name="user" class="form-control"/>
	<input type="password" placeholder="Jelszó" name="password" class="form-control"/>
	<input type="password" placeholder="Jelszó újra" name="password" class="form-control"/>
	<input type="button" value="Tovább" class="btn" onclick="addNewAdmin()" />
</div>
<div class="EndText indexTitle" id="end"></div>