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
	$group_id = $_POST['group_id'];

	$str_query = "SELECT *
						FROM group_members
						WHERE group_id = $group_id AND user_id = $user_id";

	if($result = $con->query($str_query)) {
		if($result->num_rows < 1) {
			$str_query = "INSERT INTO group_members (group_id, user_id, collaboration_status, request_date)
							VALUES ($group_id,$user_id,'D', NOW())";

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