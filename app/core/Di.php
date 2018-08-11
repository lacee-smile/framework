<?php
namespace App\Core;

class dependecyInjector //extends Capsule
{
    private $param = [];
    // important thing
    // this object only store variables. Ddo NOT doing else
    // maybe private static functions as well... :D
    public function __construct()
    {
        echo "say \"hi Di\"";
    }

    public function __call($name, $argument)
    {
        echo "teszt";
    }
    public function addobj($name, $argument)
    {
        echo "addobj";
    }
}