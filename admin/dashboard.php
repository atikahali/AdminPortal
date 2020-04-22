<?php
error_reporting(1);

$db = new DBConnection;

session_start();

?>
<h2 class="page-title">Admin e-Booking</h2>
<div class="row">
<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">Meeting Room</div>
        <div class="panel-body">
            <div class="row">
                <!--Total Meeting Room Reservation-->
                <div class="col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-body bk-primary text-light">
                            <div class="stat-panel text-center">
                                <?php
                                    $sql1 = "SELECT id FROM tbl_mbooking_r WHERE tbl_mbooking_r.dateStart >= CURDATE() OR tbl_mbooking_r.dateEnd >= CURDATE() AND status = 'Booked'";
                                    $result1 = mysql_query($sql1);
                                ?>
                                <div class="stat-panel-number h1 "><?php echo mysql_num_rows($result1);?></div>
                                <div class="stat-panel-title text-uppercase">Total Reservation</div>
                            </div>
                        </div>
                        <a href="?a=mt_meeting_list" class="block-anchor panel-footer text-center">Full Detail <i class="fa fa-arrow-right"></i></a>
                    </div>
                </div>
                <!--Total Drink List-->
                <div class="col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-body bk-success text-light">
                            <div class="stat-panel text-center">
                                <?php
                                    $sql2 = "SELECT drink FROM tbl_mbooking_r WHERE dateStart >= CURDATE() AND status = 'Booked' AND NOT drink = 'None'";
                                    $result2 = mysql_query($sql2);

                                ?>
                                <div class="stat-panel-number h1 "><?php echo mysql_num_rows($result2);?></div>
                                <div class="stat-panel-title text-uppercase">Drinks List</div>
                            </div>
                        </div>
                        <a href="?a=mt_drink_list" class="block-anchor panel-footer text-center">Full Detail &nbsp; <i class="fa fa-arrow-right"></i></a>
                    </div>
                </div>
                <!--List Meeting Room-->
                <div class="col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-body bk-info text-light">
                            <div class="stat-panel text-center">
                                <?php
                                    $sql3 = "SELECT roomId from tblroom";
                                    $result3 = mysql_query($sql3);
                                ?>
                                <div class="stat-panel-number h1 "><?php echo mysql_num_rows($result3);?></div>
                                <div class="stat-panel-title text-uppercase">Meeting Room List</div>
                            </div>
                        </div>
                        <a href="?a=mt_manage_room" class="block-anchor panel-footer text-center">Full Detail &nbsp; <i class="fa fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="row">
<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">Vehicle</div>
        <div class="panel-body">
            <div class="row">
                <!--Total Vehicle Reservation-->
                <div class="col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-body bk-primary text-light">
                            <div class="stat-panel text-center">
                                <?php
                                $sql4 = "SELECT tblusers.FullName, tblusers.EmployeeNo, department.department, company.company, tbl_vbooking.VehiclesType,
                                tbl_vbooking.bookingId as bid, DATE_FORMAT(tbl_vbooking.FromDate, '%d-%m-%Y') as FromDate, DATE_FORMAT(tbl_vbooking.ToDate, '%d-%m-%Y') as ToDate,
                                 TIME_FORMAT(tbl_vbooking.DepartTime,'%h:%i %p') as DepartTime, TIME_FORMAT(tbl_vbooking.ReturnTime,'%h:%i %p') as ReturnTime, tbl_vbooking.Pax, tbl_vbooking.Passengers,
                                tbl_vbooking.Requisition, tbl_vbooking.Destination, tbl_vbooking.Status, tbl_vbooking.DriverName, tbl_vbooking.VehiclesPlateNo, tbl_vbooking.VehiclesBrand, 
                                tbl_vbooking.PostingDate, tbl_vbooking.DriverEmployeeNo, tbl_vbooking.DriverDepartment, DATE_FORMAT(tbl_vbooking.expiredLicense, '%d-%m-%Y') as expiredLicense
                                FROM tbl_vbooking, tblusers, department, company 
                                WHERE tblusers.EmployeeNo = tbl_vbooking.UserEmployeeNo AND department.dpmtCode = tblusers.Department AND company.cmpCode = tblusers.Company AND tbl_vbooking.Status = '1'
                                ORDER BY tbl_vbooking.FromDate DESC";
                                $result4 = mysql_query($sql4);
                                ?>
                                <div class="stat-panel-number h1 "><?php echo mysql_num_rows($result4);?></div>
                                <div class="stat-panel-title text-uppercase">Total Reservation</div>
                            </div>
                        </div>
                        <a href="?a=vh_manage_booking" class="block-anchor panel-footer text-center">Full Detail &nbsp; <i class="fa fa-arrow-right"></i></a>
                    </div>
                </div>
                <!--Vehicle List-->
                <div class="col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-body bk-success text-light">
                            <div class="stat-panel text-center">
                                <?php
                                $sql5 = "SELECT vehicleId from tblmastervehicles ";
                                $result5 = mysql_query($sql5);

                                ?>
                                <div class="stat-panel-number h1 "><?php echo mysql_num_rows($result5);?></div>
                                <div class="stat-panel-title text-uppercase">Vehicles List</div>
                            </div>
                        </div>
                        <a href="?a=vh_manage_vehicles" class="block-anchor panel-footer text-center">Full Detail &nbsp; <i class="fa fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="row">
