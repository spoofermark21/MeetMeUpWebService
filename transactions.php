<?php

include "class/database.php";

$db = new Database();
$con = $db->connect();

$get_query = $_POST['get_query'];
$type = $_POST['type'];



if($type=='select') {
	select($get_query, $con);
} else if ($type == 'insert') {
	insert($get_query, $con);
} else if ($type == 'update') {
	update($get_query, $con);
} else if ($type == 'delete') {
	delete($get_query, $con);
} else if($type == 'login'); {

}


function select($query, $con) {

	$status = array();

	$status['status'] = 0;
	$status['response'] = "Unsuccessful";

	if($result = $con->query($query)) {
		if($result->num_rows > 0) {

			$status['status'] = 1;
			$status['response'] = "Successful";
			$status['record'] = array();
			while($row = $result->fetch_object()) {
				array_push($status['record'] , $row);
			}
		
		} else {
			$status['status'] = 0;
			$status['response'] = "no";
		}
	}

	echo json_encode($status);
}

function insert($query, $con) {
	if($result = $con->query($query)) {
		$status = array();
		$status['status'] = 1;
		$status['response'] = "Succesful";
		echo json_encode($status);
	}
}

function update($query, $con){
	if($result = $con->query($query)) {
		$status = array();
		$status['status'] = 1;
		$status['response'] = "Succesful";
		echo json_encode($status);
	}
}

function delete($query, $con) {
	if($result = $con->query($query)) {
		$status = array();
		$status['status'] = 1;
		$status['response'] = "Succesful";
		echo json_encode($status);
	}
}	


function login_user($query, $con) {

}

function generateRandomKey($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}