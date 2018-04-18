var Selected_Days_Num = 0;
var date = new Date();
var current = date.getMonth();

function GetDate(obj)
{
	k = obj.getAttribute("clicked");
	if(k == "false")
	{
		obj.setAttribute("clicked","true");
		obj.style.backgroundColor = "#FFCC66";
		Selected_Days_Num++;
	}
	else
	{
		obj.setAttribute("clicked","false");
		obj.removeAttribute("style");
		Selected_Days_Num--;
	}
	Show_Selected_Days();
}

var all = 0;
var tables;

$(document).ready(function()
{
	current++;
	tables = $('.calendar_holder');
	currentMonth = $('.calendar_holder[month="'+current+'"]');
	currentMonth.show();
	current = tables.index(currentMonth);
	all = tables.length;
	$(".selectdaysholder").hide();
});




$(function(){$(".left_arrow").on("click",function()
{
	if(current-1>=0)
	{
		tables.eq(current).hide();
		current--;
		tables.eq(current).show();
	}
}
)});

$(function(){$(".right_arrow").on("click",function()
{
	if(current+1<all)
	{
		tables.eq(current).hide();
		current++;
		tables.eq(current).show();
	}
}
)});
var days = [];

function Show_Selected_Days()
{
	days = [];
	show = document.getElementById("selectdays");
	if(Selected_Days_Num > 0)
	{
		$(".selectdaysholder").show()
		tds = $('td[clicked="true"]')
		for(i=0;i<Selected_Days_Num;i++)
		{
			days.push(tds.eq(i).attr("date"));	
		}
	}
	else 
	{
		$(".selectdaysholder").hide()
	}
	show.innerHTML = "";
	for(i=0;i<Selected_Days_Num;i++) show.innerHTML += days[i]+"</br>";
}

function OldDate(obj)
{
	console.log(obj.innerHTML);
}