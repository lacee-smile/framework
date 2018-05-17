<?php

use App\Admin\Model\Log;
class App
{
    public function initialize()
    {
        echo "init teszt</br>";
        //Log::columns();
    }

    public function index()
    {
        echo "index action</br>";
    }

    public function __construct()
    {
        echo "construct</br>";
    }

    public function teszt()
    {
        echo "teszt action</br>";
    }
}