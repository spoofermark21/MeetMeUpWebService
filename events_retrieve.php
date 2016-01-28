<?php

include "class/database.php";

$status = array();

$status['status'] = 0;
$status['response'] = "Unsuccessful";

if (isset($_POST)) {
	
	$db = new Database();
	$con = $db->connect();


	$id = $_POST['id'];
	$query_type = $_POST['filter'];

	if($query_type == 'all') {
		$str_query = "SELECT e.*
						FROM events e
						WHERE e.posted_by = $id AND e.active_flag = 'A'
						ORDER BY e.posted_date DESC";
	} else if ($query_type == 'individual'){
		$str_query = "SELECT e.*
						FROM events e
						WHERE e.id = $id";
	} else if ($query_type == 'newsfeed') {
		$str_query = "SELECT e.*
						FROM events e
						WHERE e.active_flag = 'A'
						LIMIT 10";
	}
	

	if ($result = $con->query($str_query)) {

		if ($result->num_rows > 0) {

			$status['status'] = 1;
			$status['response'] = "Successful";
			$status['events'] = array();

			while ($events = $result->fetch_object()) {
				$events_info = array();

				$events_info['id'] = $events->id;
				$events_info['event_name'] = $events->event_name;
				$events_info['event_type'] = $events->event_type;
				$events_info['key'] = $events->pass_key;
				$events_info['details'] = $events->details;
				$events_info['location'] = $events->location;
				$events_info['start_date'] = $events->start_date;
				$events_info['end_date'] = $events->end_date;
				$events_info['posted_date'] = $events->posted_date;
				$events_info['posted_by_type'] = $events->posted_by_type;
				$events_info['avail_status'] = $events->avail_status;
				$events_info['active_flag'] = $events->active_flag;

				array_push($status['events'], $events_info);
			}
		} else {
			$status['status'] = 0;
			$status['response'] = "No events";
		}
	}
}


echo json_encode($status);