<?php
if (!isset($_SESSION)) {
  session_start();
}

include('lib/conn.php');
include('lib/function.php');
include('phpmailer/class.phpmailer.php');
include('phpmailer/class.smtp.php');

if ( !$_SESSION['login'] || $_SESSION['login'] == '' ) {redirect('index.php');}
else {
// not the best solution, but works
// in your php setting use, it helps hiding site wide notices
error_reporting(1);
?>
    <!DOCTYPE html>
    <html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="theme-color" content="#3e454c">

	<title>Admin e-Booking Portal</title>

    <!-- favicon -->
    <!--<link rel="icon" href="pic/favicon.jpg" type="favicon">-->
    <!-- Font awesome -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Sandstone Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Bootstrap Datatables -->
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <!-- Bootstrap social button library -->
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <!-- Bootstrap select -->
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <!-- Bootstrap file input -->
    <link rel="stylesheet" href="css/fileinput.min.css">
    <!-- Awesome Bootstrap checkbox -->
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <!-- Admin Style -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
	<?php include('header.php');?>
	<div class="ts-main-content">
	<?php include('leftbar.php');?>
		<div class="content-wrapper">
			<div class="container-fluid">

				<div class="row">
					<div class="col-md-12">
					
				

						

<div class="panel-body">
	 <?php 
	  $p = $_GET['p'];
	  if ( $p == '' ) {
	     $p = "user_dashboard";
	  }
	  include ($p.'.php'); 
	  ?>

<!--**************************************************************************************************************************-->
                        
                        </div>
					</div>
				</div>
			</div>
		</div>
	</div>
<!--**************************************************************************************************************************-->
<!--**************************************************************************************************************************-->
	
<!--**************************************************************************************************************************-->
</body>
</html>
<?php } // close if login ?>