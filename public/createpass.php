<?php
include '../public/createaccount.php';
    if (!isset($_SESSION['lastID'])) {
        array_push($errors, "You must register first");
        header('Location: registration.php');
    }
    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['lastID']);
        header("Location: login.php");
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
  .site-logo {
    width: 90%;
    margin: 0 auto;
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
    margin-bottom: 35px;
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
      <?php  if (isset($_SESSION['lastID'])) : ?>
        <div class="left-nav">
          <img src="../image/download.jpg" alt="user profile image" class="circular-img">
          <i class="dropbtn">
            <?php echo ucfirst($_SESSION['fname']); ?>
          </i>
          <div class="menu">
            <a href="createpass.php?logout='1'">Log Out</a>
          </div>
        </div>
      <?php endif ?>
    </div>   
  </div>

  <br><br>
  <div class="a-header container">
    <h1><strong>Create An Account</strong></h1>
  </div>

  <!-- LOGIN FORM STARTS HERE -->
  <div class="add-container">
    <form class="logIn" action="createpass.php" id="createpass_form" method="post">

      <?php echo display_error();?>

      <input type="hidden" name="uid" value="<?php echo $_SESSION['lastID'];?>">      

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
      <input aria-disabled="false" type="submit" value="Create" name="createPass_btn" id="addcourse">
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