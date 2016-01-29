<?php

include "class/database.php";
include "class/user.php";

$status = array();


$status['status'] = "0";
$status['response'] = "Unsuccessful";

$user_id = $_POST['user_id'];

if (isset($_POST)) {
	$db = new Database();

	$con = $db->connect();

	$str_query = "SELECT * FROM users WHERE id = $user_id";

	if ($result = $con->query($str_query)) {
		
		$status['status'] = "1";
		$status['response'] = "Successful";	
		$status['nationality'] = array();
		
		while ($natio = $result->fetch_object()) {
			$nationality = array();
			$nationality['id'] = $natio->id;
			$nationality['nationality'] = $natio->nationality;
			
			array_push($status['nationality'], $nationality);
		}
		$status['status'] = "1";
		$status['response'] = "Successful";
	} 

}

echo json_encode($status);