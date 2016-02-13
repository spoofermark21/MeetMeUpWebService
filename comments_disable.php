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

	$str_query = "UPDATE comments SET active_flag = 'D' WHERE id = $id";

	if ($result = $con->query($str_query)) {
		$status['status'] = "1";
		$status['response'] = "Successful";
	} 

}


echo json_encode($status);