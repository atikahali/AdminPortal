<?php
error_reporting(1);

$db = new DBConnection;

session_start();

?>
<h2 class="page-title">Search Reservation</h2>
<div class="panel panel-default">
    <div class="panel-heading">Booking Info</div>
    <div class="panel-body">
        <form name="view_booking" method="post" class="form-horizontal" enctype="multipart/form-data" >
            <!--******************************************** ROW 1 ******************************************************************************-->
            <div class="form-group">
                <label class="col-sm-2 control-label">Reserve Date:</label>
                <label class="col-sm-1 control-label">From</label>
                <div class="col-sm-3">
                    <input name="dateFirst" type="date" id="dateFirst" class="form-control" >
                </div>

                &nbsp;<label class="col-sm-1 control-label">To</label>
                <div class="col-sm-3">
                    <input name="dateSecond" type="date" id="dateSecond" class="form-control" >
                </div>

                <button class="btn btn-primary" name="search" type="submit" value="submit" style="width: 90px; height: 45px; font-size: 15px;">Search</button>

            </div>
            </br>
        </form></br></br>
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
                <!--<th>Details</th>-->
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
                <!--<th>Details</th>-->
                <th>Status</th>
            </tr>
            </tfoot>
            <tbody>
            <?php
            if(isset($_POST['search'])) {
                $date1 = $_POST['dateFirst'];
                $date2 = $_POST['dateSecond'];

                $sql = "SELECT tblusers.FullName, tblusers.EmployeeNo, manager.manager, position.position, department.department, company.company, tbl_vbooking.VehiclesType,
                tbl_vbooking.bookingId, tbl_vbooking.FromDate, tbl_vbooking.ToDate,
                 TIME_FORMAT(tbl_vbooking.DepartTime,'%h:%i %p') as DepartTime, TIME_FORMAT(tbl_vbooking.ReturnTime,'%h:%i %p') as ReturnTime, tbl_vbooking.Pax, tbl_vbooking.Passengers,
                tbl_vbooking.Requisition, tbl_vbooking.Destination, tbl_vbooking.Status, tbl_vbooking.Remark, tbl_vbooking.DriverName, tbl_vbooking.VehiclesPlateNo, tbl_vbooking.VehiclesBrand, tbl_vbooking.Issuance, tbl_vbooking.FuelCard, 
                tbl_vbooking.PostingDate, tbl_vbooking.DriverEmployeeNo, tbl_vbooking.DriverDepartment, DATE_FORMAT(tbl_vbooking.expiredLicense, '%d-%m-%Y') as expiredLicense
                FROM tbl_vbooking, tblusers, department, company, position, manager
                WHERE manager.ManagerNo = tblusers.Manager AND position.pstId = tblusers.Position AND tblusers.EmployeeNo = tbl_vbooking.UserEmployeeNo AND department.dpmtCode = tblusers.Department AND company.cmpCode = tblusers.Company
                AND ((tbl_vbooking.FromDate BETWEEN '$date1' AND '$date2') AND (tbl_vbooking.ToDate BETWEEN '$date1' AND '$date2'))
                ORDER BY tbl_vbooking.ToDate DESC";

                $rst = mysql_query($sql);
                if((mysql_num_rows($rst) > 0)){
                    $no = 1;
                    while($row = mysql_fetch_assoc($rst)){
                        $FromDate = $row['FromDate'];
                        $ToDate = $row['ToDate'];?>
                        <tr>
                            <td> <?php echo $no; $no++; ?> </td>
                            <td><?php echo$row["FullName"]?></td>
                            <td><?php echo$row["Destination"]?></td>
                            <td><?php echo$row["VehiclesPlateNo"]?></td>
                            <td><?php echo date("d-m-Y", strtotime($FromDate)); ?></td>
                            <td><?php echo$row["DepartTime"]?></td>
                            <td><?php echo date("d-m-Y", strtotime($ToDate)); ?></td>
                            <td><?php echo$row["ReturnTime"]?></td>
                            <td><?php echo$row["DriverName"]?></td>
                            <td><?php echo$row["Pax"]?></td>
                            <!--<td><a href = '?a=vh_reservation_list_prt&bookingId=<?php echo $row["bookingId"];?>'>Details </a></td>-->
                            <td>
                                <?php if($row["Status"] == '1') { ?>
                                    <div>
                                        <p style="color:green;"><b>MANAGER APPROVE</b></p>
                                    </div>
                                <?php } else if($row["Status"] == '2') { ?>
                                    <div>
                                        <p style="color:red;"><b>MANAGER REJECT</b></p>
                                    </div>
                                <?php } else if($row["Status"] == '3')  { ?>
                                    <div>
                                        <p style="color:black;"><b>ADMIN APPROVE</b></p>
                                    </div>
                                <?php } else if($row["Status"] == '4')  { ?>
                                    <div>
                                        <p style="color:red;"><b>ADMIN REJECT</b></p>
                                    </div>
                                <?php }  else if($row["Status"] == '5')  { ?>
                                    <div>
                                        <p style="color:blue;"><b>SUCCESSFUL</b></p>
                                    </div>
                                <?php }  else if($row["Status"] == '6')  { ?>
                                    <div>
                                        <p style="color:red;"><b>REJECTED</b></p>
                                    </div>
                                <?php } else { ?>
                                    <div>
                                        <p style="color:coral;"><b>PENDING</b></p>
                                    </div>
                                <?php } ?>
                                <!--End of status-->
                            </td>
                        </tr> <?php
                    }
                } else {
                    echo "<script>alert('No Booking.');</script>";
                }
            }
            ?>
            </tbody>
        </table>
        <form method="post" action="?r=vh_search_excel&date1=<?php echo $date1;?>&date2=<?php echo $date2;?>">
            <input type="submit" name="export" class="btn btn-success" value="Export to Excel" />
        </form>
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