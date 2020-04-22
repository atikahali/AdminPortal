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
                    <!--Meeting Room-->
                    <div class="col-md-3">
                        <div class="panel panel-default">
                            <div class="panel-body bk-primary text-light">
                                <div class="stat-panel text-center">
                                    <div><h4>Meeting Room</h4></div>
                                    <?php
                                    $sql1 = "SELECT tblusers.FullName, tblusers.Department, tbl_mbooking_r.requestDate, tbl_mbooking_r.purpose, 
                                            tbl_mbooking_r.dateStart, tbl_mbooking_r.dateEnd, tbl_mbooking_r.timeStart, tbl_mbooking_r.timeEnd, tblroom.description, 
                                            tbl_mbooking_r.drink, tbl_mbooking_r.pax, tbl_mbooking_r.status
                                        FROM tblusers, tbl_mbooking_r, tblroom
                                        WHERE tblusers.EmployeeNo = tbl_mbooking_r.EmployeeNo AND tblroom.roomId = tbl_mbooking_r.room AND (tbl_mbooking_r.dateStart = CURDATE() OR tbl_mbooking_r.dateEnd >= CURDATE()) AND tbl_mbooking_r.status = 'Booked'";
                                    $result1 = mysql_query($sql1);
                                    ?>
                                    <div class="stat-panel-number h1 "><?php echo mysql_num_rows($result1);?></div>
                                    <div class="stat-panel-title text-uppercase">Total Reservations</div>
                                </div>
                            </div>
                            <a href="?p=mt_view" class="block-anchor panel-footer text-center">Full Detail <i class="fa fa-arrow-right"></i></a>
                            <a href="?p=mt_req_form" class="block-anchor panel-footer text-center"><i class="fa fa-arrow-left"></i> &nbsp;Apply Now</a>
                        </div>
                    </div>

                    <!--Vehicle-->
                    <div class="col-md-3">
                        <div class="panel panel-default">
                            <div class="panel-body bk-success text-light">
                                <div class="stat-panel text-center">
                                    <div><h4>Vehicle</h4></div>
                                    <?php
                                    $sql2 = "SELECT tblusers.FullName, tblusers.EmployeeNo, department.department, company.company, tbl_vbooking.VehiclesType,
                                    tbl_vbooking.bookingId, tbl_vbooking.FromDate, tbl_vbooking.ToDate,
                                     tbl_vbooking.DepartTime, tbl_vbooking.ReturnTime, tbl_vbooking.Pax, tbl_vbooking.Passengers,
                                    tbl_vbooking.Requisition, tbl_vbooking.Status,  tbl_vbooking.VehiclesPlateNo, tbl_vbooking.VehiclesBrand, tbl_vbooking.PostingDate
                                    FROM tbl_vbooking, tblusers, department, company 
                                    WHERE tblusers.EmployeeNo = tbl_vbooking.UserEmployeeNo AND department.dpmtCode = tblusers.Department AND company.cmpCode = tblusers.Company 
                                    AND tbl_vbooking.ToDate >= CURDATE() AND (tbl_vbooking.Status ='0' OR tbl_vbooking.Status ='1' OR tbl_vbooking.Status ='3' OR tbl_vbooking.Status ='5')";
                                    $result2 = mysql_query($sql2);

                                    ?>
                                    <div class="stat-panel-number h1 "><?php echo mysql_num_rows($result2);?></div>
                                    <div class="stat-panel-title text-uppercase">Total Reservations</div>
                                </div>
                            </div>
                            <a href="?p=vh_view" class="block-anchor panel-footer text-center">Full Detail &nbsp; <i class="fa fa-arrow-right"></i></a>
                            <a href="?p=vh_req_form" class="block-anchor panel-footer text-center"><i class="fa fa-arrow-left"></i> &nbsp;Apply Now</a>
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