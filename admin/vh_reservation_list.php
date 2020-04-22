<?php
error_reporting(1);

$db = new DBConnection;

session_start();

?>

<h2 class="page-title">Reservation List</h2>
<div class="panel panel-default">
    <div class="panel-heading">Booking Info
        <button onclick="myFunction()" style="margin-left: 80%;">Print this page</button>
        <script>
            function myFunction() {
                window.print();
            }
        </script>
    </div>
    <div class="panel-body">
        <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Destination</th>
                <th>Vehicle Plate No</th>
                <th>Depart Date</th>
                <th>Depart Time</th>
                <th>Return Date</th>
                <th>Return Time</th>
                <th>Driver Name</th>
                <th>Pax</th>
                <th>Details</th>
                <th>Status</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Destination</th>
                <th>Vehicle Plate No</th>
                <th>Depart Date</th>
                <th>Depart Time</th>
                <th>Return Date</th>
                <th>Return Time</th>
                <th>Driver Name</th>
                <th>Pax</th>
                <th>Details</th>
                <th>Status</th>
            </tr>
            </tfoot>
            <tbody>
            <?php
            $servername = "localhost";
            $username = "adminportal";
            $password = "admin123";
            $dbname = "adminportal";

            $sql = "SELECT tblusers.FullName, tblusers.EmployeeNo, manager.manager, position.position, department.department, company.company, tbl_vbooking.VehiclesType,
                tbl_vbooking.bookingId as bid, DATE_FORMAT(tbl_vbooking.FromDate, '%d-%m-%Y') as FromDate, DATE_FORMAT(tbl_vbooking.ToDate, '%d-%m-%Y') as ToDate,
                 TIME_FORMAT(tbl_vbooking.DepartTime,'%h:%i %p') as DepartTime, TIME_FORMAT(tbl_vbooking.ReturnTime,'%h:%i %p') as ReturnTime, tbl_vbooking.Pax, tbl_vbooking.Passengers,
                tbl_vbooking.Requisition, tbl_vbooking.Destination, tbl_vbooking.Status, tbl_vbooking.StatusA, tbl_vbooking.Remark, tbl_vbooking.DriverName, tbl_vbooking.VehiclesPlateNo, tbl_vbooking.VehiclesBrand, tbl_vbooking.Issuance, tbl_vbooking.FuelCard, 
                tbl_vbooking.PostingDate, tbl_vbooking.DriverEmployeeNo, tbl_vbooking.DriverPosition, tbl_vbooking.DriverDepartment, DATE_FORMAT(tbl_vbooking.expiredLicense, '%d-%m-%Y') as expiredLicense
                FROM tbl_vbooking, tblusers, department, company, position, manager
                WHERE manager.ManagerNo = tblusers.Manager AND position.pstId = tblusers.Position AND tblusers.EmployeeNo = tbl_vbooking.UserEmployeeNo AND department.dpmtCode = tblusers.Department AND company.cmpCode = tblusers.Company
                ORDER BY tbl_vbooking.FromDate DESC";

            $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $query = $dbh -> prepare($sql);
            $query -> bindParam(':employeeNo',$employeeNo, PDO::PARAM_STR);
            $query -> execute();
            $results = $query->FetchAll(PDO::FETCH_OBJ);
            $cnt=1;
            if($query->rowCount() > 0) {
                foreach($results as $result) {
                    if($result->Status != '0' && $result->Status != '1'){
                        if ($result->Status == '3' || $result->Status == '4'){?>
                    <tr>
                        <td><?php echo htmlentities($cnt);?></td>
                        <td><?php echo htmlentities($result->FullName);?></td>
                        <td><?php echo htmlentities($result->Destination);?></td>
                        <td><?php echo htmlentities($result->VehiclesPlateNo);?></td>
                        <td><?php echo htmlentities($result->FromDate);?></td>
                        <td><?php echo htmlentities($result->DepartTime);?></td>
                        <td><?php echo htmlentities($result->ToDate);?></td>
                        <td><?php echo htmlentities($result->ReturnTime);?></td>
                        <td><?php echo htmlentities($result->DriverName);?></td>
                        <td><?php echo htmlentities($result->Pax);?></td>
                        <td><a href="?a=vh_reservation_list_prt&bookingId=<?php echo htmlentities($result->bid);?>">Details</a></td>
                        <!--Status display -->
                        <td><?php  if($result->StatusA == '3')  { ?>
                                <div>
                                    <p style="color:blue;"><b>APPROVED</b></p>
                                </div>
                            <?php } else { ?>
                                <div>
                                    <p style="color:red;"><b>REJECTED</b></p>
                                </div>
                            <?php } ?>
                            <!--End of status-->
                        </td>
                    </tr>

                    <!--POPUP DETAILS-->
                    <div id="myModal<?php echo ($result->bid) ?>" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Details</h4>
                                </div>
                                <div class="modal-body">
                                    <h4>Name: <?php echo htmlentities($result->FullName);?></h4>
                                    <h4>Employee No: <?php echo htmlentities($result->EmployeeNo);?></h4>
                                    <h4>Position: <?php echo htmlentities($result->position);?></h4>
                                    <h4>Manager: <?php echo htmlentities($result->manager);?></h4>
                                    <h4>Department: <?php echo htmlentities($result->department);?></h4>
                                    <h4>Company: <?php echo htmlentities($result->company);?></h4>
                                    <h4>Depart Date: <?php echo htmlentities($result->FromDate);?></h4>
                                    <h4>Depart Time: <?php echo htmlentities($result->DepartTime);?></h4>
                                    <h4>Return Date: <?php echo htmlentities($result->ToDate);?></h4>
                                    <h4>Return Time: <?php echo htmlentities($result->ReturnTime);?></h4>
                                    <h4>Purpose: <?php echo htmlentities($result->Requisition);?></h4>
                                    <h4>Destination: <?php echo htmlentities($result->Destination);?></h4>
                                    <h4>Vehicle Type: <?php echo htmlentities($result->VehiclesType);?></h4>
                                    <h4>Vehicle Brand: <?php echo htmlentities($result->VehiclesBrand);?></h4>
                                    <h4>Vehicle Plate No: <?php echo htmlentities($result->VehiclesPlateNo);?></h4>
                                    <h4>Issuance: <?php echo htmlentities($result->Issuance);?></h4>
                                    <h4>Fuel Card: <?php echo htmlentities($result->FuelCard);?></h4>
                                    <h4>Pax: <?php echo htmlentities($result->Pax);?></h4>
                                    <h4>Passengers: <?php echo htmlentities($result->Passengers);?></h4>
                                    <h4>Driver Name: <?php echo htmlentities($result->DriverName);?></h4>
                                    <h4>Driver EmployeeNo: <?php echo htmlentities($result->DriverEmployeeNo);?></h4>
                                    <h4>Driver Position: <?php echo htmlentities($result->DriverPosition);?></h4>
                                    <h4>Driver Department: <?php echo htmlentities($result->DriverDepartment);?></h4>
                                    <h4>Driver License Date Expired: <?php echo htmlentities($result->expiredLicense);?></h4>
                                    <h4>Remark: <?php echo htmlentities($result->Remark);?></h4>
                                    <h4>Status: <?php  if($result->StatusA == '3')  { ?>
                                            <div>
                                                <p style="color:blue;"><b>Approved</b></p>
                                            </div>
                                        <?php } else { ?>
                                            <div>
                                                <p style="color:red;"><b>Rejected</b></p>
                                            </div>
                                        <?php } ?>
                                        <!--End of status-->
                                    </h4>

                                </div>
                                <div class="modal-footer">
                                    <button onclick="location.href = '?a=vh_reservation_list_prt&bookingId=<?php echo ($result->bid)?>';">Print this page</td>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php $cnt=$cnt+1; }}}} ?>
            </tbody>
        </table>
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