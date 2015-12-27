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
	$group_name = $_POST['group_name'];
	$details = $_POST['details'];

	$str_query = 	"INSERT INTO meetmeup.groups 
						(group_name, details, created_by, created_date, avail_flag,active_flag, group_image)
					VALUES
						('$group_name','$details', $user_id , NOW(), 'A', 'Y', 'mark.png')";


	if ($result = $con->query($str_query)) {
		$status['status'] = "1";
		$status['response'] = "Successful";
	} 

}


echo json_encode($status);