<?php
namespace App\Core\Component;
use App\Core\Model\Capsule;

class Log extends Capsule
{
    public function __construct()
    {
        $this -> setSource("log");
    }

    public function log($datas)
    {
        
    }
}