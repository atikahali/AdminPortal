<?php
include 'lib/conn.php';
include 'lib/function.php';

$db = new DBConnection;
session_start();
if(isset($_POST['login']))
{
$employeeNo=$_POST['employeeNo'];
$password=($_POST['password']);
$sql ="SELECT employeeNo,password FROM tblusers WHERE EmployeeNo='".$employeeNo."' and Password='".$password."'";
//    echo $sql;
$query= $dbh -> prepare($sql);
$query-> bindParam(':employeeNo', $employeeNo, PDO::PARAM_STR);
$query-> bindParam(':password', $password, PDO::PARAM_STR);
$query-> execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
$_SESSION['login']=$_POST['employeeNo'];
//$_SESSION['fname']=$results->FullName;
//$currentpage=$_SERVER['REQUEST_URI'];
  $msg = "Login successful";

  echo "<script type='text/javascript'>alert('$msg'); </script>";
    
echo "<script> location.href='/adminportal/register.php'</script>";
} 
    else{
  $message = "Username and/or Password incorrect.\\nTry again.";

  echo "<script type='text/javascript'>alert('$message'); </script>";
echo "<script> location.href='/reservation/index.php'</script>";


        
//        echo "<script>alert('Invalid Details') ('Could not show result: '.mysql_error());</script>";

        }

}


/*if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      
      $employeeNo = mysql_real_escape_string($db,$_POST['employeeNo']);
      $password = mysql_real_escape_string($db,$_POST['password']); 
      
      $sql = "SELECT * FROM tblusers WHERE employeeNo= '".$employeeNo."' and password = '".$password."'";
    echo $sql;
      $result = mysql_query($db,$sql);
      $row = mysql_fetch_array($result,MYSQL_ASSOC);
      $active = $row['active'];
      
      $count = mysql_num_rows($result);
      
      // If result matched $myusername and $mypassword, table row must be 1 row
		
      if($count == 1) {
         session_register("employeeNo");
         $_SESSION['login'] = $employeeNo;
         
         header("location: buking.php");
      }else {
         $error = "Your Login Name or Password is invalid";
      }
   }*/

?>