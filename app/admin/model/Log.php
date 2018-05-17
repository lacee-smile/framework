<?php
namespace App\Admin\Model\Log;
use App\Smile\Model;

class Log extends Model
{
    public function __construct()
    {
        $this -> setSource("log");
    }
}