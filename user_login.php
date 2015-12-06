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
	/*$username = "mark";
	$password = "mark";
	$type_login = "in";*/

	$str_query = 	"SELECT *
					FROM meetmeup.users
					WHERE username = '$username' AND password = '$password'";

	if ($result = $con->query($str_query)) {

		if ($result->num_rows > 0) {

			if ($user = $result->fetch_object()) {
				$user_info = array($user->id, $user->first_name . ' ' .  $user->last_name); 
				
				if($type_login == 'in') {
					$str_query = "INSERT INTO meetmeup.user_logs (user_id, login_date) VALUES (". $user->id .", NOW())";
					if($con->query($str_query)) {
						$status['status'] = 1;
						$status['response'] = "Successful.";
						$status['user'] = $user_info;
					}
				} /*else if($type_login == 'out') {
					$str_query = "UPDATE meetmeup.user_logs SET logout_date = NOW() WHERE user_id = ". $username;
					if($con->query($str_query)) {
						$status['status'] = 1;
						$status['response'] = "Successful";
						$status['user'] = $user_info;
					}
				}*/
			}
		} else {
			$status['status'] = 0;
			$status['response'] = "Username or Password is incorrect.";
		}
	}
}


echo json_encode($status);