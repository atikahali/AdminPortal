<?php
error_reporting(1);

$db = new DBConnection;

session_start();

if(strlen($_SESSION['login']) == 0) {
    header('location:index.php');
}
?>
<h2 class="page-title">History Reservation Vehicle</h2>
<div class="panel panel-default">
    <div class="panel-heading">Booking Info</div>
    <div class="panel-body">
        <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>No</th>
                <th>Purpose</th>
                <th>Destination</th>
                <th>Depart Date</th>
                <th>Depart Time</th>
                <th>Return Date</th>
                <th>Return Time</th>
                <th>Vehicle</th>
                <th>Details</th>
                <th>Status</th>
                <th>Remark</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>No</th>
                <th>Purpose</th>
                <th>Destination</th>
                <th>Depart Date</th>
                <th>Depart Time</th>
                <th>Return Date</th>
                <th>Return Time</th>
                <th>Vehicle</th>
                <th>Details</th>
                <th>Status</th>
                <th>Remark</th>
            </tr>
            </tfoot>
            <tbody>
            <?php
            $servername = "localhost";
            $username = "adminportal";
            $password = "admin123";
            $dbname = "adminportal";

            $sql = "SELECT tblusers.FullName, tblusers.EmployeeNo, tbl_vbooking.VehiclesType, tbl_vbooking.PostingDate,
                tbl_vbooking.bookingId as bid, DATE_FORMAT(tbl_vbooking.FromDate, '%d-%m-%Y') as FromDate, DATE_FORMAT(tbl_vbooking.ToDate, '%d-%m-%Y') as ToDate,
                 TIME_FORMAT(tbl_vbooking.DepartTime,'%h:%i %p') as DepartTime, TIME_FORMAT(tbl_vbooking.ReturnTime,'%h:%i %p') as ReturnTime, tbl_vbooking.Pax, tbl_vbooking.Passengers,
                tbl_vbooking.Requisition, tbl_vbooking.Destination, tbl_vbooking.Status, tbl_vbooking.DriverName, tbl_vbooking.VehiclesPlateNo, tbl_vbooking.VehiclesBrand, tbl_vbooking.Remark
                FROM tbl_vbooking, tblusers WHERE tblusers.EmployeeNo = tbl_vbooking.UserEmployeeNo 
                AND tblusers.EmployeeNo = '".$_SESSION['login']."' ORDER BY tbl_vbooking.PostingDate DESC";

            $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $query = $dbh -> prepare($sql);
            $query -> bindParam(':employeeNo',$employeeNo, PDO::PARAM_STR);
            $query -> execute();
            $results = $query->FetchAll(PDO::FETCH_OBJ);
            $cnt=1;
            if($query->rowCount() > 0) {
                foreach($results as $result) { ?>

                    <tr>
                        <td><?php echo htmlentities($cnt);?></td>
                        <td><?php echo htmlentities($result->Requisition);?></td>
                        <td><?php echo htmlentities($result->Destination);?></td>
                        <td><?php echo htmlentities($result->FromDate);?></td>
                        <td><?php echo htmlentities($result->DepartTime);?></td>
                        <td><?php echo htmlentities($result->ToDate);?></td>
                        <td><?php echo htmlentities($result->ReturnTime);?></td>
                        <td><?php echo htmlentities($result->VehiclesType);?></td>
                        <td><a href="#?=bid<?php echo htmlentities($result->bid);?>"data-toggle="modal" data-target="#myModal<?php echo ($result->bid)?>">Details</a></td>
                        <!--Status display -->
                        <td><?php if($result->Status == '1') { ?>
                                <div>
                                    <p style="color:black;"><b>Process</b></p>
                                </div>
                            <?php } else if($result->Status == '2') { ?>
                                <div>
                                    <p style="color:red;"><b>Rejected</b></p>
                                </div>
                            <?php } else if($result->Status == '3')  { ?>
                                <div>
                                    <p style="color:black;"><b>Process</b></p>
                                </div>
                            <?php } else if($result->Status == '4')  { ?>
                                <div>
                                    <p style="color:red;"><b>Rejected by Administrator</b></p>
                                </div>
                            <?php } else if($result->Status == '5')  { ?>
                                <div>
                                    <p style="color:blue;"><b>Successful</b></p>
                                </div>
                            <?php }else if($result->Status == '6')  { ?>
                                <div>
                                    <p style="color:red;"><b>Rejected by Administrator</b></p>
                                </div>
                            <?php } else { ?>
                                <div>
                                    <p style="color:coral;"><b>Pending</b></p>
                                </div>
                            <?php } ?>
                            <!--End of status-->
                        </td>
                        <td><?php if($result->Status == '2') { ?>
                                <div>
                                    <p>Please contact your N+1</p>
                                </div>
                            <?php } elseif($result->Status == '4')  { ?>
                                <div>
                                    <?php echo htmlentities($result->Remark);?>
                                </div>
                            <?php } elseif($result->Status == '6')  { ?>
                                <div>
                                    <p>Please contact Administrator</p>
                                </div>
                            <?php } ?>
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
                                    <h4>Purpose: <?php echo htmlentities($result->Requisition);?></h4>
                                    <h4>Destination: <?php echo htmlentities($result->Destination);?></h4>
                                    <h4>Depart Date: <?php echo htmlentities($result->FromDate);?></h4>
                                    <h4>Depart Time: <?php echo htmlentities($result->DepartTime);?></h4>
                                    <h4>Return Date: <?php echo htmlentities($result->ToDate);?></h4>
                                    <h4>Return Time: <?php echo htmlentities($result->ReturnTime);?></h4>
                                    <h4>Pax: <?php echo htmlentities($result->Pax);?></h4>
                                    <h4>Driver: <?php echo htmlentities($result->DriverName);?></h4>
                                    <h4>Passengers: <?php echo htmlentities($result->Passengers);?></h4>
                                    <h4>Vehicle Type: <?php echo htmlentities($result->VehiclesType);?></h4>
                                    <h4>Vehicle Brand: <?php echo htmlentities($result->VehiclesBrand);?></h4>
                                    <h4>Vehicle Plate No: <?php echo htmlentities($result->VehiclesPlateNo);?></h4>
                                    <!--<h4>Remark: <?php if($result->Status == '2') { ?>
                                            <div>
                                                <p>Please contact your N+1</p>
                                            </div>
                                        <?php } elseif($result->Status == '4')  { ?>
                                            <div>
                                                <?php echo htmlentities($result->Remark);?>
                                            </div>
                                        <?php } elseif($result->Status == '6')  { ?>
                                            <div>
                                                <p>Please contact Administrator</p>
                                            </div>
                                        <?php } ?>
                                    </h4>-->
                                    <h4>Status: <?php if($result->Status == '1') { ?>
                                            <div>
                                                <p style="color:black;"><b>Process</b></p>
                                            </div>
                                        <?php } else if($result->Status == '2') { ?>
                                            <div>
                                                <p style="color:red;"><b>Rejected</b></p>
                                            </div>
                                        <?php } else if($result->Status == '3')  { ?>
                                            <div>
                                                <p style="color:black;"><b>Process</b></p>
                                            </div>
                                        <?php } else if($result->Status == '4')  { ?>
                                            <div>
                                                <p style="color:red;"><b>Rejected by Administrator</b></p>
                                            </div>
                                        <?php } else if($result->Status == '5')  { ?>
                                            <div>
                                                <p style="color:blue;"><b>Successful</b></p>
                                            </div>
                                        <?php }else if($result->Status == '6')  { ?>
                                            <div>
                                                <p style="color:red;"><b>Rejected by Administrator</b></p>
                                            </div>
                                        <?php } else { ?>
                                            <div>
                                                <p style="color:coral;"><b>Pending</b></p>
                                            </div>
                                        <?php } ?>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $cnt=$cnt+1; }} ?>
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