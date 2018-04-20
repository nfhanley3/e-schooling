<?php
    require '../function/LoginFunction.php';
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
    $z_code = "";
    $state = "";
    $apart_no = "";
    $stud_id = "";
    $race =  "";
    $errors = array();

if (isset($_POST['s_update'])) {
    studentUpdate();
}

function studentUpdate() {

    global $mysqli, $errors;

    $fname = escape($_POST['fname']);
    $mname = escape($_POST['mname']);
    $lname = escape($_POST['lname']);
    $phone = escape($_POST['phone']);
    $add = escape($_POST['address']);
    $apart_no = escape($_POST['address2']);
    $dob = $_POST['dateOfBirth'];
    $city = escape($_POST['city']);
    $z_code = $_POST['zipcode'];
    $state = $_POST['state'];
    $race = $_POST['race'];
    $stud_id = $_POST['stud_id'];
    $gender  = $_POST['gender'];


    if (empty($fname)) {
        array_push($errors, "First Name is required");
    }else{
        $fname = ucfirst($fname);
    }
    if (empty($lname)) {
        array_push($errors, "Last Name is required");
    }else{
        $lname = ucfirst($lname);
    }
    if (empty($add)) {
        array_push($errors, "Address is required");
    }
    if (empty($phone)) {
        array_push($errors, "Phone is required");
    }
    if (empty($city)) {
        array_push($errors, "City is required");
    }else{
        $city = ucfirst($city);
    }
    if (empty($z_code)) {
        array_push($errors, "Zipcode is required");
    }
    if ($state == " ") {
        array_push($errors, "Please select a state");
    }
    if ($gender == " ") {
        array_push($errors, "Please select a gender");
    }
    if ($race == " ") {
        array_push($errors, "Please select a race");
    }
    if (empty($dob)) {
        array_push($errors, "Date of Birth is required");
    } else {
        $dob = date('Y-m-d',strtotime($dob));
    }
    if (!valid_zipcode($z_code)) {
        array_push($errors, "Your ZIP Code is should be 5 digits (or 9 digits, if you're using ZIP+4)");
    }

    if (count($errors) == 0) {

        $phone = formatPhone($phone);
        $add = ucfirst($add);
        $mname = ucfirst($mname);
        $apart_no = ucfirst($apart_no);


        $result = $mysqli->query("UPDATE studenttable
            SET firstName = '$fname', lastName = '$lname',
                middleName = '$mname', phone = '$phone',
                gender = '$gender', race = '$race', 
                dateOfBirth = '$dob', streetName = '$add', 
                apart_no = '$apart_no', city = '$city', 
                states = '$state', zipCode = '$z_code'
            WHERE studentID = '$stud_id'");

        if (!$result) {
            array_push($errors, "Unable to update");
            header("Location: editstudent.php");
        }
        array_push($errors, "Updated successfully");
        header("Location: viewallstudents.php");
    }

}

?>
