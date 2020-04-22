<?php
error_reporting(1);

$db = new DBConnection;

session_start();

function generateId($tablename = '',$field = '',$str = ''){

    $db=new DBConnection();

    $codelen = strlen($str);  // length of first code - CH

    /* Find the latest ID */
    $sql='SELECT '.$field.' FROM '.$tablename.' WHERE SUBSTRING('.$field.',1,'.$codelen.') = "'.$str.'" 
	      ORDER BY '.$field.' DESC LIMIT 0,1';
    $result = $db -> query($sql);
    $row = $db -> num_rows($result);

    if($row !=0 ){
        $rows = $db -> fetch($result);
        $newcode = trim($rows['dpmtCode'],"D");
    }

    $newcode++;
    $newid = $str . $newcode;

    return $newid;
}

if (isset($_POST['submit'])) {

    $dpmtId = $_GET['dpmtId'];
    $department = $_POST['department'];
    $dpmtStatus = $_POST['dpmtStatus'];
    $createdDate = $_POST['createdDate'];
    $createdBy = $_POST['createdBy'];
    $timestamp = date("Y-m-d H:i:s");


    $dpmtCode = generateId($tablename = 'department',$field = 'dpmtCode',$str = 'D');

    $sql = "INSERT INTO department (dpmtCode, department, dpmtStatus, createdBy, createdDate) VALUES ('$dpmtCode', '$department', '$dpmtStatus', '" . $_SESSION['Alogin'] . "', '".$timestamp."')";
    if ($rst = mysql_query($sql)) {
        echo "<script>alert('Department is added successfully.');</script>";
        { redirect('?a=setting_department'); }
    } else {
        echo "<script>alert('Please try again.');</script>";
    }
}
?>

<h2 class="page-title">Add Department</h2>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">Form field</div>
            <!--**************************************************************************************************************************-->
            <div class="panel-body">
                <!--**************************************************************************************************************************-->
                <form method="post" class="form-horizontal" enctype="multipart/form-data" >
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Department: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <input name="department" type="textfield" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Status: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <select name="dpmtStatus" class="form-control" required>
                                <option value="" selected="selected"></option></br>
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