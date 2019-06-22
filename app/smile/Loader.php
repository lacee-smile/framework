<?php

namespace Smile;

class Loader
{
    private $classname = null;
    private $path = null;

    public function searchClassByName($className)
    {
        $this->setClassName($className);
        //Smile\Object\Application
        $this->searchByNamespace();
    }

    private function searchByNamespace()
    {
        /*
         this fucntion search the file by namespace and return if the file found
         search only inside the app directory
         let me explain it:
        
          Smile\Object\Application     <- namespace
            |        |          |
          folder     |          |
          lowercase  |          |
                  folder        |
                uppercase       |
                              filename
                             uppercase
        */
        $defFolder = AppDir;
        $path = null;
        $class = $this->getClassName();
        $classParams = explode("\\",$class);
        $dirInApp = join(D,array_slice($classParams, 0, -1));
        if(is_dir($defFolder.D.$dirInApp)) {
            $path = $defFolder.D.$dirInApp;
        }
        /*elseif($this->searchCase($dirInApp)) {
            $path = $defFolder.D.$dirInApp;
        }*/
        else//if(empty($path)) 
        {
            // main dir not found
            return false;
        }
        $objectName = end($classParams);
        require $path.D.$objectName.".php";
    }

    private function searchLowerCase($search, $dir = AppDir)
    {
        if(is_dir($dir.D.strtolower($search))) {
            return true;
        }
        return false;
    }

    private function searchCase($search, $dir = AppDir)
    {
        if(is_dir($dir.D.strtolower($search))) {
            return true;
        }
        return false;
    }

    private function searchGlob()
    {
        
    }

    /**
     * Get the value of classname
     */ 
    public function getClassname()
    {
        return $this->classname;
    }

    /**
     * Set the value of classname
     *
     * @return  self
     */ 
    public function setClassname($classname)
    {
        $this->classname = $classname;

        return $this;
    }
}