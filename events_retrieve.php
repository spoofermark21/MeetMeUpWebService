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
		$str_query = "SELECT * FROM (
						SELECT CONCAT(u.first_name, ' ', u.last_name) posted_by_user, e.*
						FROM EVENTS e
						LEFT JOIN users u
						ON  u.id = e.posted_by
						WHERE e.posted_by = $id AND e.active_flag = 'A'

						UNION 

						SELECT CONCAT(u.first_name, ' ', u.last_name) posted_by_user, e.*
						FROM  attendees a
							LEFT JOIN EVENTS e
						ON a.post_id = e.id
							LEFT JOIN users u
						ON  u.id = e.posted_by
						WHERE a.user_id = $id AND e.posted_by <> $id AND u.active_flag = 'A' AND a.collaboration_status = 'Y' AND a.post_type = 'E'
					) k";
	} else if ($query_type == 'individual'){
		$str_query = "SELECT e.*
						FROM events e
						WHERE e.id = $id";
	} else if ($query_type == 'newsfeed') {
		$user_id = $_POST['user_id'];
		$str_query = "SELECT CONCAT(u.first_name, ' ', u.last_name) posted_by_user, u.user_image, TIMEDIFF(NOW(),e.posted_date) as 'time_diff', e.*
						FROM EVENTS e
						LEFT JOIN users u
						ON  u.id = e.posted_by
						WHERE e.active_flag = 'A' AND e.posted_by <> $user_id
						ORDER BY e.posted_by DESC
						LIMIT 10";
	} else if ($query_type == 'individual_join_user') {
		$str_query = "SELECT CONCAT(u.first_name, ' ', u.last_name) posted_by_user, e.*
						FROM EVENTS e
						LEFT JOIN users u
						ON  u.id = e.posted_by
						WHERE e.id = $id";
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

				if($query_type == 'newsfeed') {
					$events_info['posted_by_user'] = $events->posted_by_user;
					$events_info['user_image'] = $events->user_image;
					$events_info['time_diff'] = $events->time_diff;
				}

				if($query_type == 'all') {
					$events_info['posted_by_user'] = $events->posted_by_user;
				}

				if($query_type == 'individual_join_user') {
					$events_info['posted_by_user'] = $events->posted_by_user;
				}

				$events_info['posted_by'] = $events->posted_by;
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