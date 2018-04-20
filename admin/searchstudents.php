<!DOCTYPE html>
<html lang="en">
<head>

    <!-- Required meta tags -->
    <title>Results</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Style CSS -->
    <link rel="stylesheet" type="text/css" href="../public/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../public/css/style.css">
    <link rel="stylesheet" type="text/css" href="../public/css/dropdown-menu.css">
    <link rel="stylesheet" type="text/css" href="../public/css/table.css">
       <link rel="shortcut icon" type="image/png" href="../image/favicon_image.png">

</head>
<body> 

    <!-- Header  -->
    <div class="header">
    </div>

    <ul>
        <li class="dropdown">
            <img src = "../image/menu.png" alt = "logout" width="18" height="21" vertical-align="middle" /><a href="javascript:void(0)" class="dropbtn" align="center">Admin Menu</a>
            <div class="dropdown-content">
        <a href="adminportal.php">Admin Portal</a>
        <a href="viewallstudents.php">Students</a>
        <a href="viewallcourses.php">Courses</a>
        <a href="courselist.php">Registered Students</a>
        <a href="viewallteachers.php">Teachers</a>
        <a href="admincalendar.php">Calendar</a>
            </div>
        </li>
    </ul>

    <br><br><br> 
    <img src = "../image/eschooling_logo1.png" alt = "e-schooling logo" width="195" height="70" align="left" hspace="10"/> 

    <!-- Title -->
    <br><br><br><br><br>
    <h1><strong>Search Results</strong></h1>
    <br><br>

<!-- Table -->
<div class="table">
    <table id="table" table align="center" table width = "95%" cellspacing="3" cellpadding="10" table id="table">
        <thead>
            <tr>
                <th>Update</th>
                <th>Student ID</th>
                <th>Name</th>
                <th>D.O.B</th>
                <th>Phone</th>
                <th>Gender</th>
                <th>Race</th>
                <th>Address</th>
            </tr>            
        </thead>
        <tbody>
            <?php ?>
        </tbody>
        <tfoot>
            
        </tfoot>
</div>

        <!-- Footer -->
<div class="footer" text-align: "center" vertical-align="middle">
    <p>  © e-Schooling Management Systems <br>
       12345 Post Oak Road Houston, TX 77054 (832)555-5522
       <br>
    </p>
</div>

</body>
</html>
<?php

/**
 * Function to query information based on 
 * a parameter: in this case, lastName.
 *
 */

if (isset($_POST['submit'])) {

  try { 
    require_once ('../core/Init.ini');
    $mysqli = $db->getConnection();

    $result = "SELECT * 
    FROM studenttable
    WHERE lastName = :lastName";

    $lastName = $_POST['lastName'];
    se
    // $studentID = $_POST['studentID'];

    $statement = $mysqli->prepare($sql);
    $statement->bindParam(':lastName', $lastName, PDO::PARAM_STR);
    $statement->execute();

    $result = $statement->fetchAll();
}

catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}
}

if (isset($_POST['submit'])) {
    if ($result && $statement->rowCount() > 0) { 

        foreach ($result as $row) { 
            echo "<tr>";
            echo "<td style='text-align:left;'><a href=\"editstudent.php?studentID=$row[studentID]\">Edit</a> | <a href=\"deletestudent.php?studentID=$row[studentID]\" onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a></td>"; 
            echo "<td style='text-align:left;'>". $row['studentID']."</td>";
            echo "<td style='text-align:left;'>". $row['firstName']. $row['middleName'] . $row['lastName'] . "</td>";
            echo "<td style='text-align:left;'>". $row['dateOfBirth'] ."</td>";
            echo "<td style='text-align:left;'>". $row['phone'] . "</td>";
            echo "<td style='text-align:left;'>". $row['gender'] . "</td>";
            echo "<td style='text-align:left;'>". $row['race'] . "</td>";
            echo "<td style='text-align:left;'>". $row['streetName'] . $row['city'] . $row['state'] . $row['zipCode'] . "</td>";  
            echo '</tr>'; 
        }
        echo '</table><br>'; 
    } 
}

?>

<a href="viewallstudents.php" style="text-align:center" >Back to All Students</a>
<br><br>