<?php 
include '../function/LoginFunction.php';

if (isset($_GET['logout'])) {
  session_destroy();
  unset($_SESSION['uid']);
  header("Location: ../public/login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <title>Log-In Page</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Main CSS -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/main.css">
  <style type="text/css">
  .form_container p a:hover {
    text-decoration: none;
    color: red;
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
  .site-logo {
    margin-right: 15px;
    margin-left: 15px;
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
    top: 0;
    position: fixed;
    background-color: #f2f2f2;
    border-bottom: 1px solid #ccc;
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
      <?php  if (isset($_SESSION['uid'])) : ?>
        <div class="left-nav">
          <img src="../image/download.jpg" alt="user profile image" class="circular-img">
          <i class="dropbtn">
            <?php echo "Welcome ". " " .ucfirst($_SESSION['fname']); ?>
          </i>
          <div class="menu">
            <!-- <a href="successlogin.php?logout='1'">Log Out</a> -->
          </div>
        </div>
      <?php endif ?>
    </div>   
  </div>
  <br><br><br><br>
  <br><br><br><br>
  <br><br><br><br>
  <br><br><br><br>


  <div class="container">
    <center>
      <h1>
        <strong>
          You've successfully created your profile <?php echo ucfirst($_SESSION['fname']);?>. <br>Click here to <a href="../public/login.php">Login</a>
        </strong>
      </h1>
    </center>
  </div>
</body>
</html>
