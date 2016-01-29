<?php

include "class/database.php";

$status = array();

$status['status'] = 0;
$status['response'] = "Unsuccessful";

if (isset($_POST)) {
	
	$db = new Database();
	$con = $db->connect();


	$id = $_POST['id'];
	$query_type = $_POST['query_type'];

	$str_query = "";

	if($query_type == 'view') {
		$str_query = "SELECT * FROM attendees WHERE accepted_date IS NULL AND user_id = $id";
	} 
	
	if ($result = $con->query($str_query)) {

		if ($result->num_rows > 0) {

			$status['status'] = 1;
			$status['response'] = "Successful";
			$status['attendees'] = array();

			while ($attendees = $result->fetch_object()) {
				$attendees_info = array();

				$attendees_info['id'] = $attendees->id;
				$attendees_info['post_id'] = $attendees->post_id;
				$attendees_info['post_type'] = $attendees->post_type;
				$attendees_info['user_id'] = $attendees->user_id;
				$attendees_info['collaboration_status'] = $attendees->collaboration_status;
				$attendees_info['request_date'] = $attendees->request_date;
				$attendees_info['accepted_date'] = $attendees->accepted_date;
				$attendees_info['view_flag'] = $attendees->view_flag;

				array_push($status['attendees'], $attendees_info);
			}
		} else {
			$status['status'] = 1;
			$status['response'] = "Not yet joined.";
		}
	}
}


echo json_encode($status);