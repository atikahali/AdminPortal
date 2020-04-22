<?php
error_reporting(1);

$db = new DBConnection;

session_start();

?>
<h2 class="page-title">Admin e-Booking</h2>
<div class="row">
<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">Dashboard</div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-body bk-blue text-light">
                            <div class="stat-panel text-center">
                                <?php
                                $sql4 = "SELECT tblusers.FullName, tblusers.EmployeeNo, department.department, company.company, tbl_vbooking.VehiclesType,
                                tbl_vbooking.bookingId as bid, DATE_FORMAT(tbl_vbooking.FromDate, '%d-%m-%Y') as FromDate, DATE_FORMAT(tbl_vbooking.ToDate, '%d-%m-%Y') as ToDate,
                                 TIME_FORMAT(tbl_vbooking.DepartTime,'%h:%i %p') as DepartTime, TIME_FORMAT(tbl_vbooking.ReturnTime,'%h:%i %p') as ReturnTime, tbl_vbooking.Pax, tbl_vbooking.Passengers,
                                tbl_vbooking.Requisition, tbl_vbooking.Destination, tbl_vbooking.Status, tbl_vbooking.DriverName, tbl_vbooking.VehiclesPlateNo, tbl_vbooking.VehiclesBrand, 
                                tbl_vbooking.PostingDate, tbl_vbooking.DriverEmployeeNo, tbl_vbooking.DriverDepartment, DATE_FORMAT(tbl_vbooking.expiredLicense, '%d-%m-%Y') as expiredLicense
                                FROM tbl_vbooking, tblusers, department, company 
                                WHERE tblusers.EmployeeNo = tbl_vbooking.UserEmployeeNo AND department.dpmtCode = tblusers.Department AND company.cmpCode = tblusers.Company AND tbl_vbooking.Status = '3'
                                ORDER BY tbl_vbooking.FromDate DESC";
                                $result4 = mysql_query($sql4);
                                ?>
                                <div class="stat-panel-number h1 "><?php echo mysql_num_rows($result4);?></div>
                                <div class="stat-panel-title text-uppercase">Total Reservation</div>
                            </div>
                        </div>
                        <a href="?am=vh_am_request" class="block-anchor panel-footer text-center">Full Detail &nbsp; <i class="fa fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
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
<?php /*}*/ ?>