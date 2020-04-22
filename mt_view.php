<?php
error_reporting(1);

$db = new DBConnection;

session_start();

$sql = "SELECT tbl_mbooking_r.id, tblusers.FullName, department.department, company.company, tblusers.EmployeeNo, tbl_mbooking_r.requestDate, tbl_mbooking_r.purpose, 
        tbl_mbooking_r.dateStart, tbl_mbooking_r.dateEnd, tbl_mbooking_r.timeStart, tbl_mbooking_r.timeEnd, tblroom.description, 
        tbl_mbooking_r.drink, tbl_mbooking_r.pax, tbl_mbooking_r.status
        FROM tblusers, tbl_mbooking_r, tblroom, department, company
        WHERE tblusers.EmployeeNo = tbl_mbooking_r.EmployeeNo AND tblroom.roomId = tbl_mbooking_r.room AND department.dpmtCode = tblusers.Department AND company.cmpCode = tblusers.Company
        AND (tbl_mbooking_r.dateStart = CURDATE() OR tbl_mbooking_r.dateEnd >= CURDATE()) AND tbl_mbooking_r.status = 'Booked'";

$rst = mysql_query($sql);
?>

<h2 class="page-title">View Reservation Meeting Room</h2>
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
                        <th>Start Date</th>
                        <th>Start Time</th>
                        <th>End Date</th>
                        <th>End Time</th>
                        <th>Room</th>
                        <th>Pax</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if((mysql_num_rows($rst) > 0)){
                        $no = 1;
                        while($row = mysql_fetch_assoc($rst)){
                            if($row['status']=="Booked"){
                                $dateStart = $row['dateStart'];
                                $dateEnd = $row['dateEnd'];
                                $timeStart = $row['timeStart'];
                                $timeEnd = $row['timeEnd'];
                                ?>
                                <tr>
                                    <td> <?php echo $no; $no++; ?> </td>
                                    <td><?php echo$row["FullName"]?></td>
                                    <td><?php echo$row["department"]?></td>
                                    <td><?php echo date("d-m-Y", strtotime($dateStart)); ?></td>
                                    <td><?php echo date("h:i A", strtotime($timeStart)); ?></td>
                                    <td><?php echo date("d-m-Y", strtotime($dateEnd)); ?></td>
                                    <td><?php echo date("h:i A", strtotime($timeEnd)); ?></td>
                                    <td><?php echo$row["description"]?></td>
                                    <td><?php echo$row["pax"]?></td>
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