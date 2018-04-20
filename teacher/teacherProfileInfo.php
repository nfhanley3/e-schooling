<?php 
include '../function/LoginFunction.php';
if (!isset($_SESSION['teach'])) {
  array_push($errors, "You must log in first");
  header("Location: ../public/login.php");
}

if (isset($_GET['logout'])) {
  session_destroy();
  unset($_SESSION['teach']);
  header("Location: ../public/login.php");
}

if (isset($_SESSION['teachID'])) {
  # code...
  $id = $_SESSION['teachID'];
  global $mysqli;

  $result = $mysqli->query("SELECT * FROM teachertable WHERE teachID = '$id'") or die("failedto fetch results: " . mysqli_connect_error());

  if (mysqli_num_rows($result) > 0) {
    # code...
    list($prefix, $teachID, $firstName, $lastName, $middleName, $phone, $dateOfBirth, $streetName, $apart_no, $city, $states, $zipCode) = mysqli_fetch_array($result);

    $_SESSION['prefix'] = $prefix;
    $_SESSION['id'] = $teachID;
    $_SESSION['fname'] = $firstName;
    $_SESSION['lname'] = $lastName;
    $_SESSION['mname'] = $middleName;
    $_SESSION['phone'] = $phone;
    $_SESSION['dob']   = $dateOfBirth;
    $_SESSION['street'] = $streetName;
    $_SESSION['apart'] = $apart_no;
    $_SESSION['city']  = $city;
    $_SESSION['state'] = $states;
    $_SESSION['z_code'] = $zipCode;
  }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <title>Student Profile Information</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Main CSS -->
  <link rel="stylesheet" type="text/css" href="../public/css/main.css">
  <link rel="stylesheet" type="text/css" href="../public/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../public/css/table.css">
  <link rel="stylesheet" type="text/css" href="../public/css/portals.css">
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
  table, tr, td {
    border: 2px solid gray;
  }
  table tr td img {
    width: 289px;
    height: 220px;
  }
  th {
    background-color: #20A3D7;
    color: #fff;
    padding-left: 5px;
  }
</style>
</head>
<body>
  <div class="head-nav">
    <div class="site-logo">
      <a href="../index.html">
        <img src="../image/eschooling_logo1.png" width="195px" height="70px">
      </a>
      <?php  if (isset($_SESSION['teach'])) : ?>
        <div class="left-nav">
          <img src="../image/image.jpg" alt="user profile image" class="circular-img">
          <i class="dropbtn">
            <?php echo $_SESSION['teach']; ?>
          </i>
          <div class="menu">
            <a href="teacherportal.php">My Portal</a>
            <a href="#allregiteredstudent.php">Students</a>
            <a href="calendar.php">Calendar</a>
            <a href="teacherProfileInfo.php?logout='1'">Log Out</a>
          </div>
        </div>
      <?php endif ?>
    </div>   
  </div>
  <br><br><br><br><br><br>
  <!-- Table -->
  <div style="margin: 0 auto; width: 900px;">
    <table width="100%" border="1px" style="padding: 7px; height: 200px;">
      <thead style="font-weight: bold; font-size: 20px;">
        <tr>
          <th colspan="2">Profile Information</th>
        </tr>
      </thead>
      <tr>
        <td style="width: 289px;">
          <img src="../image/userProfile.png" alt="" width="289px">
        </td>
        <td>
          <table style="border: 1px; height: 170px; width: 95%;">

            <tr>
              <td style="width: 120px; padding-left: 5px;">
                <label for="">TeacherID</label>
              </td>
              <td style="padding-left: 5px;">
                <?php echo $_SESSION['prefix'].$_SESSION['id'];?>
              </td>
            </tr>
            <tr>
              <td style="width: 120px; padding-left: 5px;">
                <label for="">Full Name</label>
              </td>
              <td style="padding-left: 5px;">
                <?php echo ucfirst($_SESSION['fname'])." ". ucfirst($_SESSION['mname'])." ".ucfirst($_SESSION['lname']);?>
              </td>
            </tr>
            <tr>
              <td style="padding-left: 5px;">
                <label for="">Date of Birth</label>
              </td>
              <td style="padding-left: 5px">
                <?php echo $_SESSION['dob'];?>
              </td>
            </tr> 
          </table>
        </td>
      </tr>
    </table>
    <br><br>

    <table width="100%" border="1px" style="padding: 7px; height: 200px;">
      <thead style="font-weight: bold; font-size: 20px;">
        <tr>
          <th colspan="2">Contact Information</th>
        </tr>
      </thead>
      <tr>
        <td style="width: 289px;">
          <img src="../image/cell-phone-email-icons.png" alt="" width="289px">
        </td>
        <td>
          <table style="border: 1px; height: 170px; width: 95%;">
            <tr>
              <td style="width: 120px; padding-left: 5px;" rowspan="2">
                <label for="">Address</label>
              </td>
              <td rowspan="2" style="padding-left: 5px;">
                <?php echo $_SESSION['street']
                ." ".
                $_SESSION['apart']
                ." ".
                $_SESSION['city']
                ." ".
                $_SESSION['state']
                ." ".
                $_SESSION['z_code'];
                ?>
              </td>
            </tr>
            <tr>
            </tr>
            <tr>
              <td style="padding-left: 5px;">
                <label for="">Phone Number</label>
              </td>
              <td style="padding-left: 5px;"><?php echo $_SESSION['phone'];?></td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </div>
  <div class="footer">
    <p>  © e-Schooling Management Systems <br>
      12345 Post Oak Road, Houston, TX 77054 (832)555-5522
      <br>
    </p>
  </div>
  <script src="../public/js/jquery.js"></script>
</body>
</html>
