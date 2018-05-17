<?php
namespace App\Smile;

require "Helper.php";
require "Controller.php";
require "Model.php";
require "View.php";
require "ErrorHandler.php";

abstract class Frame
{
    private $path = null;
    private $directories = [
        "controller",
        "component",
        "model",
        "validator",
        "view",
    ];
    private $files = [
        "Config",
        "Router",
    ];


    public function autoloader($app)
    {
        // require files
        $this -> path = AppDir . $app . D;
        $this -> reqFiles();
        $this -> reqDirFiles($this -> path);
    }

    private function reqFiles()
    {
        foreach($this -> files as $file)
        {
            $file = $this -> path . $file . ".php";
            if(file_exists($file))
            {
                require_once $file;
            }
        }
    }

    private function reqDirFiles($path)
    {
        $path = $path??$this -> path ?? null;
        foreach($this -> directories as $dir)
        {
            $dir = $this -> path . $dir . D;
            if(file_exists($dir) and is_dir($dir))
            {
                $files = scandir($dir);
                foreach($files as $file)
                {
                    if($file !== '.' and $file !== '..')
                    {
                        require_once $dir . $file;
                    }
                }
            }
        }
    }
}