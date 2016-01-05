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
				FROM meetmeup.groups g
				WHERE g.created_by = $id";
	} else if ($query_type == 'individual') {
		$str_query = "SELECT g.* 
				FROM meetmeup.groups g
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

				$query_members = "SELECT COUNT(*) members
									FROM meetmeup.group_members 
									WHERE group_id = $group->id";

				if($result1 = $con->query($query_members)){
					while($count = $result1->fetch_object()) {
						$group_info['count_members'] = $count->members;
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