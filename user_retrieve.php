<?php

include "class/database.php";

$status = array();

$status['status'] = 0;
$status['response'] = "Unsuccessful";

if (isset($_POST)) {
	
	$db = new Database();
	$con = $db->connect();


	$str_query = 	"SELECT *
					FROM users";

	//$type = $_POST['user_info'];
	//$user_id = $_POST['user_id'];

	$type = $_POST['type'];
	$user_id = $_POST['user_id'];

	if($type == 'current_user') {
		$str_query = 	"SELECT *
							FROM users
							WHERE id = $user_id";
	} else if ($type == 'friend_user') {
		$str_query = "";
	}
	

	if ($result = $con->query($str_query)) {

		if ($result->num_rows > 0) {
			$status['status'] = 1;
			$status['response'] = "Successful";
			$status['user'] = array();
			while ($user = $result->fetch_object()) {
				$user_info = array();

				$user_info['id'] = $user->id;
				$user_info['username'] = $user->username;
				$user_info['password'] = $user->password;
				$user_info['first_name'] = $user->first_name;
				$user_info['last_name'] = $user->last_name;
				$user_info['bdate'] = $user->bdate;
				$user_info['natio_id'] = $user->natio_id;
				$user_info['gender'] = $user->gender;
				$user_info['current_location'] = $user->current_location;
				$user_info['email_address'] = $user->email_address;
				$user_info['contact_number'] = $user->contact_number;
				$user_info['privacy_flag'] = $user->privacy_flag;
				$user_info['pref_start_age'] = $user->pref_start_age;
				$user_info['pref_end_age'] = $user->pref_end_age;
				$user_info['pref_gender'] = $user->gender;
				$user_info['pref_location'] = $user->pref_location;
				$user_info['active_flag'] = $user->active_flag;
				$user_info['user_image'] = $user->user_image;
				$user_info['date_registered'] = $user->date_registered;
				/*
				$user->id, $user->first_name, $user->last_name,
					$user->bdate, $user->natio_id, $user->gender, $user->current_location,
					$user->email_address, $user->contact_number, $user->privacy_flag,
					$user->pref_start_age, $user->pref_end_age, $user->pref_gender,
					$user->pref_location, $user->active_flag, $user->user_image,
					$user->date_registered); */
				array_push($status['user'], $user_info);
			}
		} else {
			$status['status'] = 0;
			$status['response'] = "Username or Password is incorrect";
		}
	}
}


echo json_encode($status);