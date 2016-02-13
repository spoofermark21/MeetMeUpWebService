<?php

include "class/database.php";

$status = array();

$status['status'] = 0;
$status['response'] = "Unsuccessful";

if (isset($_POST)) {
	
	$db = new Database();
	$con = $db->connect();


	$id = $_POST['id'];
	$post_id = $_POST['post_id'];
	$type = $_POST['type'];

	$str_query = "SELECT c.*, concat(u.first_name, ' ', u.last_name) user, u.user_image
					FROM comments c
					LEFT JOIN users u
					ON u.id = c.user_id  WHERE c.post_id = $post_id AND c.post_type = '$type' AND c.active_flag = 'A'
					ORDER BY comment_date";
	
	if ($result = $con->query($str_query)) {
		if ($result->num_rows > 0) {
			$status['status'] = 1;
			$status['response'] = "Successful";

			$status['comments'] = array();

			while($record = $result->fetch_object()) {
				$comments_info = array();

				$comments_info['id'] = $record->id;
				$comments_info['user_image'] = $record->user_image;
				$comments_info['post_id'] = $record->post_id;
				$comments_info['post_type'] = $record->post_type;
				$comments_info['user_id'] = $record->user_id;
				$comments_info['comment'] = $record->comment;
				$comments_info['comment_date'] = $record->comment_date;
				$comments_info['user'] = $record->user;

				array_push($status['comments'], $comments_info);

			}
		} else {
			$status['status'] = 0;
			$status['response'] = "No comments";
		}
	}
}


echo json_encode($status);