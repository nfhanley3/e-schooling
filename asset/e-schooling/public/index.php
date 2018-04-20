<?php require_once '../core/Init.php';
    $db = Database::getInstance();
    $mysqli = $db->getConnection(); 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <title>Home Page::Log In</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Main CSS -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
  
  </head>
  <body>

    <center><img src="../image/eschooling_logo1.png" alt="e-schooling logo" style="width: 550px;height: 130px" align="center"></img></center>

    <!-- LOGIN FORM STARTS HERE -->
    <div class="form-container">

      <!-- Login Error Messages Will be Displayed here!!{Incorrect username && Password}-->
      <div id="login-error disable" style="display: none;">
        <p>rrrrrrrrrrrrrrr</p>
      </div>
      
      <form class="logIn" id="logIn-Form" action="" id="form" method="post"> 
        
        <div class="form-input">
            <input type="text" name="username"  autocomplete="off" id="username" placeholder="Email or User Name" class="form-control" value="">
        </div>
        <div class="form-input">
            <input type="password" id="pass" name="password" placeholder="Password" class="form-control">
        </div>
        
        <!-- Remember Me Cookies -->
        <div class="form-input checkbox">
          <label>
            <input  title="checkbox" type="checkbox" name="rememberMe" id="rememberMe"> Remember Me
          </label>
        </div>

        <input type="submit" value="Log In" name="login" id="login">

        <!-- Generate Token to Validate Users Login && Logout  -->
        <input type="hidden" name="token" value="<?php echo  Token::generate();?>">

      </form>  

      <!-- A LINK TO LOST PASSWORD -->
      <p id="nav">
          <a href="#link for users to change password">Lost your password?</a>
      </p>
      <!-- A LINK TO LOST PASSWORD END -->

      <a href="https://www.google.com/"><input type="submit" value="Register Now" name="register" id="register"></a>

    </div>
  </body>
</html>