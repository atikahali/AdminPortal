<?php
error_reporting(1);

$db = new DBConnection;

session_start();

if (isset($_GET['vehicleId'])) {
    $vehicleId = $_GET['vehicleId'];

    $result = mysql_query('SELECT vehicleId, VehiclesType, VehiclesBrand, VehiclesPlateNo, ModelYear, SeatingCapacity, Status FROM tblmastervehicles WHERE vehicleId = ' . $vehicleId . '');

    if (mysql_num_rows($result) > 0) {
        // output data of each row
        $row = mysql_fetch_assoc($result);
        $vehicleId = $row['vehicleId'];
        $VehiclesType = $row['VehiclesType'];
        $VehiclesBrand = $row['VehiclesBrand'];
        $VehiclesPlateNo = $row['VehiclesPlateNo'];
        $ModelYear = $row['ModelYear'];
        $SeatingCapacity = $row['SeatingCapacity'];
        $Status = $row['Status'];
    } else {
        echo "<script>alert('No data found.');</script>";
    }
}

if (isset($_POST['submit'])) {

    $vehicleId = $_GET['vehicleId'];
    $VehiclesType = $_POST['VehiclesType'];
    $VehiclesBrand = $_POST['VehiclesBrand'];
    $VehiclesPlateNo = $_POST['VehiclesPlateNo'];
    $ModelYear = $_POST['ModelYear'];
    $SeatingCapacity = $_POST['SeatingCapacity'];
    $Status = $_POST['Status'];

    $sql = "DELETE FROM tblmastervehicles WHERE vehicleId = '$vehicleId'";
    if ($rst = mysql_query($sql)) {
        echo "<script>alert('The vehicle is deleted successful.');</script>";
        { redirect('?a=vh_manage_vehicles'); }
    } else {
        echo "<script>alert('Please try again.');</script>";
    }
}
?>
<h2 class="page-title">Delete Vehicle</h2>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">Form field</div>
            <!--**************************************************************************************************************************-->
            <div class="panel-body">
                <!--**************************************************************************************************************************-->
                <form method="post" class="form-horizontal" enctype="multipart/form-data" >
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Vehicle Type: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <select id="VehiclesType" name="VehiclesType" class="form-control" disabled>
                                <option value="" selected="selected"><?php echo $row["VehiclesType"]?></option></br>
                                <option value="Sedan">Sedan</option></br>
                                <option value="Mpv">Mpv</option></br>
                                <option value="Pickup truck">Pickup truck</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Vehicle Brand: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <input name="VehiclesBrand" type="textfield" value="<?php echo $row["VehiclesBrand"]?>" id="VehiclesBrand" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Vehicle Plate No: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <input name="VehiclesPlateNo" type="textfield" value="<?php echo $row["VehiclesPlateNo"]?>" id="VehiclesPlateNo" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Model Year: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <input name="ModelYear" type="textfield" value="<?php echo $row["ModelYear"]?>" id="ModelYear" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Seating capacity: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <input name="SeatingCapacity" type="textfield" value="<?php echo $row["SeatingCapacity"]?>" id="SeatingCapacity" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Status: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <select id="Status" name="Status" class="form-control" disabled>
                                <option value="" selected="selected"><?php echo $row["Status"]?></option></br>
                                <option value="Active">Active</option></br>
                                <option value="Inactive">Inactive</option></br>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-8 col-sm-offset-2">
                            <button class="btn btn-primary" name="submit" type="submit" value="submit" style="width: 90px; height: 45px; font-size: 15px;">Delete</button>
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