<?php


class Database {


	/*private $con;
	private $server = 'mysql13.000webhost.com';
	private $user = 'a9118981_root';
	private $password = 'meetmeup21';
	private $database = 'a9118981_mmu';
	*/
	private $server = 'localhost';
	private $user = 'root';
	private $password = '';
	private $database = 'meetmeup';


	function connect() {
		$this->con = new mysqli($this->server, $this->user, $this->password, $this->database);

		if ($this->con->connect_errno) {
			throw new Exception("ERROR connecting to database.", 1);
		}

		return $this->con;
	}


}

