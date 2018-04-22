<?php

namespace App\Core;

class View
{
    private $js = [];
    private $css = [];
    private $viewVars = [];

    public function Render()
    {
        echo $this -> getRender();
    }

    public function getRender()
    {
        $html = "";
        if(CustomBackTrace) echo "View/Render()</br>";
        if(!empty($this -> getCss()))
        {
            foreach($this -> getCss() as $css)
            {
                $tmp = explode(".",$css);
                $className = $tmp[0];
                $extension = end($tmp);
                unset($tmp);
                if($extension == "css")
                {
                    $html .= "<link type='text/css' href='".CSS.$css.".css' rel='styleseheet'>";
                }
                elseif($extension == "php")
                {
                    include_once CSS.$css;
                    $className = new $className();
                }

            }
        }

        return $html;
    }

    public function setVar($varName = false, $varVal)
    {
        if(!$varName) return;
        $this -> $viewVars[$varName] = $varVal;
    }

    public function getVar($varName = false)
    {
        if(!$varName || !$viewVars[$varName]) return;
        return $viewVars[$varName];
    }

    public function getVars()
    {
        return $this -> viewVars;
    }

    public function addJs($fileName = false)
    {
        if(!$fileName) return;
        $this -> js[] = JS.$fileName;
    }

    public function addCss($fileName = false)
    {
        if(CustomBackTrace) echo "View/addCss()</br>";
        if(!$fileName) // empty filename
            return;
        if(!file_exists(CSS.$fileName.".php") && !file_exists(CSS.$fileName.".css")) // file not php and cot css
        {
            Error::add(['fileName'  =>  CSS.$fileName, 'type'   =>  1]);
            return;
        }
        $this -> css[] = $fileName.".php" ?? $fileName.".css" ?? null;
    }

    public function getJs()
    {
        return $this -> js;
    }

    public function getCss()
    {
        return $this -> css;
    }

    public function getCssFromPhp()
    {

    }
}
?>