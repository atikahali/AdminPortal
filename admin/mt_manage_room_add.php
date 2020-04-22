<?php
error_reporting(1);

$db = new DBConnection;

session_start();

if (isset($_POST['submit'])) {

    $roomId = $_POST['roomId'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    $createdDate = $_POST['createdDate'];
    $createdBy = $_POST['createdBy'];
    $timestamp = date("Y-m-d H:i:s");

    $sql = "INSERT INTO tblroom (description, status, createdBy, createdDate) VALUES ('$description', '$status', '" . $_SESSION['Alogin'] . "', '".$timestamp."')";
    if ($rst = mysql_query($sql)) {
        echo "<script>alert('The room is added successfully.');</script>";
        { redirect('?a=mt_manage_room'); }
    } else {
        echo "<script>alert('Please try again.');</script>";
    }

}
?>
<h2 class="page-title">Add Room</h2>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">Form field</div>
            <!--**************************************************************************************************************************-->
            <div class="panel-body">
                <!--**************************************************************************************************************************-->
                <form method="post" class="form-horizontal" enctype="multipart/form-data" >
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Name of Room: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <input name="description" type="textfield" id="description" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Room Status: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <select id="status" name="status" class="form-control" required>
                                <option value="" selected="selected">Select</option></br>
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