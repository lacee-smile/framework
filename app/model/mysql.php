<?php
class mysql extends Capsule
{
	public function install_database($db)
	{
		self::Create_Database($db);

		$this -> Upload("create table if not exists users
		(
			name varchar(150) not null,
			username varchar(100) not null,
			beosztas varchar(10),
			password varchar(150) not null,
			irodahaz smallint(3) unsigned not null,
			primary key(username) 
		)engine=innoDB;
		");

		$this -> Upload("create table if not exists szabadsag
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

		$this -> Upload("create table if not exists irodahaz
		(
			iroda_id smallint(3) unsigned not null auto_increment,
			neve varchar(255) not null,
			cime text not null,
			settings varchar(100) not null,
			primary key(iroda_id)
		)engine=innodb;
		");

		echo "OK";
	}

	private function Create_Database($db)
	{
		$server = $_POST["server"];
		$user = $_POST["user"];
		$pw = $_POST["pass"];
		$connect = new mysqli($server, $user, $pw);
		if ($connect -> connect_errno)
    	{
           $this -> Log(0, [$connect -> connect_error, basename(__FILE__), basename(__LINE__-3)]);
           echo $connect -> connect_error;
           die();
        }
        $connect -> set_charset("utf8");
		$connect -> query("create database if not exists ".$db." default character set utf8 default collate utf8_hungarian_ci");
	}
}

?>