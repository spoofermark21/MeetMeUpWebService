<?php

include "class/database.php";
include "class/user.php";

$status = array();


$status['status'] = "0";
$status['response'] = "Unsuccessful";


if (isset($_POST)) {
	
	$db = new Database();
	$con = $db->connect();


	$update_type = $_POST['update_type'];
	$str_query = '';

	if($update_type == 'profile') {
		$id = $_POST['id'];
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name']; 
		$birth_date = $_POST['birth_date'];
		$natio_id = $_POST['natio_id'];
		$gender = $_POST['gender'];
		$current_location = $_POST['current_location'];
		$email_address = $_POST['email_address']; 
		$contact_number = $_POST['contact_number'];

		if(isset($_POST['user_image'])) {
			$user_image = $_POST['user_image'];

			$str_query = 	"UPDATE users 
						SET last_name='$last_name',first_name='$first_name', bdate='$birth_date', natio_id=$natio_id, gender='$gender', current_location='$current_location',email_address='$email_address', contact_number='$contact_number', user_image = '$user_image'
						WHERE id = $id";
		} else {
			$str_query = 	"UPDATE users 
						SET last_name='$last_name',first_name='$first_name', bdate='$birth_date', natio_id=$natio_id, gender='$gender', current_location='$current_location',email_address='$email_address', contact_number='$contact_number'
						WHERE id = $id";
		}
		

		

	} else if($update_type == 'password') {
		$id = $_POST['id'];
		$password = $_POST['password'];
		$str_query = 	"UPDATE users 
						SET PASSWORD='$password'
						WHERE id = $id";
	}
	
	


	if ($result = $con->query($str_query)) {
		$status['status'] = "1";
		$status['response'] = "Successful";
	} 

}


echo json_encode($status);