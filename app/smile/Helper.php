<?php
// if you want to create a custom function to use all over on your system, write to here.
namespace App\Smile;

trait Helper 
{
    public function toArray()
    {
        if(count($this -> getVar('result')) == 1)
            return $this -> result[0];
        return $this -> result;
    }

    public function indexTo(string $indexCol = 'id')
    {
        $tmp = [];
        foreach($this -> result as $row)
        {
            $tmp[$row[$indexCol]] = $row;
        }
        return $tmp;
    }

    public function setVar($name = "", $value = 0)
    {
        if(!$name || !$value)
            return;
        $this -> $name = $value;
    }

    public function getVar($name = "")
    {
        if(!$name)
            return;
        return $this -> $name;
    }
}