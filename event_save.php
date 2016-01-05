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
	$event_name = $_POST['event_name'];
	$event_type = $_POST['event_type'];
	$details = $_POST['details'];
	$location = $_POST['location'];
	$start_date = $_POST['start_date'];
	$end_date = $_POST['end_date'];

	$random_key = generateRandomKey(10);

	$str_query = 	"INSERT INTO meetmeup.events 
					(event_name, event_type, pass_key, details, location, start_date, end_date, posted_date, posted_by, posted_by_type, avail_status, active_flag)
					VALUES 
					('$event_name', '$event_type', '$random_key', '$details', '$location', '$start_date', '$end_date', NOW(), $user_id, 'U', 'A', 'A');";


	if ($result = $con->query($str_query)) {
		$status['status'] = "1";
		$status['response'] = "Successful";
	} 

}


function generateRandomKey($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

echo json_encode($status);