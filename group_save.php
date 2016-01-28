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

	$file_name = $_POST['file_name'];

	$str_query = 	"INSERT INTO groups 
						(group_name, details, created_by, created_date, avail_flag,active_flag, group_image)
					VALUES
						('$group_name','$details', $user_id , NOW(), 'A', 'Y', '$file_name')";


	if ($result = $con->query($str_query)) {
		$status['status'] = "1";
		$status['response'] = "Successful";
	} 

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


echo json_encode($status);