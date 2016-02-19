<?php

include "class/database.php";

$status = array();

$status['status'] = 0;
$status['response'] = "Unsuccessful";

if (isset($_POST)) {
	
	$db = new Database();
	$con = $db->connect();

	$group_id = $_POST["group_id"];
	
	$str_query = "SELECT u.id AS id_user, u.first_name, u.last_name, u.user_image, g.*
					FROM group_members g
					LEFT JOIN users u
					ON g.user_id = u.id
					WHERE g.group_id = $group_id AND g.collaboration_status = 'A'";


	if ($result = $con->query($str_query)) {

		if ($result->num_rows > 0) {

			$status['status'] = 1;
			$status['response'] = "Successful";
			$status['group_members'] = array();

			while ($group_members = $result->fetch_object()) {
				$group_info = array();

				$group_info['id_user'] = $group_members->id_user;
				$group_info['first_name'] = $group_members->first_name;
				$group_info['last_name'] = $group_members->last_name;
				$group_info['user_image'] = $group_members->user_image;
				
				array_push($status['group_members'], $group_info);
			}
		} else {
			$status['status'] = 0;
			$status['response'] = "No group member";
		}
	}
}


echo json_encode($status);