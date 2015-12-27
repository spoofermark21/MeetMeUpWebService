<?php

include "class/database.php";

$status = array();

$status['status'] = 0;
$status['response'] = "Unsuccessful";

if (isset($_POST)) {
	
	$db = new Database();
	$con = $db->connect();


	$user_id = $_POST['user_id'];

	$str_query = 	"SELECT *
						FROM meetmeup.users
						WHERE id = $user_id";

	if ($result = $con->query($str_query)) {

		if ($result->num_rows > 0) {
			$status['status'] = 1;
			$status['response'] = "Successful";
			$status['user'] = array();
			while ($user = $result->fetch_object()) {
				$user_info = array();

				$user_info['min_age'] = $user->pref_start_age;
				$user_info['max_age'] = $user->pref_end_age;
				$user_info['gender'] = $user->pref_gender;
				$user_info['pref_location'] = $user->pref_location;

				array_push($status['user'], $user_info);
			}
		} 
	} 
	
}


echo json_encode($status);