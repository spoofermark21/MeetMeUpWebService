<?php

include "class/database.php";
include "class/user.php";

$status = array();


$status['status'] = "0";
$status['response'] = "Unsuccessful";


if (isset($_POST['username']) && isset($_POST['password'])) {
	
	$db = new Database();
	$con = $db->connect();

	/*
	$user = new User($_POST['username'], $_POST['password'], $_POST['first_name'], $_POST['last_name'], 
		$_POST['birth_date'], $_POST['natio_id'], $_POST['gender'], $_POST['current_location'], $_POST['email_address'], 
		$_POST['contact_number'], $_POST['file_name']);*/

	$username = $_POST['username'];
	$password = $_POST['password'];
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name']; 
	$birth_date = $_POST['birth_date'];
	$natio_id = $_POST['natio_id'];
	$gender = $_POST['gender'];
	$current_location = $_POST['current_location'];
	$email_address = $_POST['email_address']; 
	$contact_number = $_POST['contact_number'];
	$file_name = $_POST['file_name'];
	
	/* for testing purposes
	$user = new User('marksibi', 'marksibi', 'mark', 'sibi', 
		'2015-10-1', 19, 'M', 'Mandaue', 'sibi.mark21@gmail.com', 0932905488,
		'mark');
	*/
	/*
	$natio_id = $_POST['natio_id'];
	$file_name = $_POST['file_name'];
	*/
	$str_query = "SELECT * FROM users WHERE username = '$user->username'";

	if ($result = $con->query($str_query)) {
		
		if ($result->num_rows == 0) {

			$str_query = 	"INSERT INTO users
						(username, password, first_name, last_name, bdate, 
						natio_id, gender, current_location, email_address,
						contact_number, user_image,date_registered) 
					VALUES
						('$username', '$password', '$first_name', '$last_name',
						 '$birth_date', $natio_id, '$gender', 
						 '$current_location', '$email_address', '$contact_number', 
						 '$file_name', NOW())";

			if ($con->query($str_query)) {
				$status['status'] = "1";
				$status['response'] = "Successful";
			}

		} else {
			$status['response'] = "Username is already taken. Please try again.";
		}

	} 

}


echo json_encode($status);