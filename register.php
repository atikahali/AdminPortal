<?php

include('lib/conn.php');
include('lib/function.php');
/**
Full Access  - No authorization
**/
$db = new DBConnection;

if ( $_SESSION['reload'] == 1 ) {
   msgAlert("This page was already expired");
   $_SESSION['reload'] = 0;
   redirect("index.php");
}

if(isset($_POST['register'])) {

    $FullName = strtoupper($_POST['FullName']);
    $EmployeeNo = strtoupper($_POST['EmployeeNo']);
    $Position = strtoupper($_POST['Position']);
    $Department = $_POST['Department'];
    $Company = $_POST['Company'];
    $Manager = $_POST['Manager'];
    $Email = strtolower($_POST['Email']);
    $status = $_POST['status'];
    $access = $_POST['access'];
    $Password = $_POST['Password'];
    $timestamp = date("Y-m-d H:i:s");
    $emails   = "epicgroup.com.my";

    if (strpos( $Email, $emails ) == false) {
        //echo "email must contain \"epicgroup.com.my\"";
        echo "<script>alert('Please use epicgroup email');</script>";
        redirect("index.php");
    }
    //Check Booking Exist
    $query = "SELECT EmployeeNo FROM tblusers WHERE EmployeeNo = '$EmployeeNo'";

    $result = mysql_query($query);
    $rowchk = mysql_num_rows($result);

    if ($rowchk > 0) {
        echo "<script>alert('You already register. Please login.');</script>";
        redirect("index.php");
    } else {
        $sqlIns = "INSERT INTO tblusers (FullName, EmployeeNo, Position, Department, Company, Manager, Email, Password, RegDate, status, access) VALUES 
        ('" . $FullName . "','" . $EmployeeNo . "','" . $Position . "','" . $Department . "','" . $Company . "','" . $Manager . "','" . $Email . "','" . $Password . "', '$timestamp', '$status', '2')";

        $rsIns = $db->query($sqlIns);

        if ($rsIns == true) {
            msgAlert("Registration successful. Now you can login.");
            redirect("index.php");
        } else {
            msgAlert("Something went wrong. Please try again.");
            redirect("index.php");
        }
    }
}	
?>
<!--<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin e-Booking Portal | User Registration</title>
    <link href="css/styleform.css" rel="stylesheet" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>-->
<!-- Background image -->
<!--<div class="bg">-->
    <!-- Navigation -->
<!--<div class="navbar">
    <img src="pic/Logo_EPIC.png" alt="logo" style="margin-left: 20px">

    <a href="index.php"><b><i class="fa fa-fw fa-user"></i> Login</b></a>
</div>-->
<!-- /.navigation -->

    <!-- Page Content -->
<!-- <div class="container">

    <form action="register.php" method="post" enctype="multipart/form-data" autocomplete="off" name="myform" >
        <h2><center><b>Sign Up</b></center></h2>
        <input type="text" name="FullName" placeholder="Full Name" required>
        <input type="text" name="EmployeeNo" placeholder="Employee No" minlength="5" maxlength="9" required>
        <input type="text" name="Password" placeholder="Card Id No" minlength="7" maxlength="8" required>
        <input type="email" name="Email" id="Email" placeholder="email@epicgroup.com.my" style="text-transform: lowercase;" required>
        <select id="Position" name="Position" placeholder="" required>
          <option value="" >Position</option>
          <?php
          /*mysql_connect("localhost","root","");
          mysql_select_db("reservationdb");*/

          $sql = "SELECT pstId, position FROM position WHERE pstStatus = 'Active' ORDER BY position ASC";
          $radmin = mysql_query($sql);

          while ( ( $rowAdm = mysql_fetch_array($radmin) ) != false ) {
              ?>
              <option  value="<?php echo $rowAdm['pstId']; ?>">
                  <?php echo $rowAdm['position'];  ?></option>

          <?php } // close while ?>
        </select>

        <select id="Manager" name="Manager" placeholder="" required>
          <option value="" >N + 1</option>
          <?php
          /*mysql_connect("localhost","root","");
          mysql_select_db("reservationdb");*/

          $sql = "SELECT ManagerNo, manager FROM manager WHERE status = 'Active' ORDER BY manager ASC";
          $radmin = mysql_query($sql);

          while ( ( $rowAdm = mysql_fetch_array($radmin) ) != false ) {
              ?>
              <option  value="<?php echo $rowAdm['ManagerNo']; ?>">
                  <?php echo $rowAdm['manager'];  ?></option>

          <?php } // close while ?>
        </select>

        <select id="Department" name="Department" placeholder="" required>
          <option value="" >Department</option>
          <?php
          /*mysql_connect("localhost","root","");
          mysql_select_db("reservationdb");*/

          $sql = "SELECT dpmtCode, department FROM department WHERE dpmtStatus = 'Active' ORDER BY department ASC";
          $radmin = mysql_query($sql);

          while ( ( $rowAdm = mysql_fetch_array($radmin) ) != false ) {
              ?>
              <option  value="<?php echo $rowAdm['dpmtCode']; ?>">
                  <?php echo $rowAdm['department'];  ?></option>

          <?php } // close while ?>
        </select>

        <select id="Company" name="Company" placeholder="" required>
          <option value="" >Company</option>
          <?php
          /*mysql_connect("localhost","root","");
          mysql_select_db("reservationdb");*/

          $sql = "SELECT cmpCode, company FROM company WHERE cmpStatus = 'Active' ORDER BY company ASC";
          $radmin = mysql_query($sql);

          while ( ( $rowAdm = mysql_fetch_array($radmin) ) != false ) {
              ?>
              <option  value="<?php echo $rowAdm['cmpCode']; ?>">
                  <?php echo $rowAdm['company'];  ?></option>

          <?php } // close while ?>
        </select>

        <input name="status" type="textfield" value="Active" class="form-control" hidden>

        <input name="access" type="textfield" value="2" class="form-control" hidden>

        <button type="submit" name="register">Register</button>


    </form>
    </div>-->
    <!-- /.container -->

<!-- </div>-->
 <!-- /.background image -->
<!--</body>
</html> -->
