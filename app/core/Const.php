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
define("rCSS", "css".D);
define("rJS", "script".D);

// program file paths
define("MainDir",dirname(__DIR__, 2));
define("AppDir", dirname(__DIR__).D);
define("Control", AppDir."controller".D);
define("Model", AppDir."model".D);
define("Modul", AppDir."moduls".D);
define("FramePath", AppDir . "smile" . D);

//logging variables
//define("Log", AppDir."logs".D);
define("DEBUG", 0);
define("CustomError", 0);
define("CustomBackTrace", 0);
?>