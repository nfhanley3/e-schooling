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
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <title>View all students gradebook page</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Style CSS -->
    <link rel="stylesheet" type="text/css" href="../public/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../public/css/style.css">
    <link rel="stylesheet" type="text/css" href="../public/css/dropdown-menu.css">
    <link rel="stylesheet" type="text/css" href="../public/css/table.css">
      <link rel="shortcut icon" type="image/png" href="../image/favicon_image.png">
   <style type="text/css">
    .table p {
        width: 16%;
        margin: 23px;
        float: right;
    }
    .table p button {
        width: 110px;
        height: 30px;
        font-size: 15px;
    }
    .header-cont {
      width:100%;
      position:fixed;
      top:0px;
      background: #F9F7FD;
      box-shadow: 0px 4px 0px #E0E0E0;
      height: 75px;
      padding-bottom: 15px;
    }
    .site-logo{
        margin-left: 15px;
        margin-right: 15px;
    }
    img.circular-img {
      border-radius: 50%;
      height: 37px;
      width: 37px;
      margin-right: 7px;
      border: 1px solid #20A3D7;
    }
  .head-nav {
      width: 100%;
      float: left;
      margin: 0 0 1em 0;
      padding: 0;
      position: fixed;
      top: 0;
      background-color: #f2f2f2;
      box-shadow: 0px 1px 1px #666;
      height: 70px;
      margin-bottom: 25px; 
  }
    .site-logo a img {
      float: left;
      margin-left: 0;
    }
    .site-logo .left-nav{
      float: right;
      margin-right: 0;
    }
    .left-nav img {
      margin: 15px;
      margin-right: 8px;
    }
    .dropbtn {
      color: black;
      font-size: 14px;
      border: none;
      cursor: pointer;
    }
    .left-nav {
      position: relative;
      display: inline-block;
    }
    .menu {
      display: none;
      position: absolute;
      right: 0;
      background-color: #f9f9f9;
      min-width: 160px;
      box-shadow: 0px 6px 14px 0px rgba(0,0,0,0.2);
      z-index: 1;
    }
    .menu a {
      color: black;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
      text-align: left;
    }
    .menu a:hover {
      background-color: #f1f1f1
    }
    .left-nav:hover .menu {
      display: block;
    }
    .a-header {
        margin-bottom: 40px;
        margin-top: 90px;
    }
</style>
</head>
<body>
<div class="head-nav">
  <div class="site-logo">
    <a href="../index.html">
      <img src="../image/eschooling_logo1.png" width="195px" height="70px" hspace="20">
    </a>
    <?php  if (isset($_SESSION['admin'])) : ?>
    <div class="left-nav">
      <img src="../image/image.jpg" alt="user profile image" class="circular-img">
      <i class="dropbtn">
        <?php echo ucfirst($_SESSION['admin']); ?>
      </i>
      <div class="menu">
        <a href="adminportal.php">Admin Portal</a>
        <a href="viewallstudents.php">Students</a>
        <a href="viewallcourses.php">Courses</a>
        <a href="courselist.php">Registered Students</a>
        <a href="viewallteachers.php">Teachers</a>
        <a href="admincalendar.php">Calendar</a>
        <a href="courselist.php?logout='1'">Log Out</a>
      </div>
    </div>
    <?php endif ?>
  </div>   
</div>
<br><br><br>
<!-- Search Box Original-->
<form method="post" action="#" style="float:right; padding-right:28px; padding-bottom: 12px;" ><br><br>
    <label for="lastName"> </label>
    <input type="text" id="lastName" name="lastName">
    <input type="submit" name="submit" value="Search"><br>
    <input type="radio" name="search_type" value="lastName" checked="checked"> Last Name &nbsp;
    <input type="radio" name="search_type" value="ID"> ID<br>
</form>

<br><br>
<div class="a-header container">
<h1><strong>Registered Students</strong></h1>
</div>

<!-- Table -->
<div class="table">
    <!-- Error Messages -->
    <?php echo display_error(); ?>

    <table id="table" style="text-align: center; width: 90%; margin: auto;" cellspacing="3" cellpadding="10" id="table">
        <thead>
            <tr>
                <th>Student ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Course Code</th>
                <th>Course Name</th>
                <th>Date/Time</th>
                <th>Instructor</th>
            </tr>
        </thead>
        <tbody>
            <?php echo courselistadmin();?>
        </tbody>
        <tfoot></tfoot>
    </table>
    <p>
        <a href="#addnewstudent.php"><button name="addcourse_btn">Add</button></a>
    </p>
</div>
<div class="footer" style="text-align: center; vertical-align: middle;">
    <p>  © e-Schooling Management Systems <br>
        12345 Post Oak Road Houston, TX 77054 (832)555-5522
        <br>
    </p>
</div>
</body>
</html>
