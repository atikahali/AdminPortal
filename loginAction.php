<?php
error_reporting(1);

include('lib/conn.php');
include('lib/function.php');

$db = new DBConnection;

session_start();

if(isset($_POST['login']))
{
	$employeeNo = $_POST['employeeNo'];
	$password	= $_POST['password'];

	$sqlUser = "SELECT employeeNo, password FROM tblusers WHERE EmployeeNo = '".$employeeNo."' and Password = '".$password."' AND status = 'Active'";

	$rowUser = $db->query($sqlUser);
    $recUser = $db->fetch($rowUser);
    $numUser = $db->num_rows($rowUser);

	if($numUser > 0)
	{
		$_SESSION['login'] = $_POST['employeeNo'];
		$msg = "Login successful.";

		echo "<script type='text/javascript'>alert('$msg'); </script>";
		{redirect('main_page.php');}

	} else {
        $sqlUserM = "SELECT ManagerNo, Ic FROM manager WHERE ManagerNo = '" . $employeeNo . "' and Ic = '" . $password . "' AND status = 'Active'";

        $rowUserM = $db->query($sqlUserM);
        $recUserM = $db->fetch($rowUserM);
        $numUserM = $db->num_rows($rowUserM);

        if($numUserM > 0) {
            $_SESSION['Mlogin'] = $_POST['employeeNo'];
            $msg = "Login successful.";

            echo "<script type='text/javascript'>alert('$msg'); </script>";
            { redirect('manager/main_page.php'); }
        }else{
            $message = "Employee No and/or Password incorrect.\\nTry again.";

            echo "<script type='text/javascript'>alert('$message'); </script>";
            echo "<script> location.href='/adminportal/index.php'</script>";
        }
    }

}else{
    $message = "Employee No and/or Password incorrect.\\nTry again.";

    echo "<script type='text/javascript'>alert('$message'); </script>";
    echo "<script> location.href='/adminportal/index.php'</script>";
}
?>