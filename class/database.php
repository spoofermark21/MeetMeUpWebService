<?php


class Database {

	private $con;
	private $server = 'localhost';
	private $user = 'root';
	private $password = '';
	private $database = 'buddies';

	function connect() {
		$this->con = new mysqli($this->server, $this->user, $this->password, $this->database);

		if ($this->con->connect_errno) {
			throw new Exception("ERROR connecting to database.", 1);
		}

		return $this->con;
	}


}

