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
	$min_age = $_POST['min_age'];
	$max_age = $_POST['max_age'];
	$gender = $_POST['gender'];
	$location = $_POST['location'];

	$str_query = 	"UPDATE users
						SET pref_start_age = $min_age, pref_end_age = $max_age, pref_gender = '$gender', pref_location = '$location'
						WHERE id = $id";


	if ($result = $con->query($str_query)) {
		
		if ($result->num_rows == 0) {
			$status['status'] = "1";
			$status['response'] = "Successful";
		} 
	} 

}


echo json_encode($status);