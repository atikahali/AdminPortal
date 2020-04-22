<?php
require_once "conn.php";
session_start();
if(isset($_POST['Alogin']))

if(isset($_POST['Alogin']))
{
$username=$_POST['username'];
$password=($_POST['password']);
$sql ="SELECT username,password FROM admin WHERE UserName='".$username."' and Password='".$password."'";
//    echo $sql;
$query= $dbh -> prepare($sql);
$query-> bindParam(':username', $username, PDO::PARAM_STR);
$query-> bindParam(':password', $password, PDO::PARAM_STR);
$query-> execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
$_SESSION['alogin']=$_POST['username'];
echo "<script type='text/javascript'> document.location = '/reservation/admin/dashboard.php'; </script>"; /*echo $sql;*/
} 
    else{
        
        echo "<script>alert('Invalid Details')</script>;";
        
        echo "<script type='text/javascript'> document.location = '/reservation/index.php'; </script>";        
//  echo "<script>alert('Invalid Details') document.location = 'login.php'or die('Could not show result: '.mysql_error());</script>";
//        echo $sql;

}

}

?>