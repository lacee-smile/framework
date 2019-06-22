<?php
namespace App\Core;

class Error 
{
    private static $errorLevel = null;
    private static $message = null;
    private static $params = [];

    public static function add($params = [])
    {
        if(!CustomError) return false;

        $debug = debug_backtrace();
        $errorMessage = [];

        $errorMessage[0] = "Error in ".$debug[1]['class'] . " class";
        $line = (int) $debug[0]['line'] -2 ;
        $errorMessage[0] .= " on row ". $line .".";

        //if(!empty($params['type']))
        //{
        switch($params['type'])
        {
            case 1: // Missing file
                $errorMessage[] = "Missing file: ".$params['fileName'];
                break;
            case 2:
                $errorMessage[] = "Not declared error message";
                break;
            default:
                if(!empty($params))
                {
                    $errorMessage[] = "Unknow error: ";
                    foreach($params as $key => $para)
                    {
                        $errorMessage[] = $key ." ".$para;
                    }
                }
        }
        //}

        if(!empty(self::$errorLevel))
        {
            $errorMessage[] = "Error level is ".self::$errorLevel;
        }

        if(!empty(self::$message))
        {
            $errorMessage[] = "Error message: " . self::$errorMessage;
        }
        echo join("</br>",$errorMessage)."</br>";
        if(self::$errorLevel > 3)
        {        
            die();
        }
    }

    public static function addPhpError($PHPError = [])
    {
        print_r($PHPError);
    }

    public static function setLevel($level)
    {
        if(!$level)
        {
            return false;
        }
        self::$errorLevel = $level;
    }

    public static function setMessage($message)
    {
        if(!$message)
        {
            return false;
        }
        self::$message = $message;
    }
}