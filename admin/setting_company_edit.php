<?php
error_reporting(1);

$db = new DBConnection;

session_start();

if (isset($_GET['cmpId'])) {
    $cmpId = $_GET['cmpId'];

    $result = mysql_query('SELECT cmpId, cmpCode, company, cmpStatus, modifiedBy, modifiedDate FROM company WHERE cmpId = ' . $cmpId . '');

    if (mysql_num_rows($result) > 0) {
        // output data of each row
        $row = mysql_fetch_assoc($result);
        $cmpId = $row['cmpId'];
        $cmpCode = $row['cmpCode'];
        $company = $row['company'];
        $cmpStatus = $row['cmpStatus'];
        $modifiedBy = $row['modifiedBy'];
        $modifiedDate = $row['modifiedDate'];
    } else {
        echo "<script>alert('No data found.');</script>";
    }
}

if (isset($_POST['submit'])) {

    $cmpId = $_GET['cmpId'];
    $cmpCode = strtoupper($_POST['cmpCode']);
    $company = strtoupper($_POST['company']);
    $cmpStatus = $_POST['cmpStatus'];
    $modifiedBy = $_POST['modifiedBy'];
    $modifiedDate = $_POST['modifiedDate'];
    $timestamp = date("Y-m-d H:i:s");


    $sql = "UPDATE company SET cmpCode = '$cmpCode', company = '$company', cmpStatus = '$cmpStatus', modifiedBy = '" . $_SESSION['Alogin'] . "', modifiedDate = '" . $timestamp . "' WHERE cmpId = '$cmpId'";
    if ($rst = mysql_query($sql)) {
        echo "<script>alert('Company details is edited successfully.');</script>";
        { redirect('?a=setting_company'); }
    } else {
        echo "<script>alert('Please try again.');</script>";
    }

}
?>
<h2 class="page-title">Edit Company</h2>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">Form field</div>
            <!--**************************************************************************************************************************-->
            <div class="panel-body">
                <!--**************************************************************************************************************************-->
                <form method="post" class="form-horizontal" enctype="multipart/form-data" >
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Code: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <input name="cmpCode" type="textfield" value="<?php echo $row["cmpCode"]?>" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Company: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <input name="company" type="textfield" value="<?php echo $row["company"]?>" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Status: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <select name="cmpStatus" class="form-control" required>
                                <option value="" selected="selected"><?php echo $row["cmpStatus"]?></option></br>
                                <option value="Active">Active</option></br>
                                <option value="Inactive">Inactive</option></br>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-8 col-sm-offset-2">
                            <button class="btn btn-primary" name="submit" type="submit" value="submit" style="width: 90px; height: 45px; font-size: 15px;">Save</button>
                        </div>
                    </div>
                </form>
                <!--**************************************************************************************************************************-->

                <button class="btn btn-primary" name="back" type="submit" value="back" style="font-size: 15px;" onclick="goBack()"><i class="fa fa-chevron-left" style='font-size:15px'></i> &nbsp;Back</button>
                <script>
                    function goBack() {
                        window.history.back();
                    }
                </script>
            </div>
        </div>
    </div>
</div>
<!--**************************************************************************************************************************-->
<!-- Loading Scripts -->
<script src="../js/combodate.js"></script>
<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap-select.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/jquery.dataTables.min.js"></script>
<script src="../js/dataTables.bootstrap.min.js"></script>
<script src="../js/Chart.min.js"></script>
<script src="../js/fileinput.js"></script>
<script src="../js/chartData.js"></script>
<script src="../js/main.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<!--**************************************************************************************************************************-->

</body>
</html>
