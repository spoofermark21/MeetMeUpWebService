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
	$from_id = $_POST['from_id'];
	$post_comment_id = $_POST['post_comment_id'];
	$type = $_POST['type'];
	$details = $_POST['details'];

	$str_query = "INSERT INTO notifications (user_id, from_id, post_comment_id, TYPE, details) VALUES ($user_id,$from_id,$post_comment_id,'$type', '$details')";


	if ($result = $con->query($str_query)) {
		$status['status'] = "1";
		$status['response'] = "Successful";
	} 

}


echo json_encode($status);