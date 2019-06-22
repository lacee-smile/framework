<?php

namespace Smile\Object;

class Application 
{
    protected $application = null;
    protected $method = null;
    protected $params = null;

    public function run()
    {
        /*if()
        {

        }*/
        //call_user_func_array
    }

    /**
     * Set the value of application
     *
     * @return  self
     */ 
    public function setApplication($application)
    {
        $this->application = $application;

        return $this;
    }
}