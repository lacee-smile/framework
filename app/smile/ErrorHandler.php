<?php
namespace App\Smile;

use App\Smile\Model;
use App\Smile\Helper;

class ErrorHandler extends Model
{
    private $stopRun = false;

    public function __construct()
    {
        $this -> setSource('log');
        $error = func_get_args();
        if(!empty($error))
        {
           $this -> findFirst(1) -> save("message", "anyád");
        //    var_dump();

            //(new Log) -> save($error);
        }
        //var_dump(func_get_args());
    }

    public function pageNotFound()
    {
        $error = error_get_last();
        // if(empty($error))
        //     return;
        echo "</br>page not found</br>";
        $this -> stopRun = true;

        //var_dump($error);
       
    }

    public function errorNotice(array $error = [])
    {
        echo "</br>notice</br>";
        var_dump($error);
    }

    private static function getGitBranch()
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

    public function __destruct()
    {
        if($this -> stopRun)
            die();
    }
}