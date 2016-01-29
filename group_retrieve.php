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

	if($query_type == 'all') {
		$str_query = "SELECT g.* 
				FROM groups g
				WHERE g.created_by = $id AND g.active_flag = 'A'";
	} else if ($query_type == 'individual') {
		$str_query = "SELECT g.* 
				FROM groups g
				WHERE g.id = $id";
	} else if ($query_type == 'newsfeed') {
		$str_query = "SELECT g.* 
				FROM groups g
				WHERE g.active_flag = 'A'
				LIMIT 10";
	}
	
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

				$query_members = "SELECT u.id AS user_id, u.first_name, u.last_name, g.*
									FROM group_members g
									INNER JOIN users u
									ON g.user_id = u.id
									WHERE g.group_id = $group->id";

				$group_info['members'] = array();

				if($result1 = $con->query($query_members)){
					$group_info['count_members'] = $result1->num_rows;
					while($members = $result1->fetch_object()) {
						$group_members['user_id'] = $members->user_id;
						$group_members['first_name'] = $members->first_name;
						$group_members['last_name'] = $members->last_name;
						array_push($group_info['members'], $group_members);
					}
				}
				array_push($status['group'], $group_info);
			}
		} else {
			$status['status'] = 0;
			$status['response'] = "No group";
		}
	}
}


echo json_encode($status);