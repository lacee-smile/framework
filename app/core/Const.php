<?php

//program variables
$url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
define("D", DIRECTORY_SEPARATOR);

// url-s
define("UrlBase", $url .D);
define("UrlCurrent", $url . $_SERVER["REQUEST_URI"]);

//public directories
define ("PublicDir", getcwd());
define ("CSS", PublicDir .D. "css".D);
define("JS", PublicDir .D. "script".D);
define("Images", PublicDir .D. "images".D);

// program file paths
define("AppDir", dirname(__DIR__).D);
/* define("Control", AppDir."controller".D);
define("Model", AppDir."model".D);
define("Modul", AppDir."moduls".D); */

//logging variables
define("Log", AppDir."logs".D);
define("DEBUG", 1);
define("CustomError", 1);
define("CustomBackTrace", 0);