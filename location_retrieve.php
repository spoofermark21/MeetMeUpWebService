<?php

include "class/database.php";
include "class/user.php";

$status = array();


$status['status'] = "0";
$status['response'] = "Unsuccessful";


if (isset($_POST)) {
	$db = new Database();

	$con = $db->connect();

	$str_query = "SELECT * FROM location";

	if ($result = $con->query($str_query)) {
		
		$status['status'] = "1";
		$status['response'] = "Successful";	
		$status['location'] = array();

		while ($place = $result->fetch_object()) {
			$location = array();
			$location['id'] = $place->id;
			$location['location'] = $place->location;
			$location['lattitude'] = $place->lattitude;
			$location['longtitude'] = $place->longtitude;
			
			array_push($status['location'], $location);
		}
		$status['status'] = "1";
		$status['response'] = "Successful";
	} 

}

echo json_encode($status);