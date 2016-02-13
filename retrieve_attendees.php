<?php

include "class/database.php";

$status = array();

$status['status'] = 0;
$status['response'] = "Unsuccessful";

if (isset($_POST)) {
	
	$db = new Database();
	$con = $db->connect();

	$post_type = $_POST["post_type"];
	$post_id = $_POST["post_id"];
	
	$str_query = "SELECT u.id AS id_user, u.first_name, u.last_name, u.user_image, a.*
					FROM attendees a
					LEFT JOIN users u
					ON a.user_id = u.id
					WHERE a.post_type = '$post_type' AND a.post_id = $post_id AND a.collaboration_status = 'Y'";


	if ($result = $con->query($str_query)) {

		if ($result->num_rows > 0) {

			$status['status'] = 1;
			$status['response'] = "Successful";
			$status['attendees'] = array();

			while ($attendees = $result->fetch_object()) {
				$attendees_info = array();

				$attendees_info['id_user'] = $attendees->id_user;
				$attendees_info['first_name'] = $attendees->first_name;
				$attendees_info['last_name'] = $attendees->last_name;
				$attendees_info['user_image'] = $attendees->user_image;
				
				array_push($status['attendees'], $attendees_info);
			}
		} else {
			$status['status'] = 0;
			$status['response'] = "No attendees	";
		}
	}
}


echo json_encode($status);