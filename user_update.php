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
	$username = $_POST['username'];
	$password = $_POST['password'];
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name']; 
	$birth_date = $_POST['birth_date'];
	$natio_id = $_POST['natio_id'];
	$gender = $_POST['gender'];
	$current_location = $_POST['current_location'];
	$email_address = $_POST['email_address']; 
	$contact_number = $_POST['contact_number'];
	$file_name = $_POST['file_name'];

	
	$str_query = 	"UPDATE meetmeup.users 
						SET PASSWORD='$password', first_name='$first_name', last_name='$last_name', bdate='$birth_date', natio_id=$natio_id, gender='$gender', current_location='$current_location',email_address='$email_address', contact_number=$contact_number
					WHERE id = $id";


	if ($result = $con->query($str_query)) {
		$status['status'] = "1";
		$status['response'] = "Successful";
	} 

}


echo json_encode($status);