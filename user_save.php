<?php

include "class/database.php";

$status = array();

/* 
	Mark D. Sibi
*/

$status['status'] = "0";
$status['response'] = "Unsuccessful";


if (isset($_POST)) {
	$db = new Database();
	$con = $db->connect();

	//$username = $_POST['username'];
	//$password = $_POST['password'];

	$str_query = "SELECT * FROM meetmeup.users WHERE username = 'mark'";

	if ($result = $con->query($str_query)) {
		if ($result->num_rows == 0) {

			$str_query = 	"INSERT INTO meetmeup.users
						(username, password, first_name, last_name, bdate, 
						natio_id, gender, current_location, email_address,
						contact_number, active_flag, user_image) 
					VALUES
						('naidy', 'naidy', 'Naidy', 'Versoza', '1991-01-24',21, 'M',
			 			'Punta Engano', 'bitukon_seasonal@gmail.com', 093290,
			 			'A', 'naidy.jpg')";

			if ($con->query($str_query)) {
				$status['status'] = "1";
				$status['response'] = "Successful";
			}

		}
	}


	

}


echo json_encode($status);