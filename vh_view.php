<?php
error_reporting(1);

$db = new DBConnection;

session_start();

?>
<h2 class="page-title">View Reservation Vehicle</h2>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">Form field</div>
            <div class="panel-body">
                <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Depart Date</th>
                        <th>Depart Time</th>
                        <th>Return Date</th>
                        <th>Return Time</th>
                        <th>Vehicle</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    $sql ="SELECT tblusers.FullName, tblusers.EmployeeNo, department.department, company.company, tbl_vbooking.VehiclesType,
                    tbl_vbooking.bookingId, tbl_vbooking.FromDate, tbl_vbooking.ToDate,
                     tbl_vbooking.DepartTime, tbl_vbooking.ReturnTime, tbl_vbooking.Pax, tbl_vbooking.Passengers,
                    tbl_vbooking.Requisition, tbl_vbooking.Status, tbl_vbooking.VehiclesPlateNo, tbl_vbooking.VehiclesBrand, tbl_vbooking.PostingDate
                    FROM tbl_vbooking, tblusers, department, company 
                    WHERE tblusers.EmployeeNo = tbl_vbooking.UserEmployeeNo AND department.dpmtCode = tblusers.Department AND company.cmpCode = tblusers.Company AND tbl_vbooking.ToDate >= CURDATE()
                    ORDER BY tbl_vbooking.ToDate DESC";
                    $rst = mysql_query($sql);
                    if((mysql_num_rows($rst) > 0)){
                        $no = 1;
                        while($row = mysql_fetch_assoc($rst)){
                            if($row['Status']!="2" && $row['Status']!="4"){
                                $FromDate = $row['FromDate'];
                                $ToDate = $row['ToDate'];
                                $DepartTime = $row['DepartTime'];
                                $ReturnTime = $row['ReturnTime'];
                                ?>
                                <tr>
                                    <td> <?php echo $no; $no++; ?> </td>
                                    <td><?php echo$row["FullName"]?></td>
                                    <td><?php echo$row["department"]?></td>
                                    <td><?php echo date("d-m-Y", strtotime($FromDate)); ?></td>
                                    <td><?php echo date("h:i A", strtotime($DepartTime)); ?></td>
                                    <td><?php echo date("d-m-Y", strtotime($ToDate)); ?></td>
                                    <td><?php echo date("h:i A", strtotime($ReturnTime)); ?></td>
                                    <td><?php echo$row["VehiclesType"]?></td>
                                    <td><?php if($row["Status"] == '1') { ?>
                                            <div>
                                                <p style="color:black;"><b>Process</b></p>
                                            </div>
                                        <?php } elseif($row["Status"] == '2') { ?>
                                            <div>
                                                <p style="color:red;"><b>Rejected by Manager</b></p>
                                            </div>
                                        <?php } elseif($row["Status"] == '3')  { ?>
                                            <div>
                                                <p style="color:black;"><b>Process</b></p>
                                            </div>
                                        <?php } elseif($row["Status"] == '4')  { ?>
                                            <div>
                                                <p style="color:red;"><b>Rejected by Administrator</b></p>
                                            </div>
                                        <?php } else if($row["Status"] == '5')  { ?>
                                            <div>
                                                <p style="color:blue;"><b>Successful</b></p>
                                            </div>
                                        <?php } else if($row["Status"] == '6')  { ?>
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
                                </tr> <?php
                            }
                        }
                    }
                    else {
                        echo "<script>alert('No Booking.');</script>";
                    }
                    ?>
                    </tbody>
                </table>

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
