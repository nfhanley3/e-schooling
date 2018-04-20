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
    $dob = "";
    $city = "";
    $z_code = "";
    $apart_no = "";
    $state = "";
    $teach_id = "";
    $errors = array();

if (isset($_POST['update'])) {
    updateTeachers();
}

function updateTeachers() {

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
    $teach_id = $_POST['teach_id'];


    if (empty($fname)) {
        array_push($errors, "First name is required");
    } else{
        $fname = ucfirst($fname);
    }
    if (empty($lname)) {
        array_push($errors, "Last Name is required");
    }else{
        $lname = ucfirst($lname);
    }
    if (empty($add)) {
        array_push($errors, "Address is required");
    }else{
        $add = ucfirst($add);
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
        $mname  =  ucfirst($mname);
        $apart_no = ucfirst($apart_no);

        $result = $mysqli->query("UPDATE teachertable
            SET t_fname = '$fname', t_lname = '$lname',
                t_middlename = '$mname', t_phone = '$phone',
                t_dateOfBirth = '$dob', t_streetName = '$add',
                t_apart_no = '$apart_no', t_city = '$city', 
                t_states = '$state', t_zipCode = '$z_code'
            WHERE teachID = '$teach_id'");

        if (!$result) {
            array_push($errors, "Unable to update");
            header("Location: editteacher.php");
        }
        array_push($errors, "Updated successfully");
        header("Location: viewallteachers.php");
    }

}

?>
