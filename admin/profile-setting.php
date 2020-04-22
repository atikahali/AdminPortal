 <?php
error_reporting(1);

$db = new DBConnection;

session_start();

if(isset($_POST['submit']))
{
    $servername = "localhost";
    $username = "adminportal";
    $pass = "admin123";
    $dbname = "adminportal";

    $username=$_POST['username'];

    $sql= "UPDATE admin SET UserName= '".$username."' WHERE EmployeeNo='".$employeeNo."'  ";

    $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $pass);
    $query = $dbh->prepare($sql);
    $query->bindParam(':position',$position,PDO::PARAM_STR);
    $query->bindParam(':department',$department,PDO::PARAM_STR);
    $query->bindParam(':employeeNo',$employeeNo,PDO::PARAM_STR);
    $query->execute();
    $lastInsertId = $dbh->lastInsertId();
    echo "<script>alert('Your profile successfully updated.');</script>";
    {redirect('?p=user_dashboard');}
}
?>

<h2 class="page-title">Profile Setting</h2>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">Form field</div>
            <div class="panel-body">
                <form method="post" name="chngpwd" class="form-horizontal" onSubmit="return valid();">
                    <?php
                    $servername = "localhost";
                    $username = "adminportal";
                    $pass = "admin123";
                    $dbname = "adminportal";

                    $employeeNo=$_SESSION['login'];

                    $dpo = "SELECT * from  tblusers where EmployeeNo=:employeeNo";

                    $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $pass);
                    $query = $dbh -> prepare($dpo);
                    $query -> bindParam(':employeeNo',$employeeNo, PDO::PARAM_STR);
                    $query->execute();
                    $results=$query->FetchAll(PDO::FETCH_OBJ);
                    $cnt=1;
                    if($query->rowCount() > 0)
                    {
                        foreach($results as $result)
                        {				?>
                            <div class="form-group">
                                <label class="col-sm-4 control-label"> Name </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="name" id="name" value="<?php echo htmlentities($result->FullName);?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label"> Employee No </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="employeeNo" id="employeeNo" value="<?php echo htmlentities($result->EmployeeNo);?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label"> Position </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="position" id="position" value="<?php echo htmlentities($result->Position);?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label"> Department </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="department" id="department" value="<?php echo htmlentities($result->Department);?>" required>
                                </div>
                            </div>

                        <?php }} ?>
                        <div class="hr-dashed"></div>
                        <div class="form-group">
                        <div class="col-sm-8 col-sm-offset-4">
                            <button class="btn btn-primary" name="submit" type="submit">Update</button>
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