<?php
class mysql extends Capsule
{
	public $db = "";

	public function install_database()
	{
		if(!self::Connect()) return false;

			self::Create_Database();

			self::Upload('CREATE TABLE if not exists salts
				(
					id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
					salt1 VARCHAR(64) NOT NULL,
					salt2 VARCHAR(64) NOT NULL,
					creating_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
					)ENGINE = InnoDB'
				);
			self::Upload("create table if not exists napok
				(
					id bigint unsigned not null auto_increment,
					request_id bigint not null,
					day date,
					status tinyint(1),
					primary key(id)
				)engine=innodb;
				alter table napok add index(request_id);
				");

			self::Upload("create table if not exists irodahaz
				(
					id bigint unsigned not null auto_increment,
					neve varchar(255) not null,
					cime text not null,
					prevmonth tinyint,
					nextmonth tinyint,
					a_consolerefresh tinyint,
					a_errorrefresh tinyint,
					userrefresh tinyint,
					bossrefresh tinyint,
					primary key(id)
				)engine=innodb;
				alter table irodahaz add index(id);
				");

			self::Upload("create table if not exists users
				(
					id bigint unsigned not null auto_increment,
					name varchar(150) not null,
					username varchar(100) not null,
					beosztas tinyint,
					password varchar(150) not null,
					iroda_id bigint unsigned not null,
					registry_date datetime not null,
                    last_login timestamp not null default current_timestamp,
                    salt_id bigint unsigned not null,
					primary key(id)
					-- foreign key (iroda_id) references irodahaz(id)
				)engine=innoDB;
				alter table users add index(id);
				");

			self::Upload("create table if not exists szabadsag
				(
					id bigint unsigned not null auto_increment,
					user_id bigint unsigned not null,
					mikor timestamp not null default current_timestamp,
					request_id bigint not null,
					indok text,
					latta boolean,
					primary key(id)
					-- foreign key (request_id) references napok(request_id),
					-- foreign key (user_id) references users(id)
				)engine=innoDB;
				");
			return true;
		}


		protected function urlExists($url=NULL)  
		{  
			if($url == NULL) return false;  
			$ch = curl_init($url);  
			curl_setopt($ch, CURLOPT_TIMEOUT, 1);  
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);  
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
			$data = curl_exec($ch);  
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);  
			curl_close($ch);  
			if($httpcode>=200 && $httpcode<300)	return true;  
			else return false;
		}  

		private function Connect()
		{
			$data = $this -> parseData($_POST);		
	//if(!$this -> urlExists($data[1])) return false;		// szerver létezését ellenörző sor (gyorsabb válasz ha nincs ilyen)
			$server = $data[0];
			$user = $data[1];
			$pw = $data[2];
			try
			{
				$conn = new PDO("mysql:host=$server", $user, $pw, array(PDO::ATTR_TIMEOUT => 1));
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
				'type' => 3,
				'password' => hash("md5",$data[2]),
				'office' => 1
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