<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">Setting</div>
        <div class="panel-body">
            <div class="row">
                <!--Total User-->
                <div class="col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-body bk-primary text-light">
                            <div class="stat-panel text-center">
                                <?php
                                $sql6 = "SELECT id from tblusers";
                                $result6 = mysql_query($sql6);
                                ?>
                                <div class="stat-panel-number h1 "><?php echo mysql_num_rows($result6);?></div>
                                <div class="stat-panel-title text-uppercase">Total User</div>
                            </div>
                        </div>
                        <a href="?a=setting_users" class="block-anchor panel-footer text-center">Full Detail <i class="fa fa-arrow-right"></i></a>
                    </div>
                </div>
                <!--Total Position-->
                <div class="col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-body bk-success text-light">
                            <div class="stat-panel text-center">
                                <?php
                                $sql7 = "SELECT pstId from position ";
                                $result7 = mysql_query($sql7);
                                ?>
                                <div class="stat-panel-number h1 "><?php echo mysql_num_rows($result7);?></div>
                                <div class="stat-panel-title text-uppercase">Total Position</div>
                            </div>
                        </div>
                        <a href="?a=setting_position" class="block-anchor panel-footer text-center">Full Detail <i class="fa fa-arrow-right"></i></a>
                    </div>
                </div>
                <!--Total Manager-->
                <div class="col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-body bk-info text-light">
                            <div class="stat-panel text-center">
                                <?php
                                $sql8 = "SELECT id from manager";
                                $result8 = mysql_query($sql8);
                                ?>
                                <div class="stat-panel-number h1 "><?php echo mysql_num_rows($result8);?></div>
                                <div class="stat-panel-title text-uppercase">Total Manager</div>
                            </div>
                        </div>
                        <a href="?a=setting_manager" class="block-anchor panel-footer text-center">Full Detail <i class="fa fa-arrow-right"></i></a>
                    </div>
                </div>
                <!--Total Department-->
                <div class="col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-body bk-warning text-light">
                            <div class="stat-panel text-center">
                                <?php
                                $sql9 = "SELECT dpmtId from department";
                                $result9 = mysql_query($sql9);
                                ?>
                                <div class="stat-panel-number h1 "><?php echo mysql_num_rows($result9);?></div>
                                <div class="stat-panel-title text-uppercase">Total Department</div>
                            </div>
                        </div>
                        <a href="?a=setting_department" class="block-anchor panel-footer text-center">Full Detail <i class="fa fa-arrow-right"></i></a>
                    </div>
                </div>
                <!--Total Company-->
                <div class="col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-body bk-danger text-light">
                            <div class="stat-panel text-center">
                                <?php
                                $sql10 = "SELECT cmpId from company";
                                $result10 = mysql_query($sql10);
                                ?>
                                <div class="stat-panel-number h1 "><?php echo mysql_num_rows($result10);?></div>
                                <div class="stat-panel-title text-uppercase">Total Company</div>
                            </div>
                        </div>
                        <a href="?a=setting_company" class="block-anchor panel-footer text-center">Full Detail <i class="fa fa-arrow-right"></i></a>
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