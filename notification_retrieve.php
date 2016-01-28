<?php

include "class/database.php";
include "class/user.php";

$status = array();


$status['status'] = "0";
$status['response'] = "Unsuccessful";


if (isset($_POST)) {
	$db = new Database();

	$con = $db->connect();

	$str_query = "SELECT * FROM notifications";

	if ($result = $con->query($str_query)) {
		
		$status['status'] = "1";
		$status['response'] = "Successful";	

		$status['notifications'] = array();

		if($result->num_rows > 0) {
			while ($natio = $result->fetch_object()) {
				$notifications = array();
				$notifications['id'] = $natio->id;
				
				array_push($status['notifications'], $notifications);
			}
			$status['response'] = "New notifications.";	
		} else {
			$status['response'] = "No notifications.";	
		}

		
	} 

}

echo json_encode($status);