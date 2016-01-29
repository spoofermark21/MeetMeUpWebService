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
	$post_comment_id = $_POST['post_comment_id'];

	$str_query = "UPDATE attendees SET collaboration_status = 'Y', accepted_date = NOW() WHERE user_id = $user_id AND post_id = $post_comment_id AND post_type = 'M'";

	if ($result = $con->query($str_query)) {
			$status['status'] = "1";
			$status['response'] = "Successful";
	
	} 

}


echo json_encode($status);