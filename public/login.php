<?php include '../function/LoginFunction.php';?>
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
     <link rel="shortcut icon" type="image/png" href="../image/favicon_image.png">
    <style type="text/css">
      div.centerImg{
        width: 500px;
        margin: 0 auto;
      }
      div.centerImg a img {
        margin-top: 30px;
        margin-left: -30px;
        margin-bottom: 0px; 
      }
    </style>
  </head>
  <body>

<div class="centerImg">
  <a href="../index.html">
  <img src="../image/eschooling_logo1.png" alt="e-schooling logo" style="width: 550px;height: 130px" align="center">
  </img>  
</a>
</div>

    <!-- LOGIN FORM STARTS HERE -->
    <div class="form-container">
      <?php echo display_error(); ?>

      <form class="logIn" action="login.php" id="form" method="post">

        <input type="hidden" name="is_login" value="1">
        <div class="form-input">
            <input type="text" name="username"  autocomplete="off" id="username" placeholder="Email or User Name" class="form-control" value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>">
        </div>
        <div class="form-input">
            <input type="password" id="password" name="password" placeholder="Password" class="form-control" value="<?= isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '' ?>">
        </div>

        <!-- Remember Me Cookies -->
        <div class="form-input checkbox">
          <label>
            <input  title="checkbox" type="checkbox" name="rememberMe" id="rememberMe"> Remember Me
          </label>
        </div>

        <input aria-disabled="false" type="submit" value="Log In" name="login_btn" id="login">

        <!-- Generate Token to Validate Users Login && Logout  -->

      </form>

      <!-- A LINK TO LOST PASSWORD -->
      <p id="nav">
          <a href="lostpass.php">Lost your password?</a>
      </p>
      <!-- A LINK TO LOST PASSWORD END -->
      <a href="registration.php">
      <input type="submit" value="Register Now" name="register" id="register"></a>
    </div>
    <script src="js/jquery-3.2.1.js"></script>
  </body>
</html>
