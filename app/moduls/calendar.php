<link rel="stylesheet" type="text/css" href="css/calendar.css" />
<script src="script/jQuery.js" language="javascript"></script>
<script src="script/calendar.js" language="javascript"></script>
<?php
mb_internal_encoding("UTF-8");
class calendar
{
	public $past = 1;
	protected $honapok = array
	(
		"1" => "Január",
		"2" => "Február",
		"3" => "Március",
		"4" => "Április",
		"5" => "Május",
		"6" => "Június",
		"7" => "Július",
		"8" => "Augusztus",
		"9" => "Szeptember",
		"10" => "Október",
		"11" => "November",
		"12" => "December"
	);
	protected $napok = array
	(
		"1" => "Hétfő",
		"2" => "Kedd",
		"3" => "Szerda",
		"4" => "Csütörtök",
		"5" => "Péntek",
		"6" => "Szombat",
		"7" => "Vasárnap"
	);
	protected function get_month_days($year,$month)
	{
		$number[0] = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		$d = mktime(10,10,10,$month,01,$year);
		$number[1] = date("N",$d);
		return $number;
	}
	protected function Create_Calendar()
	{
		$year = func_get_arg(0);
		$month = func_get_arg(1);
		$n = $this -> get_month_days( $year, $month );	// month length and first day of week
		$table = "
		<div class='calendar_holder' style='display: none;'>
		<table class='calendar'><caption>".$year.".".$this -> honapok[$month] ."</caption>
		<tbody>
		<tr>";
		for( $i=1; $i<=7; $i++ )
		{
			$table .= "<td style='background-color:white;'>".mb_substr($this ->  napok[$i], 0, 3).".</td>";
		}
		$table .= "</tr><tr>";
		for($i=1;$i<$n[1];$i++)				//add empty cells to the start
			$table .= "<td style='background-color:white;'></td>";
		
		for($j=1,$i;$j<=$n[0];$j++,$i++) 
		{
			$date = $year.".".$month.".".$j;
			$table .= "<td date='".$date."' clicked='false' ";
			if($date == date("Y.n.j"))
			{
				$table .= "onclick='GetDate(this)' id='today'";
				$this -> past = 0;
			}
			if($this -> past == 1)
			{
				$table .= "onclick='OldDate(this)'>";
			}
			else
			{
				$table .= "onclick='GetDate(this)' clicked='false'>";
			}
			$table .= "{$j}</td>";			
			if($i == 7) // break rows at the end of week
			{
				$i = 0;
				$table .= "</tr>
				<tr>";
			}		
			
		}
		// add empty cells in the end
		if($i != 1) for($i;$i<=7;$i++) $table .= "<td style='background-color:white;'></td>";
		$table .= "</tr>
		</tbody></table>
		</div>";
		echo $table;
	}
	public function Start($arr)
	{
		echo '<div class="Calendar_Wrapper">';
		switch(count($arr))
		{
			case 1:
				{
					for($i=1;$i<13;$i++)
					$this -> Create_Calendar($arr[0],$i);
				}break;
			case 2:
				{
					$this -> Create_Calendar($arr[0],$arr[1]);
				}break;
			case 3:
			{
				$year = $arr[0];
				$month = $arr[1];
				for($i=0;$i<$arr[2];$i++,$month++)
				{
					if($month > 12)
						{
							$month = 1;
							$year++;
						}
					$this -> Create_Calendar($year,$month);
				}
			}break;
			default:
			{
				echo "Too many or too less parameters for the calendar modul";
				die();
			}
		}
		echo '
			<div class="change_button_holder">
				<input type="button" value="Előző" class="left_arrow"/>
				<input type="button" value="Következő" class="right_arrow"/>
			</div></div>
			<div class="selectdaysholder"><div id="selectdays"></div><input type="button" id="send_days" class="Send_Days" value="Elküld" /></div>
			';
	}
}
?>