<?php include '../function/LoginFunction.php';?>
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
      <div class="left-nav">
          <div class="menu">
          </div>
      </div>
    </div>   
  </div>

<br><br>
<div class="a-header container">
  <h1><strong>Password Reset</strong></h1>
</div>

<!-- LOGIN FORM STARTS HERE -->
<div class="add-container">
  <form class="logIn" action="lostpass.php" id="lostpass_form" method="post">

    <?php echo display_error();?>

    <input type="hidden">                
    <div class="form-input">
      <input type="text" name="username"  autocomplete="off" id="pass" placeholder="Email or User Name" class="form-control" value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>">
    </div>
    <div class="form-input">
      <input type="password" id="pass1" name="pass1" placeholder="New Password" class="form-control" value="<?= isset($_POST['pass1']) ? htmlspecialchars($_POST['pass1']) : '' ?>">
    </div>
    <div class="form-input">
      <input type="password" id="pass2" name="pass2" placeholder="Confirm Password" class="form-control" value="<?= isset($_POST['pass2']) ? htmlspecialchars($_POST['pass2']) : '' ?>">
    </div>
    <input aria-disabled="false" type="submit" value="Submit" name="lostpass_btn" id="lostpass">
  </form>

  <p id="backtoblog"><a href="login.php">&leftarrow; Back to all Login Screen</a></p>
</div>

<div class="footer">
  <p>  © e-Schooling Management Systems <br>
    12345 Post Oak Road Houston, TX 77054 (832)555-5522
    <br>
  </p>
</div>
</body>
</html>