<?php

use App\Error\Model\Log;
class App
{
    public function initialize()
    {
        echo "error init teszt</br>";
        //Log::columns();
    }

    public function index()
    {
        echo "error index action</br>";
    }

    public function __construct()
    {
        echo "error construct</br>";
    }

    public function teszt()
    {
        echo "error teszt action</br>";
    }
}
