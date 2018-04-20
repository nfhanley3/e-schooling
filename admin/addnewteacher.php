<?php
include 'createnewteacher.php';
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
  <meta charset="utf-8">
  <title>Create A New Teachers Account Page</title>
  <link rel="stylesheet" type="text/css" href="../public/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../public/css/reg.css">
  <link rel="stylesheet" type="text/css" href="../public/css/jquery-ui.css">
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
      <a href="../index.html"
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
          <a href="addnewteacher.php?logout='1'">Log Out</a>
        </div>
      </div>
      <?php endif ?>
    </div>   
  </div>
  <br>
  <div class="wrapper">

    <form action="addnewteacher.php" method="POST" class="form_container">
      <fieldset>
        <legend>Create A Teacher Account</legend>
        <div id="con-error">
          <?php echo display_error(); ?>
        </div>
        <table>
          <tbody>
            <tr>
              <td>
                <label for="fname">First Name</label>
              </td>
              <td>
                <label for="mname">Middle Name</label>
              </td>
              <td>
                <label for="lname">Last Name</label>
              </td>
            </tr>
            <tr>
              <td>
                <input type="text" name="fname" id="fname" placeholder="First Name" autocomplete="off" value="<?= isset($_POST['fname']) ? htmlspecialchars($_POST['fname']) : '' ?>">
              </td>
              <td>
                <input type="text" name="mname" id="mname" placeholder="Initial" autocomplete="off" maxlength="1" value="<?= isset($_POST['mname']) ? htmlspecialchars($_POST['mname']) : '' ?>">
              </td>
              <td>
                <input type="text" name="lname" id="lname" placeholder="Last Name" autocomplete="off" value="<?= isset($_POST['lname']) ? htmlspecialchars($_POST['lname']) : '' ?>">
              </td>
            </tr>
            <tr>
              <td>
                <label for="dob">Date of Birth</label>
              </td>
              <td>
              </td>
              <td>
                <label for="phone">Phone Number</label>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <input type="text" id="datepicker" placeholder="mm/dd/yyyy" autocomplete="off" name="dateOfBirth" value="<?= isset($_POST['dateOfBirth']) ? htmlspecialchars($_POST['dateOfBirth']) : '' ?>">
              </td>
              <td>
                <input type="text" maxlength="10" name="phone" placeholder="(123)-456-7890" id="phone" autocomplete="off" value="<?= isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '' ?>">
              </td>
            </tr>
            <tr>
              <td>
                <label for="Address1">Address</label>
              </td>
              <td>
                <label for="Address2">Apt.</label>
              </td>
              <td></td>
            </tr>
            <tr>
              <td>
                <input type="text" name="address" placeholder="1234 Main St" id="addcols" autocomplete="off" value="<?= isset($_POST['address']) ? htmlspecialchars($_POST['address']) : '' ?>">
              </td>
              <td>
                <input type="text" name="address2" placeholder="Apartment, studio, or floor" id="address2" autocomplete="off" value="<?= isset($_POST['address2']) ? htmlspecialchars($_POST['address2']) : '' ?>">
              </td>
              <td></td>
            </tr>
            <tr>
              <td>
                <label for="city">City</label>
              </td>
              <td>
                <label for="state">State</label>
              </td>
              <td>
                <label for="zipcode">Zip Code</label>
              </td>
            </tr>
            <tr>
              <td>
                <input type="text" id="city" name="city" placeholder="City" autocomplete="off" value="<?= isset($_POST['city']) ? htmlspecialchars($_POST['city']) : '' ?>">
              </td>
              <td>
                <select id="state" name="state">
                  <option value=""=" "> Select </option>
                  <option value=""="AL">Alabama</option>
                  <option value=""="AK">Alaska</option>
                  <option value=""="AZ">Arizona</option>
                  <option value=""="AR">Arkansas</option>
                  <option value=""="CA">California</option>
                  <option value=""="CO">Colorado</option>
                  <option value=""="CT">Connecticut</option>
                  <option value=""="DE">Delaware</option>
                  <option value=""="DC">District of Columbia</option>
                  <option value=""="FL">Florida</option>
                  <option value=""="GA">Georgia</option>
                  <option value=""="GU">Guam</option>
                  <option value=""="HI">Hawaii</option>
                  <option value=""="ID">Idaho</option>
                  <option value=""="IL">Illinois</option>
                  <option value=""="IN">Indiana</option>
                  <option value=""="IA">Iowa</option>
                  <option value=""="KS">Kansas</option>
                  <option value=""="KY">Kentucky</option>
                  <option value=""="LA">Louisiana</option>
                  <option value=""="ME">Maine</option>
                  <option value=""="MD">Maryland</option>
                  <option value=""="MA">Massachusetts</option>
                  <option value=""="MI">Michigan</option>
                  <option value=""="MN">Minnesota</option>
                  <option value=""="MS">Mississippi</option>
                  <option value=""="MO">Missouri</option>
                  <option value=""="MT">Montana</option>
                  <option value=""="NE">Nebraska</option>
                  <option value=""="NV">Nevada</option>
                  <option value=""="NH">New Hampshire</option>
                  <option value=""="NJ">New Jersey</option>
                  <option value=""="NM">New Mexico</option>
                  <option value=""="NY">New York</option>
                  <option value=""="NC">North Carolina</option>
                  <option value=""="ND">North Dakota</option>
                  <option value=""="MP">Northern Marianas Islands</option>
                  <option value=""="OH">Ohio</option>
                  <option value=""="OK">Oklahoma</option>
                  <option value=""="OR">Oregon</option>
                  <option value=""="PA">Pennsylvania</option>
                  <option value=""="PR">Puerto Rico</option>
                  <option value=""="RI">Rhode Island</option>
                  <option value=""="SC">South Carolina</option>
                  <option value=""="SD">South Dakota</option>
                  <option value=""="TN">Tennessee</option>
                  <option value=""="TX">Texas</option>
                  <option value=""="UT">Utah</option>
                  <option value=""="VT">Vermont</option>
                  <option value=""="VA">Virginia</option>
                  <option value=""="VI">Virgin Islands</option>
                  <option value=""="WA">Washington</option>
                  <option value=""="WV">West Virginia</option>
                  <option value=""="WI">Wisconsin</option>
                  <option value=""="WY">Wyoming</option>
                </select>
              </td>
              <td>
                <input placeholder="Zip Code" type="text" id="zipcode" name="zipcode"  maxlength="10" autocomplete="off" <?= isset($_POST['zipcode']) ? htmlspecialchars($_POST['zipcode']) : '' ?>>
              </td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td>

              </td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td>
                <input type="submit" name="create_btn" value="Create" id="sub_btn">
              </td>
              <td></td>
              <td>
                <input type="reset" name="rest_btn" value="Cancel" id="rest_btn">
              </td>
            </tr>
          </tbody>
        </table>
      </fieldset>

    </form>
    <p id="backtoblog" style="margin-top: 10px;">
      <a href="viewallteachers.php">&leftarrow; Back to teachers page</a>
    </p>
  </div>

  <div class="fixed-footer">
    <div class="container">
      &#169; e-Schooling Management Systems <br>
      12345 Poast Oak Road, Houston, TX 77054 (832)555-5521 
    </div>
  </div>
  <script src="../public/js/jquery.js"></script>
  <script src="../public/js/bootstrap.min.js"></script>
  <script src="../public/js/jquery-ui.js"></script>
  <script>
    $( function() {
      $("#datepicker").datepicker({
        showOn: "button",
        buttonImage: "../image/calendar.png",
        buttonImageOnly: true,
        buttonText: "Select date",
        changeMonth: true,
        changeYear: true
      });
    });
    $("submit").on("click",function(){
      var input = $("input[type='text']");
      if(!input.val()){
        input.css("border","1px solid red");
      }
    });
  </script>
</body>
</html
