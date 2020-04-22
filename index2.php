<?php
include 'lib/conn.php';
include 'lib/function.php';

$db = new DBConnection;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin e-Booking Portal | Admin Login</title>
    <!--<link rel="icon" href="pic/favicon.jpg" type="favicon">-->
    <link rel="stylesheet" href="css/stylelogin-admin.css" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
<!-- Background image -->
<div class="bg">
    <!-- Navigation -->
    <div class="navbar">
        <img src="pic/Logo_EPIC.png" alt="logo" style="float: left; margin-left: 20px; margin-right: 5px;">
        <!--<a href="pic/User_Manual.pdf" download="User Manual"><b><i class="fa fa-file-pdf-o"></i>&nbsp;User Manual</b> </a>-->
        <a href="index.php"><b><i class="fa fa-fw fa-user"></i>User Login</b> </a>

    </div>
    <!-- /.navigation -->

    <!-- Page Content -->
    <div class="container">
        <form action="loginAction2.php" method="post">
            <h2><center><b>Admin e-Booking Portal</b></center></h2>

            <h3 style="height: 5px">Username</h3>
            <select id="UserName" name="username" placeholder="Enter Username" required>
                <option value="" >Enter Username</option>
                <?php
                /*  mysql_connect("localhost","root","");
                  mysql_select_db("reservationdb");*/
                $sqlUser = "SELECT UserName FROM admin ORDER BY UserName DESC";
                $radmin = mysql_query($sqlUser);

                while ( ( $rowAdm = mysql_fetch_array($radmin) ) != false ) {
                    ?>
                    <option  value="<?php echo $rowAdm['UserName']; ?>">
                        <?php echo $rowAdm['UserName'];  ?></option>

                <?php } // close while ?>
            </select>

            <h3 style="height: 5px">Password</h3>
            <input type="password" placeholder="Enter Password" name="password" required>

            <button type="submit" name="Alogin">Login</button>
        </form>
    </div>
    <!-- /.container -->

</div>
<!-- /.background image -->
</body>
</html>
