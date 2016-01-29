<?php

include "class/database.php";
include "class/user.php";

$status = array();


$status['status'] = "0";
$status['response'] = "Unsuccessful";


if (isset($_POST)) {
	
	$db = new Database();
	$con = $db->connect();

	$notif_id = $_POST['notif_id'];
	/*$user_id = $_POST['user_id'];
	$from_id = $_POST['from_id'];
	$post_comment_id = $_POST['post_comment_id'];
	$details = $_POST['details'];*/

	$str_query = "UPDATE notifications SET view_flag = 'Y' WHERE id = $notif_id";

	if ($result = $con->query($str_query)) {
			$status['status'] = "1";
			$status['response'] = "Successful";
	
	} 

}


echo json_encode($status);