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
	$group_name = $_POST['group_name'];
	$details = $_POST['details'];
	
	$str_query = 	"UPDATE meetmeup.groups 
						SET group_name = '$group_name', details = '$details'
						WHERE id = $id";


	if ($result = $con->query($str_query)) {
		
		if ($result->num_rows == 0) {
			$status['status'] = "1";
			$status['response'] = "Successful";
		} 
	} 

}


echo json_encode($status);