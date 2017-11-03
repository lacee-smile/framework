function start()
{
	var param = "";
	var server = getName("server")[0];
	var user = getName("user")[0];
	var password = getName("password")[0];
	server.style.backgroundColor = "#FFFFFF";
	user.style.backgroundColor = "#FFFFFF";
	password.style.backgroundColor = "#FFFFFF";
	try
	{
		if(server.value == "") throw server;
		if(user.value == "") throw user;
		param = "server="+server.value+"&user="+user.value
		if(password.value != "")
		param += "&pass="+password.value;
		Create_Database(param);
	}
	catch(e)
	{
		e.style.backgroundColor = "#fcc";
	}
}

function Create_Database(p)
{
	var xhttp = new XMLHttpRequest();
	xhttp.open("POST","/install/database",true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send(p);
	xhttp.onreadystatechange = function()
	{
	    if (this.readyState == 4 && this.status == 200)
	    {
			DoThis(this.responseText);
	    }
    };
}

function add_New_Admin(p)
{
	var xhttp = new XMLHttpRequest();
	xhttp.open("POST", "addadmin.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.onreadystatechange = function()
	{
	    if (this.readyState == 4 && this.status == 200)
	    {
			DoThis(this.responseText);
	    }
    };
	xhttp.send(p);
}
function Del_Dir()
{
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function()
	{
	    if (this.readyState == 4 && this.status == 200)
	    {
			DoThis(this.responseText);
	    }
    };
  xhttp.open("GET", "deldir.php", true);
  xhttp.send();
}
function DoThis(str)
{
	if(str != "OK")
	document.getElementById("end").innerHTML = str;
	else ChangeAll();
}

window.onload = OnLoad
function OnLoad()
{
	onFocus(CName("form-control")[0]);
}

function ChangeAll()
{
	del(CName("indexDatas")[0]);
	CName("indexDatas")[0].removeAttribute("style");
	onFocus(CName("form-control")[0]);
}

function addNewAdmin()
{
	try
	{
		if(!getName("adminname")[0].value) throw "Kérem töltse ki a teljes nevét!";
		if(!getName("user")[0].value) throw "Kérem töltse ki a felhasználó nevét!";
		if(!getName("password")[0].value || !getName("password")[1].value) throw "Kérem adja meg a jelszavát!";
		if(getName("password")[0].value != getName("password")[1].value) throw "Nem egyeznek meg a jelszavak!";
	/*	if(getName("password")[0].value.length < 8 ) throw "A jelszónak legalább 8 karakternek kell lennie!"; */ // aktiváld ha már kell
		else
		{
			param = "name="+getName("adminname")[0].value+"&user="+getName("user")[0].value+"&pw="+getName("password")[0].value;;
			add_New_Admin(param);
		}
	}
	catch(e)
	{
		document.getElementById("end").innerHTML = e;
	}
}

function CName(classname){return document.getElementsByClassName(classname)}
function getName(nm){return document.getElementsByName(nm)}
function del(obj){obj.parentNode.removeChild(obj)}
function onFocus(obj){obj.focus();}
function get(ID){return document.getElementById(ID);}