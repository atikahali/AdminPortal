<?php
include 'lib/conn.php';
include 'lib/function.php';

$db = new DBConnection;
 
if ( $_POST['employeeNo'] == '' || $_POST['password'] == '')
{
	$employeeNo = $_POST['employeeNo'];
    header('Location: index.php?err=1&employeeNo=$employeeNo');
}

else
{
    session_start();
	$employeeNo=$_POST['employeeNo'];
	$password=($_POST['password']);
	$sqlUser = "SELECT employeeNo,password FROM tblusers WHERE EmployeeNo='".$employeeNo."' and Password='".$password."'";
    $rowUser = $db->query($sqlUser);
    $recUser = $db->fetch($rowUser);
    $numUser = $db->num_rows($rowUser);
	
	 if ( $numUser > 0 )
    {
	    redirect('?vh=booking_form');
	
	}else{
            redirect('logout.php?err=3');
    }

}
?>

<html>

</html>