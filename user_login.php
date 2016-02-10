<?php

include "class/database.php";

$status = array();

$status['status'] = 0;
$status['response'] = "Unsuccessful";

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['type_login'])) {
	
	$db = new Database();
	$con = $db->connect();

	$username = $_POST['username'];
	$password = $_POST['password'];
	$type_login = $_POST['type_login'];
	
	//for testing
	/*
	$username = "";
	$password = "";
	$type_login = "in";
*/
	$str_query = 	"SELECT *
					FROM users
					WHERE username = '$username' AND password = '$password'";

	if ($result = $con->query($str_query)) {

		if ($result->num_rows > 0) {

			if ($user = $result->fetch_object()) {
				$user_info = array();

				$user_info = array($user->id, $user->first_name, $user->last_name, $user->natio_id, $user->user_image);
				/*$user_info = array($user->id, $user->first_name, $user->last_name,
					$user->bdate, $user->natio_id, $user->gender, $user->current_location,
					$user->email_address, $user->contact_number, $user->privacy_flag,
					$user->pref_start_age, $user->pref_end_age, $user->pref_gender,
					$user->pref_location, $user->active_flag, $user->user_image,
					$user->date_registered); */

				/*$user_info['id'] = $user->id;
				$user_info['first_name'] = $user->first_name;
				$user_info['last_name'] = $user->last_name;
				$user_info['natio_id'] = $user->natio_id;*/
				
				if($type_login == 'in') {
					$str_query = "INSERT INTO user_logs (user_id, login_date) VALUES (". $user->id .", NOW())";
					if($con->query($str_query)) {
						$status['status'] = 1;
						$status['response'] = "Successful";
						$status['user'] = $user_info;
					}
				}
			}
		} else {
			$status['status'] = 0;
			$status['response'] = "Username or Password is incorrect.";
		}
	}
}


echo json_encode($status);