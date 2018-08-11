<?php

class App
{
    public function initialize()
    {
        echo "home init teszt</br>";
        //Log::columns();
    }

    public function index()
    {
        echo "home index action</br>";
    }

    public function __construct()
    {
        echo "home construct</br>";
    }

    public function teszt()
    {
        echo "home teszt action</br>";
    }
}