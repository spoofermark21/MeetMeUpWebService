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
	$subject = $_POST['subject'];
	$details = $_POST['details'];
	$location = $_POST['location'];
	$start_age = $_POST['start_age'];
	$end_age = $_POST['end_age'];
	$gender = $_POST['gender'];
	$lattitude = $_POST['lattitude'];
	$longtitude = $_POST['longtitude'];

	$random_key = generateRandomKey(10);

	$str_query = 	"INSERT INTO meetups 
					(lattitude, longtitude, pass_key, posted_by, subject, details, location, posted_date, pref_start_age, pref_end_age, pref_gender, avail_status, active_flag)
					VALUES
					('$lattitude','$longtitude','$random_key', $user_id, '$subject', '$details','$location', NOW(), $start_age, $end_age, '$gender', 'A', 'A')";


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