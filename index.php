<?php

include('lib/conn.php');
include('lib/function.php');
/**
Full Access  - No authorization
**/
$db = new DBConnection;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin e-Booking Portal | User Login</title>
    <!--<link rel="icon" href="pic/favicon.jpg" type="favicon">-->
    <link rel="stylesheet" href="css/stylelogin-user.css" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
<!-- Background image -->
<div class="bg">
<!-- Navigation -->
<div class="menu">
    <div class="topnav">
        <img src="pic/Logo_EPIC.png" alt="logo" style="float: left; margin-left: 20px; margin-right: 5px;">
        <a href="index2.php"><b><i class="fa fa-fw fa-users"></i>&nbsp; Admin</b> </a>
        <div class="dropdown"><b>User Manual &nbsp;<i class="fa fa-caret-down"></b></i>
            <div class="dropdown-content">
                <a href="pic/mt.pdf" target="_blank"><i class="fa fa-file-pdf-o"></i>&nbsp; Meeting Room </a>
                <a href="pic/vh.pdf" target="_blank"><i class="fa fa-file-pdf-o"></i>&nbsp; Vehicle </a>
            </div>
        </div>
        <div class="login-container">
            <form action="loginAction.php" method="post" class="form-inline">
                <input type="text" placeholder="Employee No" name="employeeNo">
                <div class="tooltip"><input type="password" placeholder="Password" name="password" style="width:150px;">
                    <span class="tooltiptext">Pass Id No</span>
                </div>
                <button type="submit" name="login" value="login">Login</button>
            </form>
        </div>
    </div>
</div>
<!-- /.navigation -->

<!-- Page Content -->
</br>
<div class="container">
    <form action="register.php" method="post" enctype="multipart/form-data" autocomplete="off" name="myform" >
        <h2 align="center"><b>Admin e-Booking Portal</b></h2>
        <h3 align="center"><b>Sign Up</b></h3>
        <input type="text" name="FullName" placeholder="Full Name" required>
        <input type="text" name="EmployeeNo" placeholder="Employee No" minlength="5" maxlength="9" required>
        <div class="tooltips">
            <input type="text" name="Password" placeholder="Pass Id No" minlength="7" maxlength="8" required>
            <span class="tooltiptext"><img src="pic/PassIDNo.jpg" alt="logo"></span>
        </div>
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
</div>
<!-- /.container -->

</div>
<!-- /.background image -->
</body>
</html>
