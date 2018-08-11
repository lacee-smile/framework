<?php

namespace App\Smile\Connect;

class Adapter
{
    public final function connect()
    {
        $server = SERVER;
        $db = DATABASE;
        $user = USER;
        $pw = PASSWORD;
		try
		{
			$conn = new \PDO("mysql:host=$server;dbname=$db;charset=utf8", $user, $pw);
            $conn -> setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this -> Connection = $conn;
			return $conn;
    	}
		catch(\PDOException $e)
		{
			(new Error) -> connectionError($e -> getMessage());
		}
    }

}