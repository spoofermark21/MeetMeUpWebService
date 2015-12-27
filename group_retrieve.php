<?php

include "class/database.php";

$status = array();

$status['status'] = 0;
$status['response'] = "Unsuccessful";

if (isset($_POST)) {
	
	$db = new Database();
	$con = $db->connect();


	$user_id = $_POST['user_id'];

	$str_query = "SELECT g.* 
				FROM meetmeup.groups g
				WHERE g.created_by = $user_id";

	if ($result = $con->query($str_query)) {

		if ($result->num_rows > 0) {

			$status['status'] = 1;
			$status['response'] = "Successful";
			$status['group'] = array();

			while ($group = $result->fetch_object()) {
				$group_info = array();

				$group_info['id'] = $group->id;
				$group_info['group_name'] = $group->group_name;
				$group_info['details'] = $group->details;
				$group_info['created_by'] = $group->created_by;
				$group_info['created_date'] = $group->created_date;
				$group_info['avail_flag'] = $group->avail_flag;
				$group_info['active_flag'] = $group->active_flag;
				$group_info['group_image'] = $group->group_image;

				array_push($status['group'], $group_info);
			}
		} else {
			$status['status'] = 0;
			$status['response'] = "No group";
		}
	}
}


echo json_encode($status);