<?php

include "class/database.php";
include "class/user.php";

$status = array();

$status['status'] = "0";
$status['response'] = "Unsuccessful";


if (isset($_POST)) {
	
	$db = new Database();
	$con = $db->connect();

	$user_id = $_POST['user_id'];
	$post_id = $_POST['post_id'];
	$post_type = $_POST['post_type'];
	$collaboration_status = $_POST['collaboration_status'];
	$request_date = $_POST['request_date'];

	$str_query = "SELECT * FROM attendees WHERE user_id = $user_id";

	if($result = $con->query($str_query)) {
		if($result->num_rows < 1) {
			$str_query = "INSERT INTO attendees (post_id, post_type, user_id, collaboration_status, request_date) VALUES ($post_id, '$post_type', $user_id, '$collaboration_status', $request_date);";

			if ($result = $con->query($str_query)) {
				$status['status'] = "1";
				$status['response'] = "Successful";
			} 
		} else {
			$status['status'] = "0";
			$status['response'] = "Already sent a request.";
		}
	}

	

}


echo json_encode($status);