<?php

include "class/database.php";
include "class/user.php";

$status = array();


$status['status'] = "0";
$status['response'] = "Unsuccessful";


if (isset($_POST)) {
	$db = new Database();
	$con = $db->connect();

	$user_id = $_POST['user_id'];

	$str_query = "SELECT n.*, CONCAT(u.first_name, ' ' , u.last_name) 'from_user'
					FROM notifications n
						LEFT JOIN users u
					ON u.id = n.from_id
					WHERE user_id = $user_id AND view_flag = 'N'
					GROUP BY user_id,from_id, post_comment_id
					ORDER BY date_notified DESC";

	if ($result = $con->query($str_query)) {
		
		$status['status'] = "1";
		$status['response'] = "Successful";	

		$status['notifications'] = array();

		if($result->num_rows > 0) {
			while ($notifications = $result->fetch_object()) {
				$notifications_info = array();
				$notifications_info['id'] = $notifications->id;
				$notifications_info['user_id'] = $notifications->user_id;
				$notifications_info['from_id'] = $notifications->from_id;
				$notifications_info['post_comment_id'] = $notifications->post_comment_id;
				$notifications_info['type'] = $notifications->type;
				$notifications_info['details'] = $notifications->details;
				$notifications_info['view_flag'] = $notifications->view_flag;
				$notifications_info['date_notified'] = $notifications->date_notified;
				$notifications_info['from_user'] = $notifications->from_user;
				
				//echo json_encode($notifications);

				array_push($status['notifications'], $notifications_info);
			}
			$status['response'] = "New notifications.";	
		} else {
			$status['response'] = "No notifications.";	
		}

		
	} 

}

echo json_encode($status);