<?php

include "class/database.php";
include "class/user.php";

$status = array();


$status['status'] = "0";
$status['response'] = "Unsuccessful";


if (isset($_POST)) {
	
	$db = new Database();
	$con = $db->connect();

	$str_query = "";

	$query_type = $_POST['query_type'];
	$id = $_POST['id'];	
	$user_id = $_POST['user_id'];

	if($query_type == 'attendees') {
		$type = $_POST['type'];
		$str_query = "UPDATE attendees SET collaboration_status = 'N' 
						WHERE user_id = $user_id AND post_id = $id AND post_type = '$type'";
	} else if($query_type == 'group'){		
		$str_query = "UPDATE group_members SET collaboration_status = 'D' WHERE user_id = $user_id AND group_id = $id";
	}

	if ($result = $con->query($str_query)) {
		$status['status'] = "1";
		$status['response'] = "Successful";
	} 

}


echo json_encode($status);