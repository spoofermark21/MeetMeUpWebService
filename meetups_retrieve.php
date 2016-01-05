<?php

include "class/database.php";

$status = array();

$status['status'] = 0;
$status['response'] = "Unsuccessful";

if (isset($_POST)) {
	
	$db = new Database();
	$con = $db->connect();


	$user_id = $_POST['user_id'];
	$query_type = $_POST['filter'];

	if($query_type == 'all') {
		$str_query = "SELECT m.*
					FROM meetmeup.meetups m
					WHERE m.posted_by = $user_id and m.active_flag = 'A'";
	} else {
		$str_query = "SELECT m.*
					FROM meetmeup.meetups m
					WHERE id = $user_id";
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