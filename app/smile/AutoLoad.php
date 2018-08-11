<?php
spl_autoload_register(function ($className)
{
    // Controller
    $ext = ".php";
    $mainDir = MainDir.D;
    $classParams = preg_split("/[^a-zA-Z]/",$className);
    $defNamespace = null;
    
    if(count($classParams) == 1)
    {
        // it must be a frame extension
        $mainDir = FramePath;
        $defNamespace = "App\\Smile\\";
    }

    $classSlashes = join(D, $classParams);

    $fileName = end($classParams);
    array_pop($classParams);

    //namespace same as namespace
    $placeSameAsNamespace = $mainDir . $classSlashes . $ext;
    if(is_file($placeSameAsNamespace))
    {
        include $placeSameAsNamespace;
        $realClass = $defNamespace . $classSlashes;
        //return new $className::class;
    }





    // looking for lowercase path, camelcase file
    $pathLower = array_map('strtolower', $classParams);   
    $placeLower = $mainDir . join(D,$pathLower) . D . $fileName . $ext;
    if(is_file($placeLower))
    {
        include $placeLower;
        //return new $fileName();
    }
});

/*require "Controller.php";
require "Model.php";
require "View.php";
require "Helper.php";*/