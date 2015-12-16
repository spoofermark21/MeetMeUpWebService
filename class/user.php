<?php



class User {

	private $id;
	private $username;
	private $password;
	private $first_name;
	private $last_name;
	private $natio_id;
	private $gender;
	private $current_location;
	private $email_address; 
	private $contact_number;
	private $user_image;
	private $birth_date;


	function __construct ($username, $password, $first_name, $last_name, $birth_date, $natio_id, $gender,
			$current_location, $email_address, $contact_number, $user_image) {
		$this->username = $username;
		$this->password = $password;
		$this->first_name = $first_name;
		$this->last_name = $last_name;
		$this->gender = $gender;
		$this->birth_date = $birth_date;
		$this->natio_id = $natio_id;
		$this->current_location = $current_location;
		$this->email_address = $email_address;
		$this->contact_number = $contact_number;
		$this->user_image = $user_image;
	}

	function set_id($id) {
		$this->id = id;
	}

	function get_id() {
		return $this->id;
	}

	function set_username($username){
		$this->username = $username;
	}

	function get_username() {
		return $this->username;
	}

	function set_password($password) {
		$this->password = $password;
	}

	function get_password(){
		return $this->password;
	}

	function set_firstname($first_name) {
		$this->first_name = $first_name;
	}

	function get_firstname() {
		return $this->first_name;
	}

	function set_lastname($last_name) {
		$this->last_name = $last_name;
	}

	function get_lastname(){
		return $this->last_name;
	}

	function set_gender($gender) {
		$this->gender = gender;
	}

	function get_gender() {
		return $this->gender;
	}

	function set_birthdate($birth_date) {
		$this->birth_date = $birth_date;
	}

	function get_birthdate() {
		return $this->birthdate;
	}

	function set_natio_id($natio_id) {
		$this->natio_id = $natio_id;
	}
}