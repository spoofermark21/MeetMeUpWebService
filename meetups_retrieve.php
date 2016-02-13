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

		$user_id = $_POST['user_id'];

		$str_query = "SELECT * FROM (
						SELECT CONCAT(u.first_name, ' ', u.last_name) posted_by_user, m.*
						FROM meetups m
						LEFT JOIN users u
						ON  u.id = m.posted_by
						WHERE m.posted_by = $user_id AND m.active_flag = 'A' 

						UNION 

						SELECT CONCAT(u.first_name, ' ', u.last_name) posted_by_user, m.*
						FROM  attendees a
							LEFT JOIN meetups m
						ON a.post_id = m.id
							LEFT JOIN users u
						ON  u.id = m.posted_by
						WHERE a.user_id = $user_id AND posted_by <> $user_id AND m.active_flag = 'A' AND a.collaboration_status = 'Y' AND a.post_type = 'M'
					) k";
	} else if ($query_type == 'individual') {
		$str_query = "SELECT m.*
					FROM meetups m
					WHERE m.id = $id";
	} else if ($query_type == 'newsfeed') {
		$user_id = $_POST['user_id'];
		$str_query = "SELECT CONCAT(u.first_name, ' ', u.last_name) posted_by_user, u.user_image, TIMEDIFF(NOW(),m.posted_date) as 'time_diff', m.*
						FROM meetups m
						LEFT JOIN users u
						ON  u.id = m.posted_by
						WHERE m.active_flag = 'A' AND m.posted_by <> $user_id
						ORDER BY m.posted_date DESC
						/*AND m.pref_start_age <= u.pref_start_age
								AND m.pref_end_age >= u.pref_end_age
								AND m.pref_gender = u.pref_gender*/
						LIMIT 10";
	} else if ($query_type == 'invidual_join_user') {
		$str_query = "SELECT CONCAT(u.first_name, ' ', u.last_name) posted_by_user, m.*
						FROM meetups m
						LEFT JOIN users u
						ON  u.id = m.posted_by
						WHERE m.id = $id";
	} 
	

	if ($result = $con->query($str_query)) {

		if ($result->num_rows > 0) {

			$status['status'] = 1;
			$status['response'] = "Successful";
			$status['meetups'] = array();

			while ($meetups = $result->fetch_object()) {
				$meetups_info = array();

				$meetups_info['id'] = $meetups->id;
				$meetups_info['key'] = $meetups->pass_key;
				$meetups_info['posted_by'] = $meetups->posted_by;
				
				if($query_type == 'invidual_join_user' || 
					$query_type == 'newsfeed' || $query_type == 'all') {
					$meetups_info['posted_by_user'] = $meetups->posted_by_user;
				}

				if($query_type == 'newsfeed') {
					$meetups_info['user_image'] = $meetups->user_image;
					$meetups_info['time_diff'] = $meetups->time_diff;
				}
				
				$meetups_info['lattitude'] = $meetups->lattitude;
				$meetups_info['longtitude'] = $meetups->longtitude;

				$meetups_info['subject'] = $meetups->subject;
				$meetups_info['details'] = $meetups->details;
				$meetups_info['location'] = $meetups->location;
				$meetups_info['posted_date'] = $meetups->posted_date;
				$meetups_info['pref_start_age'] = $meetups->pref_start_age;
				$meetups_info['pref_end_age'] = $meetups->pref_end_age;
				$meetups_info['pref_gender'] = $meetups->pref_gender;
				$meetups_info['avail_status'] = $meetups->avail_status;
				$meetups_info['active_flag'] = $meetups->active_flag;

				array_push($status['meetups'], $meetups_info);
			}
		} else {
			$status['status'] = 0;
			$status['response'] = "No meetups";
		}
	}
}


echo json_encode($status);