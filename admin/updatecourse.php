<?php
    include '../function/LoginFunction.php';
  if (!isset($_SESSION['admin'])) {
      array_push($errors, "You must log in first");
      header('Location: ../public/login.php');
  }
  if (isset($_GET['logout'])) {
      session_destroy();
      unset($_SESSION['admin']);
      header("Location: ../public/login.php");
  }


    $c_name = "";
    $c_code = "";
    $errors = array();


if (isset($_POST['update'])) {
    updateCourse();
}

function updateCourse() {

    global $mysqli, $c_name, $c_code, $errors;

    $c_code = escape($_POST['c_code']);
    $c_name = escape($_POST['c_name']);
    $c_id = $_POST['c_id'];

    // echo $c_id;
    // die();

    if (empty($c_code)) {
        array_push($errors, "Course code must not be empty");
    }else{
        $c_code =  strtoupper($c_code);
    }
    if (empty($c_name)) {
        array_push($errors, "Course name must not be empty");
    }else {
        $c_name =  strtoupper($c_name);
    }

    if (count($errors) == 0) {

        $result = $mysqli->query("UPDATE coursetable SET courseCode = '$c_code', courseName = '$c_name' 
            WHERE courseID = '$c_id'");

        if (!$result) {
            array_push($errors, "Unable to update");
            header("Location: editcourse.php");            
        }
        array_push($errors, "Updated successfully");
        header("Location: viewallcourses.php");            
    }

}

?>