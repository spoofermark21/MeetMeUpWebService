<?php

include "class/database.php";

$status = array();

$status['status'] = 0;
$status['response'] = "Unsuccessful";

if (isset($_POST['user_id'])) {
	
	$db = new Database();
	$con = $db->connect();

	$user_id = $_POST['user_id'];
	

	$str_query = "UPDATE user_logs 
						SET logout_date = NOW() 
					WHERE user_id = $user_id 
						AND logout_date IS NULL";
					

	if ($con->query($str_query)) {
		$status['status'] = 1;
		$status['response'] = "Successful";	
	}  else {
		$status['response'] = $user_id;
	}
		
}


echo json_encode($status);