<?php



class User {

	public $username, $password, $first_name, $last_name, $natio_id, $gender,
			$current_location, $email_address, $contact_number, $user_image, $birth_date;


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

}