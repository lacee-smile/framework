<?php
namespace App\Smile;

class Controller
{
    public function getId()
    {
        return $_SESSION['user']['id'];
    }
}