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
	$post_id = $_POST['post_id'];
	$post_type = $_POST['post_type'];
	$comment = $_POST['comment'];

	$str_query = "INSERT INTO comments (post_id, post_type, user_id, COMMENT, comment_date) VALUES ($post_id,'$post_type', $user_id, '$comment', NOW())";


	if ($result = $con->query($str_query)) {
		$status['status'] = "1";
		$status['response'] = "Successful";
	} 

}


echo json_encode($status);