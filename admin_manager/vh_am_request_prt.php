<?php
error_reporting(1);

$db = new DBConnection;

session_start();

if (isset($_GET['bookingId'])) {
    $bookingId = $_GET['bookingId'];

    $result = mysql_query('SELECT tblusers.FullName, tblusers.EmployeeNo, manager.manager, position.position, department.department, company.company, tbl_vbooking.VehiclesType,
                tbl_vbooking.bookingId as bid, DATE_FORMAT(tbl_vbooking.FromDate, "%d-%m-%Y") as FromDate, DATE_FORMAT(tbl_vbooking.ToDate, "%d-%m-%Y") as ToDate,
                 TIME_FORMAT(tbl_vbooking.DepartTime, "%h:%i %p") as DepartTime, TIME_FORMAT(tbl_vbooking.ReturnTime, "%h:%i %p") as ReturnTime, tbl_vbooking.Pax, tbl_vbooking.Passengers,
                tbl_vbooking.Requisition, tbl_vbooking.Destination, tbl_vbooking.Status, tbl_vbooking.Remark, tbl_vbooking.DriverName, tbl_vbooking.VehiclesPlateNo, tbl_vbooking.VehiclesBrand, tbl_vbooking.Issuance, tbl_vbooking.FuelCard, 
                tbl_vbooking.PostingDate, tbl_vbooking.DriverEmployeeNo, tbl_vbooking.DriverPosition, tbl_vbooking.DriverDepartment, DATE_FORMAT(tbl_vbooking.expiredLicense, "%d-%m-%Y") as expiredLicense
                FROM tbl_vbooking, tblusers, department, company, position, manager
                WHERE manager.ManagerNo = tblusers.Manager AND position.pstId = tblusers.Position AND tblusers.EmployeeNo = tbl_vbooking.UserEmployeeNo AND department.dpmtCode = tblusers.Department AND company.cmpCode = tblusers.Company
                AND bookingId = ' . $bookingId . '');

    if (mysql_num_rows($result) > 0) {
        // output data of each row
        $row = mysql_fetch_assoc($result);
        $bookingId = $row['bookingId'];
        $FullName = $row['FullName'];
        $EmployeeNo = $row['EmployeeNo'];
        $position = $row['position'];
        $manager = $row['manager'];
        $department = $row['department'];
        $company = $row['company'];
        $Requisition = $row['Requisition'];
        $Destination = $row['Destination'];
        $FromDate = $row['FromDate'];
        $ToDate = $row['ToDate'];
        $DepartTime = $row['DepartTime'];
        $ReturnTime = $row['ReturnTime'];
        $Pax = $row['Pax'];
        $Passengers = $row['Passengers'];
        $VehiclesType = $row['VehiclesType'];
        $VehiclesPlateNo = $row['VehiclesPlateNo'];
        $VehiclesBrand = $row['VehiclesBrand'];
        $DriverName = $row['DriverName'];
        $DriverEmployeeNo = $row['DriverEmployeeNo'];
        $DriverPosition = $row['DriverPosition'];
        $DriverDepartment = $row['DriverDepartment'];
        $expiredLicense = $row['expiredLicense'];
        $Issuance = $row['Issuance'];
        $FuelCard = $row['FuelCard'];
        $Remark = $row['Remark'];
        $Status = $row['Status'];
    } else {
        echo "<script>alert('No data found.');</script>";
    }
}

?>

<h2 class="page-title">Vehicle Reservation</h2>
<!-- Zero Configuration Table -->
<div class="panel panel-default">
    <div class="panel-heading">Booking Info
        <button onclick="myFunction()" style="margin-left: 82%;">Print this page</button>
        <script>
            function myFunction() {
                window.print();
            }
        </script>
    </div>
    <div class="panel-body">
        <!--**************************************************************************************************************************-->
        <form method="post" class="form-horizontal" enctype="multipart/form-data" >
            <div class="form-group">
                <label class="col-sm-2 control-label">Name: <span style="color:red">*</span></label>
                <div class="col-sm-4">
                    <?php echo$row['FullName'];?>
                </div>

                <label class="col-sm-2 control-label">Employee No: <span style="color:red">*</span></label>
                <div class="col-sm-4">
                    <?php echo$row['EmployeeNo'];?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Position: <span style="color:red">*</span></label>
                <div class="col-sm-4">
                    <?php echo$row['position'];?>
                </div>

                <label class="col-sm-2 control-label">Manager: <span style="color:red">*</span></label>
                <div class="col-sm-4">
                    <?php echo$row['manager'];?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Department: <span style="color:red">*</span></label>
                <div class="col-sm-4">
                    <?php echo$row['department'];?>
                </div>

                <label class="col-sm-2 control-label">Company: <span style="color:red">*</span></label>
                <div class="col-sm-4">
                    <?php echo$row['company'];?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">From Date: <span style="color:red">*</span></label>
                <div class="col-sm-4">
                    <?php echo$row['FromDate'];?>
                </div>

                <label class="col-sm-2 control-label">To Date: <span style="color:red">*</span></label>
                <div class="col-sm-4">
                    <?php echo$row['ToDate'];?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Depart Time: <span style="color:red">*</span></label>
                <div class="col-sm-4">
                    <?php echo$row['DepartTime'];?>
                </div>

                <label class="col-sm-2 control-label">Return Time: <span style="color:red">*</span></label>
                <div class="col-sm-4">
                    <?php echo$row['ReturnTime'];?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Purpose: <span style="color:red">*</span></label>
                <div class="col-sm-4">
                    <?php echo$row['Requisition'];?>
                </div>

                <label class="col-sm-2 control-label">Destination: <span style="color:red">*</span></label>
                <div class="col-sm-4">
                    <?php echo$row['Destination'];?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Vehicle Type: <span style="color:red">*</span></label>
                <div class="col-sm-4">
                    <?php echo$row['VehiclesType'];?>
                </div>

                <label class="col-sm-2 control-label">Pax: <span style="color:red">*</span></label>
                <div class="col-sm-4">
                    <?php echo$row['Pax'];?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Driver Name: <span style="color:red">*</span></label>
                <div class="col-sm-4">
                    <?php echo$row['DriverName'];?>
                </div>

                <label class="col-sm-2 control-label">Driver Employee No: <span style="color:red">*</span></label>
                <div class="col-sm-4">
                    <?php echo$row['DriverEmployeeNo'];?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Driver Position: <span style="color:red">*</span></label>
                <div class="col-sm-4">
                    <?php echo$row['DriverPosition'];?>
                </div>

                <label class="col-sm-2 control-label">Driver Department: <span style="color:red">*</span></label>
                <div class="col-sm-4">
                    <?php echo$row['DriverDepartment'];?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Driver License Date Expired: <span style="color:red">*</span></label>
                <div class="col-sm-4">
                    <?php echo$row['expiredLicense'];?>
                </div>

                <label class="col-sm-2 control-label">Passengers: <span style="color:red">*</span></label>
                <div class="col-sm-4">
                    <?php echo$row['Passengers'];?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Status: <span style="color:red">*</span></label>
                <div class="col-sm-4">
                    <?php if($row["Status"] == '5') { ?>
                        <div>
                            <p style="color:blue;"><b>APPROVED</b></p>
                        </div>
                    <?php } else { ?>
                        <div>
                            <p style="color:red;"><b>REJECTED</b></p>
                        </div>
                    <?php } ?>
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
</div>

<!-- Loading Scripts -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap-select.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>
<script src="js/Chart.min.js"></script>
<script src="js/fileinput.js"></script>
<script src="js/chartData.js"></script>
<script src="js/main.js"></script>

</body>
</html>
