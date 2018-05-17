<?php

namespace App\Smile;

class View
{
    use Helper;
    private $js = [];
    private $css = [];
    private $viewVars = [];
    private $partials = [];

    public function Render()
    {
       echo $this -> getRender();
    }

    public function getRender()
    {
        $html = "";
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
                    $html .= '<link rel="stylesheet" type="text/css" href="'.rCSS.$css.'">';
                }
                elseif($extension == "php")
                {
                    include_once CSS.$css;
                    new $className();
                }

            }
        }
        return $html;
    }

    /*public function setVar($varName, $varVal)
    {
        if(!$varName) return;
        $this -> $viewVars[$varName] = $varVal;
    }

    public function getVars($varName = null)
    {
        if(!$varName || !$viewVars[$varName])
            return $this -> viewVars;
        return $this -> viewVars[$varName];
    }

    public function addJs($fileName = null)
    {
        if(!$fileName || !file_exists(JS.$fileName.".js"))
            return;
        $this -> js[] = rJS.$fileName;
    }

    public function addCss($fileName = null)
    {
        if(!$fileName || !file_exists(CSS.$fileName))
            return;
        $this -> css[] = $fileName.".css";
    }

    public function getJs()
    {
        return $this -> js;
    }

    public function getCss()
    {
        return $this -> css;
    }

    public function getPartials()
    {
		return $this->partials;
	}

    public function setPartial(string $partial = null)
    {
        if(!$partial) return;
		$this->partials[] = $partial;
	}*/
}