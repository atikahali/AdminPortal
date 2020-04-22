<?php
error_reporting(1);

$db = new DBConnection;

session_start();

if (isset($_GET['bookingId'])) {
    $bookingId = $_GET['bookingId'];

    $result = mysql_query('SELECT tblusers.FullName, tblusers.EmployeeNo, tbl_vbooking.bookingId, tbl_vbooking.FromDate, tbl_vbooking.ToDate, 
                   tbl_vbooking.DepartTime, tbl_vbooking.ReturnTime, tbl_vbooking.VehiclesType, tbl_vbooking.Pax, tbl_vbooking.Requisition,
                   tbl_vbooking.Destination, tbl_vbooking.PostingDate, tbl_vbooking.Status
                   FROM tblusers, tbl_vbooking
                   WHERE tblusers.EmployeeNo = tbl_vbooking.UserEmployeeNo AND bookingId = '.$bookingId.'');

    if (mysql_num_rows($result) > 0) {
        // output data of each row
        $row = mysql_fetch_assoc($result);
        $FullName = $row['FullName'];
        $EmployeeNo = $row['EmployeeNo'];
        $bookingId = $row['bookingId'];
        $FromDate = $row['FromDate'];
        $ToDate = $row['ToDate'];
        $DepartTime = $row['DepartTime'];
        $ReturnTime = $row['ReturnTime'];
        $VehiclesType = $row['VehiclesType'];
        $Pax = $row['Pax'];
        $Requisition = $row['Requisition'];
        $PostingDate = $row['PostingDate'];
        $Status = $row['Status'];

    } else {
        echo "<script>alert('No data found.');</script>";
    }
}

if (isset($_POST['submit'])) {

    $bookingId = $_GET['bookingId'];
    $Remark = $_POST['Remark'];
    $Status = $_POST['Status'];
    $StatusA = $_POST['StatusA'];

    $sql = "UPDATE tbl_vbooking SET Remark = '$Remark', modifiedDateA = current_timestamp, Status = '$Status', StatusA = '$StatusA' WHERE bookingId = '$bookingId'";
    if ($rst = mysql_query($sql)) {
        echo "<script>alert('The reservation is rejected successful.');</script>";
        notifyEmailU($EmployeeNo, $Status, $bookingId);

        { redirect('?a=vh_reservation_list'); }
    } else {
        echo "<script>alert('Please try again.');</script>";
    }
}
?>
<h2 class="page-title">Reject Reservation</h2>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">Form field</div>
            <!--**************************************************************************************************************************-->
            <div class="panel-body">
                <!--**************************************************************************************************************************-->
                <form method="post" class="form-horizontal" enctype="multipart/form-data" >
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Name: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <input name="FullName" type="textfield" value="<?php echo $row["FullName"]?>" class="form-control" disabled>
                        </div>

                        <label class="col-sm-2 control-label">Vehicle Type: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <input name="VehiclesType" type="textfield" value="<?php echo $row["VehiclesType"]?>" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Start Date: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <input name="FromDate" type="date" value="<?php echo $row["FromDate"]?>" class="form-control" disabled>
                        </div>

                        <label class="col-sm-2 control-label">End Date: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <input name="ToDate" type="date" value="<?php echo $row["ToDate"]?>" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Depart Time: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <input name="DepartTime" type="time" value="<?php echo $row["DepartTime"]?>" class="form-control" disabled>
                        </div>

                        <label class="col-sm-2 control-label">End Time: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <input name="ReturnTime" type="time" value="<?php echo $row["ReturnTime"]?>" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Purpose: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <input name="Requisition" type="textfield" value="<?php echo $row["Requisition"]?>" class="form-control" disabled>
                        </div>

                        <label class="col-sm-2 control-label">Destination: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <input name="Destination" type="textfield" value="<?php echo $row["Destination"]?>" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Remark: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <select name="Remark" class="form-control" required>
                                <option value="" selected="selected">Select Remark</option></br>
                                <option value="All Cars Already Fully Booked">All Cars Already Fully Booked</option></br>
                                <option value="Vehicle Maintenance">Vehicle Maintenance</option></br>
                            </select>
                        </div>
                    </div>

                    <div class="form-group" hidden>
                        <label class="col-sm-2 control-label" >Status: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <input name="Status" type="textfield" value="4" class="form-control">
                            <input name="StatusA" type="textfield" value="4" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-8 col-sm-offset-2" align="center">
                            </br><button class="btn btn-primary" name="submit" type="submit" value="submit" style="font-size: 15px;">Reject Reservation</button>
                        </div>
                    </div>
                </form>
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
