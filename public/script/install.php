<?php
// telepítéshez tartozó javascript
?>
<script>
function get(ID){return document.getElementById(ID);}
function remA(obj, attr){obj.removeAttribute(attr);}
var InstallPhase = 0;
var spamDefender = 0;
var Operation = ["database","admin","office"];
var ErrorText =
[
	[
		"Üresen hagyta a szerver nevét!",
		"Üresen hagyta a szerver felhasználónevét!",
		"Üresen hagyta a szerver jelszavát!"
	],
	[
		"Üresen hagyta a teljes nevét!",
		"Üresen hagyta a felhasználónevét!",
		"Üresen hagyta a jelszavát!",
		"Üresen hagyta a jelszó megerősítését!",
		"A jelszónak legalább 8 karakternek kell lennie!",
		"Nem egyeznek meg a jelszavak!"
	],
	[
		"Üresen hagyta az iroda nevét!",
		"Üresen hagyta az iroda címét!"
	]
];

function dataCheck()
{
	var i = 0;
	var data = new Array();
	try
		{
			var tmp = new Array();
			for(i = 0; i < $('input').length; i++)
			{
				tmp = [$('input')[i],$('input').eq(i).val()];
				if(InstallPhase == 0 && i==2 && (tmp[1] == null || tmp[1] == ''))	// szerver, nincs jelszó
				{
					var EmptyPass = confirm("Biztosan üresen akarja hagyni a szerver jelszavát?");
					if(!EmptyPass) throw tmp[0]
				}
				else if(tmp[1] == null || tmp[1] == '')	// mindegyik mező ellenőrzése (kivétel 1.  screen 3. mező)
					throw tmp[0];
				if(InstallPhase == 1 && i == 2) // a felhasználó jelszavának első mezője
				{
					if(tmp[1] == null || tmp[1] == '')
					{
						throw tmp[0];
					}
					if(tmp[1].length < 8)	// legalább 8 karakteres jelszó
					{
						i = 4;
						throw tmp[0];
					}
					if(tmp[1] !== $('input').eq(3).val())	// nem egyeznek meg a jelszavak
					{
						i = 5;
						throw $('input')[3];
					}
				}
				else data.push(tmp[1]);
			}
			return data;
		}
	catch(obj)
		{
			obj.style.backgroundColor = "#ffa5a5";
			obj.onkeydown = function(){remA(obj,"style")};
			obj.focus();
			alert(ErrorText[InstallPhase][i]);
			return false;
		}
}

function SendDatas(datas)
{
	var that = this;
	$.post("/install/" + Operation[InstallPhase],
	    {
	    	datas
	    },
	    function(data)
	    {
	    	data = JSON.parse(data);
	    	
	    	if(data[0])
	    	{
	    		
	    		if(that.InstallPhase == 2) $(".indexDatas").html(data[1])
	    		else get("dataHolder").innerHTML = data[1];
	    			
	    		that.spamDefender = 0;
	    		that.InstallPhase++;
	    		EnterHandler();
	    		$('input')[0].focus();
	    	}
	    	else
	    	{
	    		get("end").innerHTML = data[1];
	    	}

	    });
}

$(function(){$('button').click(function()
	{
		$("button").blur();
		values = dataCheck();
		if(values)
		{
			SendDatas(values);
			get("end").innerHTML = "";
		}
	}
)});

function EnterHandler()
{
	$("input").bind('keypress', function(e)
	{
		$("button").blur();
	    if(e.keyCode == 13)
	    	{
	    		if(spamDefender < 5)
	    		{
		    		$("button").trigger("click");
				    spamDefender++;
				    if(spamDefender == 5)
				    	alert("Túl sokszor nyomott enter-t, a program védelme érdekében manuális beavatkozásig letiltom a funkciót!");
				}
				else
				{

					e.preventDefault();
				}
			}
	});
}

$(document).ready(function()
{
	$.browser = (/android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(navigator.userAgent.toLowerCase()));
	if($.browser)
	{
		$('link').attr("href","css/install_mobile.css");
	}
	$('input')[0].focus();
	EnterHandler();

})
</script>