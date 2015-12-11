<?php

public Nationality () {

	private $id;
	private $nationality; 

	function __construct ($id, $nationality) {
		$this->id = $id;
		$this->nationality = $nationality;
	}

	function set_id ($id) {
		$this->id = $id;
	} 

	function set_nationality ($nationality) {
		$this->nationality = $nationality;
	}

	function get_id () {
		return $this->id;
	}

	function get_nationality () {
		return $this->nationality;
	}

}