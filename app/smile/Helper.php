<?php
namespace App\Smile;
use App\Smile\Model;

class Helper extends Model
{
    public function __construct()
    {
        $this -> setSource("log");
    }

    public function teszt()
    {
        $result = $this -> columns()
        -> conditions("user_id between 8 and 100")
        -> limit(3)
        -> order("id desc")
        -> getQuery()
        -> execute()
        -> toArray();
        var_dump($result);
    }
    
}