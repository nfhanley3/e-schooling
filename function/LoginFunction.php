<?php
require_once ('../core/Init.ini');
$mysqli = $db->getConnection();

// setting the time zone
date_default_timezone_set('America/Chicago');
$date = "";
$date = new DateTime('now');

// escaping users input function
function escape($data) {
	global $mysqli;
	$data = htmlspecialchars(strip_tags(stripslashes($data)));
	return mysqli_real_escape_string($mysqli, trim($data));
}

// variable declaration
$coursecode = "";
$coursename = "";
$username = "";
$email    = "";
$token    = "";
$_SESSION['success'] = "";
$errors   = array();

// Declaring errors function
function display_error() {
	global $errors;
	if (count($errors) > 0){
		echo '<div class="error">';
		foreach ($errors as $error){
			echo $error .'<br>';
		}
		echo '</div>';
	}
}


// Calling Registration function
if (isset($_POST['sub_btn'])) {
	register();
}

// Declaring registration function
function register() {
	global $mysqli, $errors;

	$fname = escape(ucfirst($_POST['fname']));
	$lname = escape(ucfirst($_POST['lname']));
	$mname = escape(ucfirst($_POST['mname']));
	$dob = date('Y-m-d',strtotime($_POST['dateOfBirth']));
	$gender = $_POST['gender'];
	$address = escape(ucwords($_POST['address']));
	$apart_no = escape(strtoupper($_POST['address2']));
	$race = $_POST['race'];
	$city = escape(ucfirst($_POST['city']));
	$state = $_POST['state'];
	$zipcode = escape($_POST['zipcode']);
	$phone = escape($_POST['phone']);

	if (empty($fname)) {
		array_push($errors, "First name is required");
	}
	if (empty($lname)) {
		array_push($errors, "Last Name is required");
	}
	if (empty($dob)) {
		array_push($errors, "Date of birth is required");
	}
	if ($gender == " ") {
		array_push($errors, "Please select your gender");
	}
	if (empty($address)) {
		array_push($errors, "Address is required");
	}
	if ($race == " ") {
		array_push($errors, "Please select your race");
	}
	if (empty($city)) {
		array_push($errors, "City is required");
	}
	if ($state == " ") {
		array_push($errors, "Please select a state");
	}
	if (empty($zipcode)) {
		array_push($errors, "Zipcode is required");
	}
	if (empty($phone)) {
		array_push($errors, "Phone is required");
	}
	if (!valid_zipcode($zipcode)) {
		array_push($errors, "Your ZIP Code is should be 5 digits (or 9 digits, if you're using ZIP+4)");
	}

	if (count($errors) == 0) {
		$phone = formatPhone($phone);

		$result = 
		$mysqli->query("INSERT INTO studenttable (firstName, lastName, middleName, phone, gender, race, dateOfBirth, streetName, apart_no, city, states, zipCode) 
			VALUES ('$fname', '$lname', '$mname', '$phone', '$gender', '$race', '$dob', '$address', '$apart_no', '$city', '$state', '$zipcode')");

		if (!$result) {
			array_push($errors, "Unable to complete the registration process please try again later!");
			header("Location: registration.php");
		}else{
			$id = $mysqli->insert_id;
			$_SESSION['lastID'] = $id;
			$_SESSION['fname'] = $fname;
			header("Location: createpass.php");
		}
	}
}


// calling login function
if (isset($_POST['login_btn'])) {
	login();
}

// declaring login function
function login() {
	global $mysqli, $username, $errors;

// grap form values
	$user = escape($_POST['username']);
	$pass = $_POST['password'];

// make sure form is filled properly
	if (empty($user)) {
		array_push($errors, "Please enter your Username");
	}
	if (empty($pass)) {
		array_push($errors, "Please enter your Password");
	}

/***
Gives users the ability to login either with username or email address    
***/
if (strpos($user, '@') === false) {
	$user_cond = "userName='$user'";
} else {
	$user_cond = "email='$user'";
}

/* users completed form correctly */
if (count($errors) == 0) {

	$result = $mysqli->query("SELECT * FROM userstable 
		WHERE $user_cond");

	if (mysqli_num_rows($result) > 0) {

		list($userID, $studentID, 
			$teachID, $privilegeID, 
			$userName, $password, 
			$email, $createDate, 
			$privilegeName) = mysqli_fetch_array($result);

		/* verifing stored password (hashed) with users password */
		if (password_verify($pass, $password)) {

			if ($privilegeID === '1' && $privilegeName === 'Administrator') {
				
				$_SESSION['admin'] = $userName;
				$_SESSION['privilegeID'] = $privilegeID;
				$_SESSION['privilegeName'] = $privilegeName;
				$_SESSION['userID'] = $userID;
				adminPortal();

			}elseif($privilegeID === '2' && $privilegeName === 'Teacher'){
				$_SESSION['teach'] = $userName;
				$_SESSION['teachID'] = $teachID;
				teacherPortal();
			}else{
				$_SESSION['student'] = $userName;
				$_SESSION['userID'] = $userID;
				$_SESSION['studentID'] = $studentID;
				studentPortal();
			}

		}else{
			array_push($errors, "Invalid password...please try again");
        } //if (password_verify()) ends

    }else{
    	array_push($errors, "Wrong username/password combination");
    } //if (mysqli_num_rows($result) == 1)

}  //end of error check

} //end of function


// VIEWING ALL REGISTERED STUDENTS INFORMATION

function viewAllStudentInfo() {

	global $mysqli, $errors;
	$rec_limit = 10;
	$rec_count = "";
	$left_rec = "";

// counting the numbers of rows in the table for paging
	$result = $mysqli->query("SELECT COUNT(studentID) FROM studenttable");
	$row = mysqli_fetch_array($result);
	$rec_count = $row[0];

	if(isset($_GET['page'])) {
		$page = $_GET['page'] + 1;
		$offset = $rec_limit * $page ;
	}else {
		$page = 0;
		$offset = 0;
	}

	$left_rec = ceil($rec_count - ($page * $rec_limit));

// selecting all the rows in student table
	$result = $mysqli->query("SELECT * FROM studenttable LIMIT $offset, $rec_limit");
	$num = mysqli_num_rows($result);

// if no record -- display it the error messages
	if (!$result) {
		array_push($errors, "Could not get data");
		header("Location: viewallstudents.php");        
	}

// displaying all the selected record in a table
	while ($row = mysqli_fetch_array($result)) {
		$phone = formatPhone($row["phone"]);
		$id = $row['prefix']."".$row['studentID'];
		echo "<tr>";
		echo "<td><a href=\"editstudent.php?id=$row[studentID]\">Edit</a> | <a href=\"deletestudent.php?id=$row[studentID]\" onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a></td>";
		echo "<td>".$id."</td>";
		echo "<td style='text-align:left;'>".$row['firstName']."  ".$row['middleName']."  ".$row["lastName"]."</td>";
		echo "<td style='text-align:left;'>".$row["phone"]."</td>";
		echo "<td style='text-align:left;'>".$row["gender"]."</td>";
		echo "<td style='text-align:left;'>".$row["dateOfBirth"]."</td>";
		echo "<td style='text-align:left;'>".$row["race"]."</td>";
		echo "<td style='text-align:left;'>".ucwords($row["streetName"])." ".ucwords($row["apart_no"])." ".ucwords($row["city"]).", ".$row["states"]." ".$row["zipCode"]."</td>";
		echo "</tr>";
	}
	if( $page > 0 ) {
		$last = $page - 2;
		echo "<a href = \"viewallstudents.php?page=$last\">Last 10 Records</a>  |  <a href = \"viewallstudents.php?page=$page\">Next 10 Records</a>";
	}else if( $page == 0 ) {
		echo "<a href = \"viewallstudents.php?page=$page\">Next 10 Records</a>";
	}else if( $left_rec < $rec_limit ) {
		$last = $page - 2;
		echo "<a href = \"viewallstudents.php?page=$last\">Last 10 Records</a>";
	}
}


/* VIEWING ALL TEACHERS INFORMATION */
function viewAllTeachersInfo() {

	global $mysqli, $errors;
	$rec_limit = 10;
	$rec_count = "";
	$left_rec = "";

	// counting the numbers of rows in the table for paging
	$result = $mysqli->query("SELECT COUNT(teachID) FROM teachertable");
	$row = mysqli_fetch_array($result);
	$rec_count = $row[0];

	if( isset($_GET['page'] ) ) {
		$page = $_GET['page'] + 1;
		$offset = $rec_limit * $page ;
	}else {
		$page = 0;
		$offset = 0;
	}
	$left_rec = ceil($rec_count - ($page * $rec_limit));

// selecting all the rows in teachers table
	$result = $mysqli->query("SELECT * FROM teachertable LIMIT $offset, $rec_limit");
	$num = mysqli_num_rows($result);

// if no record -- display it the error messages
	if (!$result) {
		array_push($errors, "Could not get data");
		header("Location: viewallteachers.php");
	}

// displaying all the selected record in a table
	while ($row = mysqli_fetch_array($result)) {
    # code...
		$phone = formatPhone($row['t_phone']);
		$id = $row['prefix']."".$row['teachID'];

		echo "<tr>";
		echo "<td><a href=\"editteacher.php?teachID=$row[teachID]\">Edit</a> | <a href=\"deleteTeacher.php?teachID=$row[teachID]\" onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a></td>";
		echo "<td style='text-align:center;'>".$id."</td>";
		echo "<td style='text-align:left;'>".ucfirst($row["t_fname"])."  ".ucfirst($row["t_middlename"])."  ".ucfirst($row["t_lname"])."</td>";
		echo "<td style='text-align:center;'>".$phone."</td>";
		echo "<td style='text-align:center;'>".$row["t_dateOfBirth"]."</td>";
		echo "<td style='text-align:left;'>".ucwords($row["t_streetName"])." ".ucwords($row["t_apart_no"])." ".ucwords($row["t_city"]).", ".$row["t_states"]." ".$row["t_zipCode"]."</td>";
		echo "</tr>";
	}

	if( $page > 0 ) {
		$last = $page - 2;
		echo "<a href =\"viewallteachers.php?page=$last\">Last 10 Records</a>  |  <a href = \"viewallteachers.php?page=$page\">Next 10 Records</a>";
	}else if( $page == 0 ) {
		echo "<a href = \"viewallteachers.php?page=$page\">Next 10 Records</a>";
	}else if( $left_rec < $rec_limit ) {
		$last = $page - 2;
		echo "<a href = \"viewallteachers.php?page=$last\">Last 10 Records</a>";
	}
}

/*
DELETING A STUDENT FROM THE DATABASE
*/

function deleteStudent($id){
	global $mysqli, $errors;

	if ($_SESSION['privilegeID'] === '1' && $_SESSION['privilegeName'] === 'Administrator') {
    # code...
		$result = $mysqli->multi_query("DELETE FROM studenttable 
			WHERE studentID = '$id'");
		$result .= $mysqli->multi_query("DELETE FROM userstable 
			WHERE studentID = '$id'");

		if (!$result) {
			array_push($errors, "Could not delete data");
			header("Location: viewallstudents.php");
		}else{
			array_push($errors, "You've successfully deleted");
			header("Location: viewallstudents.php");
		}

	}
}

// function to format phone number
function formatPhone($number){
$number = preg_replace('/[^\d]/', '', $number); //Remove anything that is not a number
if(strlen($number) < 10){
	return false;
}
$phone_display = sprintf('(%s)%s-%s',
	substr($number,0,3),
	substr($number,3,3),
	substr($number,6,4));
return $phone_display;
}

function valid_zipcode($zipcode) {
	return preg_match('/^[0-9]{5}([- ]?[0-9]{4})?$/', $zipcode);
}

/*
VIEWING ALL THE LIST OF COURSES
*/
function viewAllCourses() {
	global $mysqli, $errors;
	$rec_limit = 10;
	$rec_count = "";
	$left_rec = "";

	$result = $mysqli->query("SELECT COUNT(courseID) FROM coursetable ORDER BY courseID");
	$row = mysqli_fetch_array($result);
	$rec_count = $row[0];

// echo $rec_count;

	if( isset($_GET['page'] ) ) {
		$page = $_GET['page'] + 1;
		$offset = $rec_limit * $page ;
	}else {
		$page = 0;
		$offset = 0;
	}
	$left_rec = ceil($rec_count - ($page * $rec_limit));

	$result = $mysqli->query("SELECT * FROM coursetable LIMIT $offset, $rec_limit");
	$num = mysqli_num_rows($result);

	if (!$result) {
		array_push($errors, "Could not get data");
		header("Location: viewallcourses.php");
	}

	while ($row = mysqli_fetch_array($result)) {
    # code...
		$courseID = $row["courseID"];
		$c_code = $row["courseCode"];
		$c_name = $row["courseName"];

		$_SESSION["courseID"] = $courseID;
		$_SESSION['code'] = $c_code;
		$_SESSION['name'] = $c_name;

		echo "<tr>";
		echo"<input type='hidden' name='edit' value='1'>";
		echo "<td><a href=\"editcourse.php?courseID=$row[courseID]\" id='edit'> Edit </a> | <a href=\"deleteCourse.php?courseID=$row[courseID]\" onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a></td>";
		echo "<td style='text-align:left;'>".$row["courseID"]."</td>";
		echo "<td style='text-align:left;'>".$row["courseCode"]."</td>";
		echo "<td style='text-align:left;'>".$row["courseName"]."</td>";
		echo "</tr>";
	}

	if( $page > 0 ) {
		$last = $page - 2;
		echo "<a href = \"viewallcourses.php?page=$last\">Last 10 Records</a>  |  <a href = \"viewallcourses.php?page=$page\">Next 10 Records</a>";
	}else if( $page == 0 ) {
		echo "<a href = \"viewallcourses.php?page=$page\">Next 10 Records</a>";
	}else if( $left_rec < $rec_limit ) {
		$last = $page - 2;
		echo "<a href = \"viewallcourses.php?page=$last\">Last 10 Records</a>";
	}
}

// function to redirect to admin portal
function adminPortal(){
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = '../admin/adminportal.php';
	header("Location: http://$host$uri/$extra");
}
// function to redirect to student portal
function studentPortal(){
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = '../public/studentportal.php';
	header("Location: http://$host$uri/$extra");
}

// function to redirect to admin portal
function teacherPortal(){
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = '../teacher/teacherportal.php';
	header("Location: http://$host$uri/$extra");
}


/*
DELETING A TEACHERS FROM THE DATABASE
*/

function deleteTeacher($id){
	global $mysqli, $errors;

	if ($_SESSION['privilegeID'] === '1' && $_SESSION['privilegeName'] === 'Administrator') {
    # code...
		$result = $mysqli->multi_query("DELETE FROM teachertable 
			WHERE teachID = '$id'");
		$result .= $mysqli->multi_query("DELETE FROM userstable 
			WHERE teachID = '$id'");

		if (!$result) {
			array_push($errors, "Could not delete data");
			header("Location: viewallteachers.php");
		}else{
			array_push($errors, "You've successfully deleted");
			header("Location: viewallteachers.php");
		}

	}
}



/*
DELETING A COURSE FROM THE DATABASE
*/

function deleteCourse($id){
	global $mysqli, $errors;

	if ($_SESSION['privilegeID'] === '1' && $_SESSION['privilegeName'] === 'Administrator') {
    # code...
		$result = "DELETE FROM coursetable WHERE courseID = '$id'";
		$num = $mysqli->query($result);

		if (!$num) {
			array_push($errors, "Could not delete data");
			header("Location: viewallcourses.php");
		}else{
			array_push($errors, "You've successfully deleted");
			header("Location: viewallcourses.php");
		}

	}
}

// call the addcourse() function if register_btn is clicked
if (isset($_POST['add_btn'])) {
	addCourse();
}
/*DELETING A COURSE FROM THE DATABASE*/
function addCourse() {

	global $mysqli,
	$errors,
	$coursename,
	$coursecode;

	$code = escape($_POST['courseCode']);
	$name = escape($_POST['courseName']);

	if (empty($code)) { 
		array_push($errors, "Course Code is required");
	}elseif(strlen($code) < 6){
		array_push($errors, "Course code can't be less 6 character(s)");
	}else{
		$code =  strtoupper($code);
	}

	if (empty($name)) { 
		array_push($errors, "Course Name is required"); 
	}else{
		$name =  strtoupper($name);
	}

	if (count($errors) == 0) {
		if ($_SESSION['privilegeID'] === '1' 
			&& $_SESSION['privilegeName'] === 'Administrator') {


			$result = $mysqli->query("SELECT courseCode, courseName FROM coursetable WHERE courseCode = '$code' OR courseName = '$name'");
		$num = mysqli_num_rows($result);

		if ($num == 1) {
			array_push($errors, "Course code/course name already exist...try again!");
		} else {
			$result = "INSERT INTO coursetable (courseCode, courseName)
			VALUES ('$code', '$name')";
			$sql  = $mysqli->query($result);
			header("Location: viewallcourses.php");           
		}

	} else {
		array_push($errors, "Please contact your Administrator");
		header("Location: viewallcourses.php");
	}
}
}

/* DELETING A STUDENT FROM THE DATABASE */
function hashPass($pass){
	$options = [
		'cost' => 11,
		'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
	];
	$pass = password_hash($pass, PASSWORD_BCRYPT, $options);
	return $pass;
}

// Calling rest password function
if (isset($_POST['lostpass_btn'])) {
	restPass();
}

// Rest password function
function restPass() {
	global $mysqli, $errors;

	$user = escape($_POST['username']);
	$pass = $_POST['pass1'];
	$pass2 = $_POST['pass2'];

    // make sure form is filled properly
	if (empty($user)) {
		array_push($errors, "Please enter your Username");
	}
	if (empty($pass)) {
		array_push($errors, "Please enter your Password");
	}
	if (empty($pass2)) {
		array_push($errors, "Confirm your Password");
	}
	if ($pass != $pass2) {
		array_push($errors, "The two passwords do not match");
	}else{
		$hash = hashPass($pass);
	}

	if (strpos($user, '@') === false) {
		$user_cond = "userName='$user'";
	} else {
		$user_cond = "email='$user'";
	}

	if (count($errors) == 0) {
    	# code...
		$result = $mysqli->query("SELECT *
			FROM userstable 
			WHERE $user_cond");

		if (mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_array($result);
			$id = $row['userID'];
			$_SESSION['username'] = $row['userName'];
			$mysqli->query("UPDATE userstable 
				SET password = '$hash' 
				WHERE userID = '$id'");
			header("Location: passchangesuccess.php");
		}else {
			array_push($errors, "Sorry! We cannot find your account. Click <a href='registration.php'>here</a> to create an account");
		}
	}
}

// calling function
if (isset($_POST['TeachPass_btn'])) {
	# code...
	createTeachPass();
}
// declaring createTeachPass
function createTeachPass() {
	global $mysqli, $errors, $date;

	$email = escape($_POST['email']);
	$username = escape($_POST['username']);
	$pass1 = $_POST['pass1'];
	$pass2 = $_POST['pass2'];
	$uid = $_POST['uid'];
	$date = $date->format('Y-m-d h:i:s');

	if (empty($username)) {
		array_push($errors, "Username is required");
	}
	if (empty($email)) {
		array_push($errors, "E-mail is required");
	}
	if (empty($pass1)) {
		array_push($errors, "Password is required");
	}
	if (empty($pass2)) {
		array_push($errors, "Confirm your password");
	}
	if ($pass1 != $pass2) {
		array_push($errors, "The two passwords do not match");
	}else{
		$hash = hashPass($pass1);
	}

	if (count($errors) == 0) {
		
		$result = 
		$mysqli->query("SELECT userName, email 
			FROM userstable 
			WHERE userName = '$username'");
		if (mysqli_num_rows($result) == 1){
			array_push($errors, "Username/Email already exists");
		}else {

			if (isset($_POST['user_type'])) {

				$user_type = escape($_POST['user_type']);

				$result = $mysqli->query("INSERT INTO userstable (teachID, privilegeID, userName, password, email, createDate, privilegeName) 
					VALUES ('$uid', 2, '$username', '$hash', '$email', '$date', '$user_type')");

			}else{
				$result = $mysqli->query("INSERT INTO userstable (teachID, privilegeID, userName, password, email, createDate, privilegeName) 
					VALUES ('$uid', 2, '$username', '$hash', '$email', '$date', 'Teacher')");
				if (!$result) {
					array_push($errors, "Unable to create account...please try again later!");
				}else{
					header("Location: viewallteachers.php");

				} // end of if (!$result)

			} // end of if (isset($_POST['user_type']))

		}//if (mysqli_num_rows($result) == 1)

	} // end of if (count($errors) == 0)

}

// calling function
if (isset($_POST['studPass_btn'])) {
	createStudPass();
}
// declaring createTeachPass
function createStudPass() {
	global $mysqli, $errors, $date;

	$email = escape($_POST['email']);
	$username = escape($_POST['username']);
	$pass1 = $_POST['pass1'];
	$pass2 = $_POST['pass2'];
	$uid = $_POST['uid'];
	$date = $date->format('Y-m-d h:i:s');

	if (empty($username)) {
		array_push($errors, "Username is required");
	}
	if (empty($email)) {
		array_push($errors, "E-mail is required");
	}
	if (empty($pass1)) {
		array_push($errors, "Password is required");
	}
	if (empty($pass2)) {
		array_push($errors, "Confirm your password");
	}
	if ($pass1 != $pass2) {
		array_push($errors, "The two passwords do not match");
	}else{
		$hash = hashPass($pass1);
	}

	if (count($errors) == 0) {
		
		$result = 
		$mysqli->query("SELECT userName, email 
			FROM userstable 
			WHERE userName = '$username'");
		if (mysqli_num_rows($result) == 1){
			array_push($errors, "Username/Email already exists");
		}else {

			if (isset($_POST['user_type'])) {

				$user_type = escape($_POST['user_type']);

				$result = $mysqli->query("INSERT INTO userstable (teachID, privilegeID, userName, password, email, createDate, privilegeName) 
					VALUES ('$uid', 3, '$username', '$hash', '$email', '$date', '$user_type')");

			}else{
				$result = $mysqli->query("INSERT INTO userstable (studentID, privilegeID, userName, password, email, createDate, privilegeName) 
					VALUES ('$uid', 3, '$username', '$hash', '$email', '$date', 'Student')");
				if (!$result) {
					array_push($errors, "Unable to create account...please try again later!");
				}else{
					header("Location: viewallstudents.php");

				} // end of if (!$result)

			} // end of if (isset($_POST['user_type']))

		}//if (mysqli_num_rows($result) == 1)

	} // end of if (count($errors) == 0)

} /*function createStudPass()*/

function viewclasslist(){
	global $mysqli, $errors;
	$rec_limit = 10;
	$rec_count = "";
	$left_rec = "";

	$result = $mysqli->query("SELECT COUNT(studentgradeID) FROM studentgradetable ORDER BY studentgradeID");
	$row = mysqli_fetch_array($result);
	$rec_count = $row[0];

	if(isset($_GET['page'])) {
		$page = $_GET['page'] + 1;
		$offset = $rec_limit * $page ;
	}else {
		$page = 0;
		$offset = 0;
	}

	$left_rec = ceil($rec_count - ($page * $rec_limit));

	$result  = 
	$mysqli->query("SELECT studentgradetable.*, studenttable.*, coursetable.*, gradetable.*
		FROM (((studentgradetable 
		INNER JOIN studenttable
		ON studentgradetable.studentID = studenttable.studentID)
		INNER JOIN coursetable 
		ON studentgradetable.courseID = coursetable.courseID)
		INNER JOIN gradetable 
		ON studentgradetable.gradeID = gradetable.gradeID)
		LIMIT $offset, $rec_limit");

	while ($row = mysqli_fetch_array($result)){
		$studid = $row['prefix'].$row['studentID'];
		echo "<tr>";
		echo "<td><a>Edit</a> | <a>Delete</a></td>";
		echo "<td>".$studid."</td>";
		echo "<td style='text-align:left;'>".$row['firstName']."</td>";
		echo "<td style='text-align:left;'>".$row['lastName']."</td>";
		echo "<td style='text-align:left;'>".$row['courseCode']."</td>";
		echo "<td style='text-align:left;'>".$row['courseName']."</td>";
		echo "<td>".$row['grade']."</td>";
		echo "</tr>";		
	}

	if( $page > 0 ) {
		$last = $page - 2;
		echo "<a href = \"../teacher/classlist.php?page=$last\">Last 10 Records</a>  |  <a href = \"../teacher/classlist.php?page=$page\">Next 10 Records</a>";
	}else if( $page == 0 ) {
		echo "<a href = \"../teacher/classlist.php?page=$page\">Next 10 Records</a>";
	}else if( $left_rec < $rec_limit ) {
		$last = $page - 2;
		echo "<a href = \"../teacher/classlist.php?page=$last\">Last 10 Records</a>";
	}
}

// function for student(s) registered courses
function courselist(){
	global $mysqli, $errors;
	$rec_limit = 10;
	$rec_count = "";
	$left_rec = "";
	$teachid = $_SESSION['teachID'];

	$result = $mysqli->query("SELECT COUNT(studentCourseID) FROM studentcoursetable ORDER BY studentCourseID");
	$row = mysqli_fetch_array($result);
	$rec_count = $row[0];

	if(isset($_GET['page'])) {
		$page = $_GET['page'] + 1;
		$offset = $rec_limit * $page ;
	}else {
		$page = 0;
		$offset = 0;
	}

	$left_rec = ceil($rec_count - ($page * $rec_limit));

	$result  = 
	$mysqli->query("SELECT studentcoursetable.*, studenttable.*, coursetable.*, teachertable.* 
		FROM (((studentcoursetable 
		INNER JOIN studenttable
		ON studentcoursetable.studentID = studenttable.studentID)
		INNER JOIN coursetable 
		ON studentcoursetable.courseID = coursetable.courseID)
		INNER JOIN teachertable 
		ON studentcoursetable.teachID = teachertable.teachID)
		WHERE teachertable.teachID = '$teachid' LIMIT $offset, $rec_limit");

	while ($row = mysqli_fetch_array($result)){

		$studid = $row['prefix'].$row['studentID'];
		$name = $row['t_fname']." ".$row['t_middlename'].". ".$row['t_lname'];

		echo "<tr>";
		echo "<td>".$studid."</td>";
		echo "<td style='text-align:left;'>".$row['firstName']."</td>";
		echo "<td style='text-align:left;'>".$row['lastName']."</td>";
		echo "<td>".$row['courseCode']."</td>";
		echo "<td>".$row['courseName']."</td>";
		echo "<td>".$row['enrollDate']."</td>";
		echo "<td style='text-align:left;'>".$name."</td>";
		echo "</tr>";		
	}

	if( $page > 0 ) {
		$last = $page - 2;
		echo "<a href = \"../admin/courselist.php?page=$last\">Last 10 Records</a>  |  <a href = \"../admin/courselist.php?page=$page\">Next 10 Records</a>";
	}else if( $page == 0 ) {
		echo "<a href = \"../admin/courselist.php?page=$page\">Next 10 Records</a>";
	}else if( $left_rec < $rec_limit ) {
		$last = $page - 2;
		echo "<a href = \"../admin/courselist.php?page=$last\">Last 10 Records</a>";
	}
}


// function for student(s) registered courses
function courselistadmin(){
	global $mysqli, $errors;
	$rec_limit = 10;
	$rec_count = "";
	$left_rec = "";
	// $teachid = $_SESSION['teachID'];

	$result = $mysqli->query("SELECT COUNT(studentCourseID) FROM studentcoursetable ORDER BY studentCourseID");
	$row = mysqli_fetch_array($result);
	$rec_count = $row[0];

	if(isset($_GET['page'])) {
		$page = $_GET['page'] + 1;
		$offset = $rec_limit * $page ;
	}else {
		$page = 0;
		$offset = 0;
	}

	$left_rec = ceil($rec_count - ($page * $rec_limit));

	$result  = 
	$mysqli->query("SELECT studentcoursetable.*, studenttable.*, coursetable.*, teachertable.* 
		FROM (((studentcoursetable 
		INNER JOIN studenttable
		ON studentcoursetable.studentID = studenttable.studentID)
		INNER JOIN coursetable 
		ON studentcoursetable.courseID = coursetable.courseID)
		INNER JOIN teachertable 
		ON studentcoursetable.teachID = teachertable.teachID)
		LIMIT $offset, $rec_limit");

	while ($row = mysqli_fetch_array($result)){

		$studid = $row['prefix'].$row['studentID'];
		$name = $row['t_fname']." ".$row['t_middlename'].". ".$row['t_lname'];

		echo "<tr>";
		echo "<td>".$studid."</td>";
		echo "<td style='text-align:left;'>".$row['firstName']."</td>";
		echo "<td style='text-align:left;'>".$row['lastName']."</td>";
		echo "<td>".$row['courseCode']."</td>";
		echo "<td>".$row['courseName']."</td>";
		echo "<td>".$row['enrollDate']."</td>";
		echo "<td style='text-align:left;'>".$name."</td>";
		echo "</tr>";		
	}

	if( $page > 0 ) {
		$last = $page - 2;
		echo "<a href = \"../admin/courselist.php?page=$last\">Last 10 Records</a>  |  <a href = \"../admin/courselist.php?page=$page\">Next 10 Records</a>";
	}else if( $page == 0 ) {
		echo "<a href = \"../admin/courselist.php?page=$page\">Next 10 Records</a>";
	}else if( $left_rec < $rec_limit ) {
		$last = $page - 2;
		echo "<a href = \"../admin/courselist.php?page=$last\">Last 10 Records</a>";
	}
}


// username function
function tuserName($id){
	global $mysqli;
	$result = $mysqli->query("SELECT t_fname FROM teachertable WHERE teachID = '$id'");
	$user = mysqli_fetch_array($result);
	$_SESSION['fname'] = $user['t_fname'];
	return $_SESSION['fname'];
}
// username function
function studentUserName($id){
	global $mysqli;
	$result = $mysqli->query("SELECT firstName FROM studenttable WHERE studentID = '$id'");
	$user = mysqli_fetch_array($result);
	$_SESSION['fname'] = $user['firstName'];
	return $_SESSION['fname'];
}

// username function
function adminUserName($id){
	global $mysqli;
	$result = $mysqli->query("SELECT a_fname FROM admintable WHERE adminID = '$id'");
	$user = mysqli_fetch_array($result);
	$_SESSION['a_fname'] = $user['a_fname'];
	return $_SESSION['a_fname'];
}