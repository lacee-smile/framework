<?php
/*
	*********************************************************
	*			FELÜLÍRÁS CSAK SAJÁT FELELŐSSÉGRE			*
	*********************************************************

-------------------------------------------------------------------

	*********************************************************
	*				OVERWRITE YOUR OWN RISK					*
	*********************************************************
*/
namespace config
{
	$log_enabled 		= true;	//	set true to enable logging (def: false)
	$stay_login 		= false;	//	enable "stay login" function (def: true)
	$stay_login_time	= 3600;		//	time of stay login in seconds (def: 3600)
	$enable_cache		= false;	//	enable caching



	/*
	*	default office settings
	*	each value can be changed by admin (only own office)
	*/

$DefaultConfig = array(
	"prevmonth"			=> 6,	//	előző hónapok megtekintése (def: 6)
	"nextmonth"			=> 6,	//	következő honapok megtekintése -> maximálisan előre kérhető szabadnap
	"a_console_refresh"	=> 30,	//	admin console (ez mi lesz pontosan?) frissítése
	"a_error_refresh"	=> 30,	//	admin oldalon a hibaüzenetek/logok frissítésének másodperce
	"user_refresh"		=> 120,	//	a felhasznáói oldal válasz keresése
	"boss_refresh"		=> 5,	//	a főnöki oldal kérések keresése
	"max_days"			=> 20	//	maximálisan kivehető napok száma egy évben
);

}
?>