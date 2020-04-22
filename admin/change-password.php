<?php
error_reporting(1);

$db = new DBConnection;

session_start();

if(isset($_POST['submit']))
{
    $servername = "localhost";
    $usrname = "adminportal";
    $pass = "admin123";
    $dbname = "adminportal";

    $password = $_POST['password'];
    $newpassword = $_POST['newpassword'];
    $username = $_SESSION['Alogin'];
    $timestamp = date("Y-m-d H:i:s");

    $sql ="SELECT password FROM admin WHERE UserName=:username and Password=:password";

    $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $usrname, $pass);
    $query= $dbh -> prepare($sql);
    $query-> bindParam(':username', $username, PDO::PARAM_STR);
    $query-> bindParam(':password', $password, PDO::PARAM_STR);
    $query-> execute();
    $results = $query -> fetchAll(PDO::FETCH_OBJ);

        if($query -> rowCount() > 0)
        {
            $con="update admin set updationDate=:timestamp, Password=:newpassword where UserName=:username";
            $chngpwd1 = $dbh->prepare($con);
            $chngpwd1-> bindParam(':username', $username, PDO::PARAM_STR);
            $chngpwd1-> bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
            $chngpwd1->execute();

            //Display message
            echo "<script>alert('Your password successfully changed.');</script>";
            {redirect('?a=dashboard');}
        }
        else {
            echo "<script>alert('Your current password is invalid.');</script>";
        }
}
?>
<h2 class="page-title">Change Password</h2>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">Form field</div>
            <div class="panel-body">
                <form method="post" name="chngpwd" class="form-horizontal" onSubmit="return valid();">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Current Password</label>
                        <div class="col-sm-4">
                            <input type="password" class="form-control" name="password" id="password" required>
                        </div>
                    </div>

                    <div class="hr-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">New Password</label>
                        <div class="col-sm-4">
                            <input type="password" class="form-control" name="newpassword" id="newpassword" required>
                        </div>
                    </div>

                    <div class="hr-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Confirm Password</label>
                        <div class="col-sm-4">
                            <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" required>
                        </div>
                    </div>

                    <div class="hr-dashed"></div>
                    <div class="form-group">
                        <div class="col-sm-8 col-sm-offset-2">
                            <button class="btn btn-primary" name="submit" type="submit" onclick="valid">Save changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--**************************************************************************************************************************-->
<!-- Loading Scripts -->
<script src="js/combodate.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap-select.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>
<script src="js/Chart.min.js"></script>
<script src="js/fileinput.js"></script>
<script src="js/chartData.js"></script>
<script src="js/main.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<!--**************************************************************************************************************************-->
</body>
</html>
