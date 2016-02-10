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
		$str_query = "SELECT * FROM (
						SELECT CONCAT(u.first_name, ' ', u.last_name) created_by_user, g.*
						FROM groups g
						LEFT JOIN users u
						ON  u.id = g.created_by
						WHERE g.created_by = $id AND g.active_flag = 'A'

						UNION 

						SELECT CONCAT(u.first_name, ' ', u.last_name) created_by_user, g.*
						FROM  groups g
							LEFT JOIN group_members gm
						ON gm.group_id = g.id
							LEFT JOIN users u
						ON  u.id = g.created_by
						WHERE gm.user_id = $id AND g.created_by <> $id AND g.active_flag = 'A' 
					) k";
	} else if ($query_type == 'individual') {
		$str_query = "SELECT g.* 
				FROM groups g
				WHERE g.id = $id";
	} else if ($query_type == 'newsfeed') {
		$str_query = "SELECT g.*, CONCAT(u.first_name, ' ', u.last_name) created_by_user, u.user_image,  TIMEDIFF(NOW(),g.created_date) AS 'time_diff'
				FROM groups g
				LEFT JOIN users u
				ON u.id = g.created_by
				WHERE g.active_flag = 'A'
				LIMIT 10";
	} else if ($query_type == 'individual_join_user') {
		$str_query = "SELECT CONCAT(u.first_name, ' ', u.last_name) created_by_user, u.user_image, g.*
						FROM groups g
						LEFT JOIN users u
						ON  u.id = g.created_by
						WHERE g.id = $id";
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

				if($query_type == 'all') {
					$group_info['created_by_user'] = $group->created_by_user;
				}
				
				if($query_type == 'newsfeed') {
					$group_info['created_by_user'] = $group->created_by_user;
					$group_info['user_image'] = $group->user_image;
					$group_info['time_diff'] = $group->time_diff;
				}

				if($query_type == 'individual_join_user') {
					$group_info['created_by_user'] = $group->created_by_user;
					$group_info['user_image'] = $group->user_image;
				}

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