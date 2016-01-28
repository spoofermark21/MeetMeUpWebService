<?php

include "class/database.php";

$status = array();

$status['status'] = 0;
$status['response'] = "Unsuccessful";

if (isset($_POST)) {
	
	$db = new Database();
	$con = $db->connect();


	$id = $_POST['id'];

	$str_query = "SELECT * FROM attendees WHERE accepted_date IS NOT NULL AND user_id = $id";
	
	if ($result = $con->query($str_query)) {
		if ($result->num_rows > 0) {
			$status['status'] = 1;
			$status['response'] = "Successful";
		} else {
			$status['status'] = 0;
			$status['response'] = "Not yet joined.";
		}
	}
}


echo json_encode($status);