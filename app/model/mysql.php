<?php
class mysql extends Capsule
{
	public $db = "";

	public function install_database()
	{
		if(!self::Connect()) return false;

		self::Create_Database();

		self::Upload("create table if not exists users
		(
			name varchar(150) not null,
			username varchar(100) not null,
			beosztas varchar(10),
			password varchar(150) not null,
			irodahaz smallint(3) unsigned not null,
			registry_date timestamp not null default current_timestamp,
			primary key(username) 
		)engine=innoDB;
		");

		self::Upload("create table if not exists szabadsag
		(
			szab_id smallint(8) unsigned not null auto_increment,
			user_name varchar(100) not null,
			mikor timestamp not null default current_timestamp,
			napok varchar(250),
			indok text,
			accepted_days varchar(250),
			latta boolean,
			jovahagyva boolean,
			primary key(szab_id) 
		)engine=innoDB;
		");

		self::Upload("create table if not exists irodahaz
		(
			iroda_id smallint(3) unsigned not null auto_increment,
			neve varchar(255) not null,
			cime text not null,
			prevmonth tinyint,
			nextmonth tinyint,
			a_consolerefresh tinyint,
			a_errorrefresh tinyint,
			userrefresh tinyint,
			bossrefresh tinyint,
			primary key(iroda_id)
		)engine=innodb;
		");
		return true;
	}

	private function Connect()
	{
		$data = $this -> parseData($_POST);
		$server = $data[0];
		$user = $data[1];
		$pw = $data[2];
		try
		{
			$conn = new PDO("mysql:host=$server", $user, $pw);
			$conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			unset($data);
			return $conn;
    	}
		catch(PDOException $e)
		{
			return false;
		}
	}

	private function Create_Database()
	{
		$sql = "create database if not exists " . $this -> db . " default character set utf8 default collate utf8_hungarian_ci";
		self::Connect() -> query($sql);
	}

	private function Upload($sql)
	{
		self::Connect() -> query("use " . $this -> db ."; " . $sql);
	}

	public function AddAdmin()
	{
		$data = $this -> parseData($_POST);
		$result = $this -> AddUser([
			'name' => $data[0],
			'username' => $data[1],
			'type' => 'admin',
			'password' => hash("md5",$data[2]),
			'office' => 0
		]);
		return $result;
	}

	public function AddOffice()
	{
		$data = $this -> parseData($_POST);
		$result = $this -> AddNewOffice([
			'name' => $data[0],
			'address' => $data[1]
		]);
		return $result;
	}

	private function parseData($arr)
	{
		return $arr["datas"];
	}
}

?>