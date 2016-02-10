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

	$str_query = "UPDATE group_members SET collaboration_status = 'A', accepted_date = NOW()
						WHERE group_id = $group_id AND user_id = $user_id";

	if ($result = $con->query($str_query)) {
			$status['status'] = "1";
			$status['response'] = "Successful";
	
	} 

}


echo json_encode($status);