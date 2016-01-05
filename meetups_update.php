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
		$str_query = "UPDATE meetmeup.meetups 
						SET active_flag = 'D' 
						WHERE id = $id";
	} else if($query_type == 'update'){ /*
		$event_name = $_POST['event_name'];
		$details = $_POST['details'];
		$location = $_POST['location'];
		$type = $_POST['type'];
		$start_date = $_POST['start_date'];
		$end_date = $_POST['end_date'];

		$str_query = 	"UPDATE meetmeup.events 
							SET event_name='$event_name', event_type='$type', details='$details', location='$location',
								start_date='$start_date', end_date='$end_date' 
							WHERE id=$id";*/
	}

	if ($result = $con->query($str_query)) {
			$status['status'] = "1";
			$status['response'] = "Successful";
	
	} 

}


echo json_encode($status);