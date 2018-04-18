<?php

if(isset($_COOKIE['XDEBUG_SESSION']))
{
	print_c($_POST, true);
	/*print_c($_GET);
	print_c($_COOKIE);*/
}
elseif(isset($_COOKIE['XDEBUG_PROFILE']))
{
	if (session_status() == PHP_SESSION_NONE)
	{
    	session_start();
	}
	print_c($_SESSION, true);
}
elseif(isset($_COOKIE['XDEBUG_TRACE']))
{
	print_c(debug_backtrace());
}

// a consloe-ba írásopkat azért így oldottam meg, mert így akkor is kiírja, ha a js elakadt valahol elötte!
// mint tudjuk, a js bunkó ._.

function print_c($obj, $hideplace = false)
{
	// a böngésző console-ba ír előreformázottan szöveget (bármint, amit egy print_r kezelni tud)
	echo "<script> console.log(".json_encode(extractPreformatedText($obj, $hideplace)).");
	</script>";
}

function print_pre($obj, $StopRunning = false, $HidePlace = false)
{
	// a képernyőre irja ki a szöveget, előregotmázottan
    echo "<pre>" . extractPreformatedText($obj, $HidePlace) . "</pre>";
    if($StopRunning) die();
}

function extractPreformatedText($obj, $HidePlace)
{
	// a print_c és print_pre segédfüggvénye
	// a szöveget előreformázottá varázsolja és hozzáírja hogy honnan hívták meg
	ob_start();
	print_r($obj);
	$str = ob_get_clean();
	$debug = debug_backtrace();
	if(!$HidePlace)
	$str .= PHP_EOL . " at file: " . $debug[1]['file'] . " line " . $debug[1]['line'];

	unset($debug, $obj, $HidePlace);
	return $str;
}

function ConsoleAlert($obj, $HidePlace = true)
{
	$str = json_encode(extractPreformatedText($obj, $HidePlace));
	echo "<script> console.log('%c' + ".$str.", 'color: #DD3335');
	</script>";
	unset($str, $obj, $HidePlace);
}

function ConsoleStr($obj)
{
	$str = json_encode(extractPreformatedText($obj, true));
	return $str;
}
?>
