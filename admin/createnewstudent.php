<?php
include '../function/LoginFunction.php';
if (!isset($_SESSION['admin'])) {
   array_push($errors, "You must log in first");
    header("Location: ../public/HTTP400.html");
}
if (isset($_GET['logout'])) {
   session_destroy();
   unset($_SESSION['admin']);
   header("Location: ../public/login.php");
}

$fname = "";
$mname = "";
$lname = "";
$phone = "";
$address = "";
$address2 = "";
$gender = "";
$dob = "";
$city = "";
$zipcode = "";
$state = "";
$apart_no = "";
$race =  "";
$errors = array();
// 
if (isset($_POST['createStud'])) {
	createStudent();
}


function createStudent() {
    global $mysqli, $errors;

    $fname = escape(ucfirst($_POST['fname']));
    $lname = escape(ucfirst($_POST['lname']));
    $mname = escape(ucfirst($_POST['mname']));
    $dob = date('Y-m-d',strtotime($_POST['dateOfBirth']));
    $gender = $_POST['gender'];
    $add = escape(ucwords($_POST['address']));
    $apart_no = escape(ucfirst($_POST['address2']));
    $race = $_POST['race'];
    $city = escape(ucfirst($_POST['city']));
    $state = $_POST['state'];
    $zipcode = escape($_POST['zipcode']);
    $phone = escape($_POST['phone']);

    if (empty($fname)) {
        array_push($errors, "First name is required");
    }
    if (empty($lname)) {
        array_push($errors, "Last Name is required");
    }
    if (empty($dob)) {
        array_push($errors, "Date of birth is required");
    }
    if ($gender == " ") {
        array_push($errors, "Please select your gender");
    }
    if (empty($add)) {
        array_push($errors, "Address is required");
    }
    if ($race == " ") {
        array_push($errors, "Please select your race");
    }
    if (empty($city)) {
        array_push($errors, "City is required");
    }
    if ($state == " ") {
        array_push($errors, "Please select a state");
    }
    if (empty($zipcode)) {
        array_push($errors, "Zipcode is required");
    }
    if (empty($phone)) {
        array_push($errors, "Phone is required");
    }
    if (!valid_zipcode($zipcode)) {
        array_push($errors, "Your ZIP Code is should be 5 digits (or 9 digits, if you're using ZIP+4)");
    }


    if (count($errors) == 0) {
        $phone = formatPhone($phone);

        $result = 
        $mysqli->query("INSERT INTO studenttable (firstName, lastName, middleName, phone, gender, race, dateOfBirth, streetName, apart_no, city, states, zipCode) 
            VALUES ('$fname', '$lname', '$mname', '$phone', '$gender', '$race', '$dob', '$add', '$apart_no', '$city', '$state', '$zipcode')");

        if (!$result) {
            array_push($errors, "Unable to create account...please try again later!");
            header("Location: addnewstudent.php");
        }else{
            $id = $mysqli->insert_id;
            $_SESSION['studid'] = $id;
            header("Location: createstudentpass.php");
        }
    }
}