<?php
error_reporting(1);

include('lib/conn.php');
include('lib/function.php');

$db = new DBConnection;

session_start();

if(isset($_POST['Alogin']))
{
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	$sqlAdmin ="SELECT username, password FROM admin WHERE UserName='".$username."' AND Password='".$password."' AND NOT UserName='Admin Manager Vehicle'";

	$rowAdmin = $db->query($sqlAdmin);
    $recAdmin = $db->fetch($rowAdmin);
    $numAdmin = $db->num_rows($rowAdmin);

	if($numAdmin > 0)
	{
		$_SESSION['Alogin']=$_POST['username'];
		$msg = "Login successful.";

		echo "<script type='text/javascript'>alert('$msg'); </script>";
		{redirect('admin/main_page.php');}

	} else {

        $sqlUserM = "SELECT username, password FROM admin WHERE UserName='Admin Manager Vehicle' and Password='".$password."'";

        $rowUserM = $db->query($sqlUserM);
        $recUserM = $db->fetch($rowUserM);
        $numUserM = $db->num_rows($rowUserM);

        if($numUserM > 0) {
            $_SESSION['AMlogin'] = $_POST['username'];
            $msg = "Login successful.";

            echo "<script type='text/javascript'>alert('$msg'); </script>";
            { redirect('admin_manager/main_page.php'); }
        }else{
            $message = "Username and/or Password incorrect.\\nTry again.";

            echo "<script type='text/javascript'>alert('$message'); </script>";
            echo "<script> location.href='/adminportal/index.php'</script>";
        }
    }

}else{
    $message = "Username and/or Password incorrect.\\nTry again.";

    echo "<script type='text/javascript'>alert('$message'); </script>";
    echo "<script> location.href='/adminportal/index.php'</script>";
} 

?>