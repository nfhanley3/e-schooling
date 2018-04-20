<?php
include '../function/LoginFunction.php';
if (!isset($_SESSION['lastID'])) {
	array_push($errors, "Please create a username & password");
	header('Location: createpass.php');
}

// setting the time zone
date_default_timezone_set('America/Chicago');
$date = "";
$date = new DateTime('now');

// calling createAccount(); function
if (isset($_POST['createPass_btn'])) {
	createAccount();
}


function createAccount() {
	global $mysqli, $errors, $date;

	$email = escape($_POST['email']);
	$username = escape($_POST['username']);
	$pass1 = $_POST['pass1'];
	$pass2 = $_POST['pass2'];
	$uid = $_POST['uid'];
	$date = $date->format('Y-m-d h:i:s');

	if (empty($username)) {
		array_push($errors, "Username is required");
	}
	if (empty($email)) {
		array_push($errors, "E-mail is required");
	}
	if (empty($pass1) || empty($pass2)) {
		array_push($errors, "Password is required");
	}
	if (empty($pass2)) {
		array_push($errors, "Please confirm your password");
	}
	if ($pass1 != $pass2) {
		array_push($errors, "The two passwords do not match");
	}else{
		$hash = hashPass($pass1);
	}

	if (count($errors) == 0) {
		
		$result = 
			$mysqli->query("SELECT * 
			FROM userstable 
			WHERE userName = '$username'");
		if (mysqli_num_rows($result) == 1){
			array_push($errors, "Username/Email already exists");
		}else {
			if (isset($_POST['user_type'])) {

				$user_type = escape($_POST['user_type']);

				$result = $mysqli->query("INSERT INTO userstable (studentID, privilegeID, userName, password, email, createDate, privilegeName) 
					VALUES ('$uid', 3, '$username', '$hash', '$email', '$date', '$user_type')");

			}else{
				$result = $mysqli->query("INSERT INTO userstable (studentID, privilegeID, userName, password, email, createDate, privilegeName) 
					VALUES ('$uid', 3, '$username', '$hash', '$email', '$date', 'Student')");
				if (!$result) {
					array_push($errors, "Unable to create account...please try again later!");
				}else{
					$id = $mysqli->insert_id;
					$_SESSION['uid'] = $id;
					$_SESSION['user'] = $username;
					header("Location: successlogin.php");

				} // end of if (!$result)

			} // end of if (isset($_POST['user_type']))

		}//if (mysqli_num_rows($result) == 1)

	} // end of if (count($errors) == 0)

} // end of createAccount(); function