<?php
error_reporting(1);

$db = new DBConnection;

session_start();

if (isset($_GET['bookingId'])) {
$bookingId = $_GET['bookingId'];

    $result = mysql_query('SELECT tblusers.FullName, tblusers.EmployeeNo, tbl_vbooking.bookingId, tbl_vbooking.FromDate, tbl_vbooking.ToDate, 
                   tbl_vbooking.DepartTime, tbl_vbooking.ReturnTime, tbl_vbooking.VehiclesType, tbl_vbooking.Pax, tbl_vbooking.Requisition,
                   tbl_vbooking.Destination, tbl_vbooking.PostingDate, tbl_vbooking.DriverName, tbl_vbooking.Status
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
        $DriverName = $row['DriverName'];
        $Status = $row['Status'];

    } else {
        echo "<script>alert('No data found.');</script>";
    }
}

if (isset($_POST['submit'])) {

    $Issuance = "";
    if (isset($_POST["Issuance"]) && is_array($_POST["Issuance"])) {
        $Issuance = implode(", ", $_POST["Issuance"]);
    }
    $bookingId = $_GET['bookingId'];
    $Issuances = $Issuance;
    $Remark = $_POST['Remark'];
    $card = $_POST['card'];
    $Status = $_POST['Status'];
    $StatusA = $_POST['StatusA'];
    $DepartTime = $_POST['DepartTime'];
    $ReturnTime = $_POST['ReturnTime'];
    $plateNo = $_POST['plateNo'];
    $brand = $_POST['brand'];
    $DriverName = strtoupper($_POST['DriverName']);

    $sql = "UPDATE tbl_vbooking SET DriverName = '$DriverName', Issuance = '$Issuances', Remark = '$Remark', FuelCard = '$card', modifiedDateA = current_timestamp, Status = '$Status', StatusA = '$StatusA', DepartTime = '$DepartTime', ReturnTime = '$ReturnTime', VehiclesBrand = '$brand', VehiclesPlateNo = '$plateNo'
            WHERE bookingId = '$bookingId'";
    if ($rst = mysql_query($sql)) {
        echo "<script>alert('The reservation is approved successful.');</script>";
        notifyEmailAM($EmployeeNo, $Status, $bookingId); 
        { redirect('?a=vh_reservation_list'); }
    } else {
        echo "<script>alert('Please try again.');</script>";
    }
}
?>
<h2 class="page-title">Approve Reservation</h2>
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
                            <input name="VehiclesType" type="textfield" value="<?php echo $row["VehiclesType"]?>" class="form-control" disabled>
                        </div>

                        <label class="col-sm-2 control-label">Select Brand: <span style="color:red"> *</span></label>
                        <div class="col-sm-4">
                            <select  onChange="getplateNo(this.value);"  id="brand" name="brand" class="form-control" required>
                                <option value="" >Select Brand</option>
                                <?php
                                $sql = "SELECT brandId, VehiclesBrand FROM tblmastervehicles WHERE status = 'Active' GROUP BY VehiclesBrand ASC";
                                $radmin = mysql_query($sql);

                                while ( ( $rowAdm = mysql_fetch_array($radmin) ) != false ) {
                                    ?>
                                    <option  value="<?php echo $rowAdm['VehiclesBrand']; ?>">
                                        <?php echo $rowAdm['VehiclesBrand'];  ?></option>

                                <?php } // close while ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Name: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <input name="FullName" type="textfield" value="<?php echo $row["FullName"]?>" class="form-control" disabled>
                        </div>

                        <label class="col-sm-2 control-label">Plate No: <span style="color:red"> *</span></label>
                        <div class="col-sm-4">
                            <select name="plateNo" id="plateNo-list" class="form-control">
                                <option value=""></option>
                            </select>
                            <script>
                                function getplateNo(val) {
                                    $.ajax({
                                        type: "POST",
                                        url: "vh_get_plateNo.php",
                                        data:'brand_id='+val,
                                        success: function(data){
                                            $("#plateNo-list").html(data);
                                        }
                                    });
                                }
                                function selectBrand(val) {
                                    $("#search-box").val(val);
                                    $("#suggesstion-box").hide();
                                }
                            </script>
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
                            <input name="DepartTime" type="time" value="<?php echo $row["DepartTime"]?>" class="form-control" required>
                        </div>

                        <label class="col-sm-2 control-label">End Time: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <input name="ReturnTime" type="time" value="<?php echo $row["ReturnTime"]?>" class="form-control" required>
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
                        <label class="col-sm-2 control-label">Fuel Card: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <select name="card" class="form-control" required>
                                <option value="" selected="selected">Select Fuel Card</option></br>
                                <option value="CBM4102">CBM4102</option></br>
                                <option value="TTB712">TTB712</option></br>
                                <option value="TTB713">TTB713</option></br>
                                <option value="TTB714">TTB714</option></br>
                                <option value="TTB715">TTB715</option></br>
                                <option value="WQP2691">WQP2691</option></br>
                                <option value="WXU9409">WXU9409</option></br>
                            </select>
                        </div>

                        <label class="col-sm-2 control-label">Driver Name: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <input name="DriverName" type="textfield" value="<?php echo $row["DriverName"]?>" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Property Issuance: <span style="color:red">*</span></label>
                            <div class="checkbox checkbox-inline">
                                <input type="checkbox" id="car" name="Issuance[]"  value="car">
                                <label for="car"> Car/Mpv </label>

                                &emsp;&emsp;<input type="checkbox" id="logbook" name="Issuance[]"  value="logbook">
                                <label for="logbook"> Logbook </label>

                                &emsp;&emsp;<input type="checkbox" id="key" name="Issuance[]"  value="key">
                                <label for="key"> Key </label>
                            </div>
                    </div>

                    <div class="form-group" hidden>
                        <label class="col-sm-2 control-label" >Status: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <input name="Status" type="textfield" value="3" class="form-control">
                            <input name="StatusA" type="textfield" value="3" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-8 col-sm-offset-2" align="center">
                            </br><button class="btn btn-primary" name="submit" type="submit" value="submit" style="width: 90px; height: 45px; font-size: 15px;">Save</button>
                            <button class="btn btn-primary" name="reject" id="myBtn" type="submit" value="reject" style="width: 90px; height: 45px; font-size: 15px;" onclick="href='?a=vh_manage_booking_reject&bookingId=<?php echo htmlentities($result->bid);?>'">Reject</button>
                            <script>
                                var btn = document.getElementById('myBtn');
                                btn.addEventListener('click', function() {
                                    document.location.href = '?a=vh_manage_booking_reject&bookingId=<?php echo $row['bookingId'];?>';
                                });
                            </script>
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
