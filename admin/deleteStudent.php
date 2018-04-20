<?php
 // connect to the database
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

// get the studentID from url
$studentID = $_GET['id'];
deleteStudent($studentID);
?>
