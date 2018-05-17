<?php
namespace App\Core\Model;

use App\Smile\Model;

class Log extends Model
{
    public function __construct()
    {
        $this -> setSource('log');
    }
}