<?php

use App\Core\Error;
register_shutdown_function(function()
{
	// triggered by die(), exit()
    (new App\Smile\ErrorHandler(error_get_last()));
});

set_error_handler(function($errno, $errstr, $errfile, $errline) 
{
	(new  App\Smile\ErrorHandler) -> errorNotice([
		"type" => $errno,
		"message" => $errstr,
		"file" => $errfile,
		"line" => $errline]);
});

require_once "../app/init.php";
$app = new Bootstrap();
