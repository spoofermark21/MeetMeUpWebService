<?php

include "class/database.php";

$status = array();

$status['status'] = 0;
$status['response'] = "Unsuccessful";

if (isset($_POST)) {
	
	$db = new Database();
	$con = $db->connect();


	$id = $_POST['id'];
	$user_id = $_POST['user_id'];
	$query_type = $_POST['query_type'];


	if($query_type == 'is_member') {
		$str_query = "SELECT * FROM group_members WHERE group_id = $id AND user_id = $user_id AND collaboration_status = 'A'";
	}



	if ($result = $con->query($str_query)) {

		if ($result->num_rows > 0) {

			$status['status'] = 1;
			$status['response'] = "Successful";
			$status['group_members'] = array();

			while ($groups = $result->fetch_object()) {
				$group_members_info = array();

				$group_members_info['user_name'] = $groups->user_name;
				$group_members_info['id'] = $groups->id;	
				$group_members_info['group_id'] = $groups->group_id;
				$group_members_info['collaboration_status'] = $groups->collaboration_status;
				$group_members_info['request_date'] = $groups->request_date;
				$group_members_info['accepted_date'] = $groups->accepted_date;
				
				array_push($status['group_members'], $group_members_info);
			}
		} else {
			$status['status'] = 0;
			$status['response'] = "Not yet joined.";
		}
	}
}


echo json_encode($status);