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
  <title>Create An Account</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Main CSS -->
  <link rel="stylesheet" type="text/css" href="../public/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../public/css/main.css">
  <link rel="stylesheet" type="text/css" href="../public/css/style.css">
  <link rel="stylesheet" type="text/css" href="../public/css/dropdown-menu.css">
  <link rel="stylesheet" type="text/css" href="../public/css/table.css">
<link rel="shortcut icon" type="image/png" href="../image/favicon_image.png">
<style type="text/css">
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
      background-color: #f2f2f2;
      box-shadow: 0px 1px 1px #666;
      height: 70px;
      margin-bottom: 25px; 
  }
    .site-logo a img {
      float: left;
    }
    .site-logo .left-nav{
      float: right;
    }
    .left-nav img {
      margin: 15px;
      margin-right: 15px;
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
    }
    .menu a:hover {
      background-color: #f1f1f1
    }
    .left-nav:hover .menu {
      display: block;
    }
    h1 strong {
      margin: 0 auto;
      margin-right: -250px;
    }
  </style>
</head>
<body>
<div class="head-nav">
    <div class="site-logo">
      <a href="../index.html">
        <img src="../image/eschooling_logo1.png" width="195px" height="70px">
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
            <a href="createteacherpass.php?logout='1'">Log Out</a>
          </div>
        </div>
      <?php endif ?>
    </div>   
  </div>

  <br><br><br><br>
  <div class="container">
    <h1><strong>Create An Account</strong></h1>
  </div>
<br><br><br>
  <!-- LOGIN FORM STARTS HERE -->
  <div class="add-container">
    <form class="logIn" action="createteacherpass.php" id="createpass_form" method="post">

      <?php echo display_error();?>

      <input type="hidden" name="uid" value="<?php echo $_SESSION['techid'];?>">      

      <div class="form-input">
        <input type="text" name="username"  autocomplete="off" id="username" placeholder="User Name" class="form-control" value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>">
      </div>        
      <div class="form-input">
        <input type="email" name="email"  autocomplete="off" id="email" placeholder="E-mail" class="form-control" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
      </div>      
      <div class="form-input">
        <input type="password" name="pass1"  autocomplete="off" id="pass" placeholder="Password" class="form-control" value="<?= isset($_POST['pass1']) ? htmlspecialchars($_POST['pass1']) : '' ?>">
      </div>
      <div class="form-input">
        <input type="password" id="pass2" name="pass2" placeholder="Confirm Password" class="form-control" value="<?= isset($_POST['pass2']) ? htmlspecialchars($_POST['pass2']) : '' ?>">
      </div>
      <input aria-disabled="false" type="submit" value="Create" name="TeachPass_btn" id="addcourse">
    </form>
  </div>

  <div class="footer">
    <p>  © e-Schooling Management Systems <br>
      12345 Post Oak Road Houston, TX 77054 (832)555-5522
      <br>
    </p>
  </div>
</body>
</html>