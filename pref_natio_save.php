<?php

include "class/database.php";
include "class/user.php";

$status = array();

$status['status'] = "0";
$status['response'] = "Unsuccessful";


if (isset($_POST)) {
	
	$db = new Database();
	$con = $db->connect();

	$natio_id = $_POST['natio_id'];
	$natio_type = $_POST['natio_type'];
	$random_key = $_POST['random_key'];

	$str_query1 = "SELECT * FROM meetups WHERE pass_key = '$random_key'";

	if($result1 = $con->query($str_query1)) {
		$row = $result1->fetch_object();
		$meetup_id = $row->id;

		$str_query2 = "INSERT INTO preferred_nationalities (meetup_id, natio_id, natio_type) 
		VALUES ($meetup_id, $natio_id, '$natio_type')";

		if($result2 = $con->query($str_query2)){
			$status['status'] = "1";
			$status['response'] = "Successful";
		}
	}
			
}

echo json_encode($status);