<?php
 // connect to the database
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

// get teachers id and delete account
$courseID = $_GET['courseID'];
deleteCourse($courseID);
?>
