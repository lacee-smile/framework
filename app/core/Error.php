<?php
namespace App\Core;
//use App\Core\Logging;
 
class Error 
{
    private static $errorLevel = null;
    private static $message = null;
    private static $params = [];
 
    public static function pageNotFound($file, $params)
    {
        echo "page not found";
        self::setLevel(4);
        $requs = ["type" => 1, "fileName" => $file];
        self::setMessage($params??null);
        self::add($requs);
        $requs = null;
        unset($requs);
    }
 
    public static function add($params = [])
    {
        if(!CustomError) return;
 
        $debug = debug_backtrace();
        $errorMessage = [];
        $errorMessage[0] = "Error in ".$debug[2]['class'] . " class";
        $line = (int) $debug[1]['line'] -2 ;
        $errorMessage[0] .= " on row ". $line .".";
 
        switch($params['type'])
        {
            case 1: // Missing file
                $errorMessage[] = "Missing file: ".$params['fileName'];
                break;
            case 2:
                $errorMessage[] = "Not declared error meassage";
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
 
        if(!empty(self::$errorLevel))
        {
            $errorMessage[] = "Error level is ".self::$errorLevel;
        }
 
        if(!empty(self::$message))
        {
            $errorMessage[] = "Error message: " . self::$message;
        }
        // use database loging instead of echo;
        $errorMessage["branch"] = self::getGitBranch();
        //(new Logging) -> addLog($errorMessage);
        //echo join("</br>",$errorMessage)."</br>";
        if(self::$errorLevel > 3)
        {        
            exit(100);
        }
    }
            
    protected static function getGitBranch()
    {
        $shellOutput = [];
        exec('git branch | ' . "grep ' * '", $shellOutput);
        foreach ($shellOutput as $line) {
            if (strpos($line, '* ') !== false) {
                return trim(strtolower(str_replace('* ', '', $line)));
            }
        }
        return null;
    }
    public static function addPhpError($PHPError = [])
    {
        print_r($PHPError);
    }
    
    public static function setLevel($level)
    {
        if(!$level)
        {
            return;
        }
        self::$errorLevel = $level;
    }
    
    public static function setMessage($message)
    {
        if(!$message)
        {
            return;
        }
        self::$message = $message;
    }
}