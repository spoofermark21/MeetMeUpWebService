<?php

include "class/database.php";
include "class/user.php";

$status = array();


$status['status'] = "0";
$status['response'] = "Unsuccessful";


if (isset($_POST)) {
	
	$db = new Database();
	$con = $db->connect();

	$id = $_POST['id'];	
	$str_query = '';
	$query_type = $_POST['query_type'];

	if($query_type == 'disable') {
		$str_query = "UPDATE meetups 
						SET active_flag = 'D' 
						WHERE id = $id";
	} else if($query_type == 'update'){		
		$subject = $_POST['subject'];
		$details = $_POST['details'];
		$location = $_POST['location'];
		$start_age = $_POST['start_age'];
		$end_age = $_POST['end_age'];
		$gender = $_POST['gender'];

		$str_query = 	"UPDATE meetups 
							SET subject='$subject', details='$details', location='$location', pref_start_age=$start_age, pref_end_age=$end_age, pref_gender='$gender' 
							WHERE id = $id";
	}

	if ($result = $con->query($str_query)) {
			$status['status'] = "1";
			$status['response'] = "Successful";
	
	} 

}


echo json_encode($status);