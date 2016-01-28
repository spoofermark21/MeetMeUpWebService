<?php

include "class/database.php";

$status = array();

$status['status'] = 0;
$status['response'] = "Unsuccessful";

if (isset($_POST)) {
	
	$db = new Database();
	$con = $db->connect();


	$id = 18;

	$str_query = "SELECT u.id AS user_id, u.first_name, u.last_name, g.*
					FROM group_members g
					INNER JOIN users u
					ON g.user_id = u.id
					WHERE g.group_id = $id";



	if ($result = $con->query($str_query)) {

		if ($result->num_rows > 0) {

			$status['status'] = 1;
			$status['response'] = "Successful";
			$status['group_members'] = array();

			while ($group_members = $result->fetch_object()) {
				$group_info = array();

				$group_info['user_id'] = $group_members->user_id;
				$group_info['first_name'] = $group_members->first_name;
				$group_info['last_name'] = $group_members->last_name;
				
				array_push($status['group_members'], $group_info);
			}
		} else {
			$status['status'] = 0;
			$status['response'] = "No group member";
		}
	}
}


echo json_encode($status);