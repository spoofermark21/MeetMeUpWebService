<?php

include "class/database.php";
include "class/user.php";

$status = array();


$status['status'] = "0";
$status['response'] = "Unsuccessful";



if (isset($_POST)) {
	
	$db = new Database();
	$con = $db->connect();

	$id = $_POST['id'];
	
	$query_type = $_POST['query_type'];
	
	

	if($query_type == 'disable') {
		$str_query = "UPDATE groups 
						SET active_flag = 'D'
						WHERE id = $id";
	} else if ($query_type == 'update') {
		$group_name = $_POST['group_name'];
		$details = $_POST['details'];
		$group_image = $_POST['group_image'];

		$str_query = 	"UPDATE groups 
						SET group_name = '$group_name', details = '$details', group_image = '$group_image'
						WHERE id = $id";
	}


	if ($result = $con->query($str_query)) {
		
		if ($result->num_rows == 0) {
			$status['status'] = "1";
			$status['response'] = "Successful";
		} 
	} 

}


echo json_encode($status);