<?php

include "class/database.php";

$status = array();

$status['status'] = 0;
$status['response'] = "Unsuccessful";

if (isset($_POST)) {
	
	$db = new Database();
	$con = $db->connect();


	$id = $_POST['id'];
	$post_id = $_POST['post_id'];
	$type = $_POST['type'];

	$str_query = "SELECT * FROM attendees WHERE post_id = $post_id AND post_type = '$type' AND user_id = $id AND collaboration_status = 'Y'";
	
	if ($result = $con->query($str_query)) {
		if ($result->num_rows > 0) {
			$status['status'] = 1;
			$status['response'] = "Successful";
		} else {
			$status['status'] = 1;
			$status['response'] = "Not yet joined.";
		}
	}
}


echo json_encode($status);