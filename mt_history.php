<?php
error_reporting(1);

$db = new DBConnection;

session_start();
?>

<h2 class="page-title">History Reservation Meeting Room</h2>
<div class="panel panel-default">
    <div class="panel-heading">Reservation Info</div>
    <div class="panel-body">
        <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>No</th>
                <th>Purpose</th>
                <th>Start Date</th>
                <th>Start Time</th>
                <th>End Date</th>
                <th>End Time</th>
                <th>Room</th>
                <th>Status</th>
                <th>Details</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>No</th>
                <th>Purpose</th>
                <th>Start Date</th>
                <th>Start Time</th>
                <th>End Date</th>
                <th>End Time</th>
                <th>Room</th>
                <th>Status</th>
                <th>Details</th>
                <th>Action</th>
            </tr>
            </tfoot>
            <tbody>
            <?php
            $servername = "localhost";
            $username = "adminportal";
            $password = "admin123";
            $dbname = "adminportal";

            $sql = "SELECT tbl_mbooking_r.id, tblusers.EmployeeNo, tbl_mbooking_r.requestDate, tbl_mbooking_r.purpose, 
                    tbl_mbooking_r.dateStart, tbl_mbooking_r.dateEnd, timeStart, timeEnd, tblroom.description, 
                    tbl_mbooking_r.drink, tbl_mbooking_r.pax, tbl_mbooking_r.status, tbl_mbooking_r.modifiedBy, tbl_mbooking_r.modifiedDate
                    FROM tblusers, tbl_mbooking_r, tblroom
                    WHERE tblusers.EmployeeNo = tbl_mbooking_r.EmployeeNo AND tblroom.roomId = tbl_mbooking_r.room
                    AND tbl_mbooking_r.EmployeeNo = '".$_SESSION['login']."' ORDER BY tbl_mbooking_r.requestDate DESC";

            $employeeNo = $_SESSION['login'];
            $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $query = $dbh -> prepare($sql);
            $query -> bindParam(':employeeNo',$employeeNo, PDO::PARAM_STR);
            $query -> execute();
            $results = $query->FetchAll(PDO::FETCH_OBJ);
            $cnt=1;
            if($query->rowCount() > 0) {
                foreach($results as $result) {
                    $dateStart = date("d-m-Y", strtotime($result->dateStart));
                    $dateEnd= date("d-m-Y", strtotime($result->dateEnd));
                    $timeStart = date("h:i A", strtotime($result->timeStart));
                    $timeEnd = date("h:i A", strtotime($result->timeEnd));
                    ?>
                    <tr>
                        <td><?php echo htmlentities($cnt);?></td>
                        <td><?php echo htmlentities($result->purpose);?></td>
                        <td><?php echo htmlentities($dateStart);?></td>
                        <td><?php echo htmlentities($timeStart);?></td>
                        <td><?php echo htmlentities($dateEnd);?></td>
                        <td><?php echo htmlentities($timeEnd);?></td>
                        <td><?php echo htmlentities($result->description);?></td>
                        <td><?php if($result->status == 'Booked') { ?>
                                <div>
                                    <p style="color:blue;"><b>Successful</b></p>
                                </div>
                            <?php } else if($result->status == 'Cancel') { ?>
                                <div>
                                    <p style="color:red;"><b>Cancel</b></p>
                                </div>
                            <?php } ?>
                            <!--End of status-->
                        </td>
                        <td><a href="#?=id<?php echo htmlentities($result->id);?>"data-toggle="modal" data-target="#myModal<?php echo ($result->id)?>">Details </a></td>
                        <td><?php if (($result->dateStart >= date("Y-m-d") || $result->dateEnd >= date("Y-m-d")) && ($result->timeStart <= date("H:i:s") || $result->timeEnd >= date("H:i:s")) && ($result->status == "Booked")){ ?>
                                    <div>
                                        <a href = '?p=mt_edit&no=<?php echo htmlentities($result->id);?>'>Edit </a> /
                                        <a href = '?p=mt_cancel&no=<?php echo htmlentities($result->id);?>'> Cancel</a>
                                    </div>
                            <?php } elseif (($result->dateStart >= date("Y-m-d") || $result->dateEnd >= date("Y-m-d")) && ($result->timeStart <= date("H:i:s") || $result->timeEnd >= date("H:i:s")) && ($result->status == "Cancel")){ ?>
                                    <div>
                                        <a> </a>
                                    </div>
                            <?php } else {?>
                                <div>
                                    <p> </p>
                                </div>
                            <?php } ?>
                        </td>
                    </tr>

                    <!--POPUP DETAILS-->
                    <div id="myModal<?php echo ($result->id) ?>" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Details</h4>
                                </div>
                                <div class="modal-body">
                                    <h4> Purpose: <?php echo htmlentities($result->purpose);?></h4>
                                    <h4> Start Date: <?php echo htmlentities($dateStart);?></h4>
                                    <h4> Start Time: <?php echo htmlentities($timeStart);?></h4>
                                    <h4> End Date: <?php echo htmlentities($dateEnd);?></h4>
                                    <h4> End Time: <?php echo htmlentities($timeEnd);?></h4>
                                    <h4> Room: <?php echo htmlentities($result->description);?></h4>
                                    <h4> Drink: <?php echo htmlentities($result->drink);?></h4>
                                    <h4> Pax: <?php echo htmlentities($result->pax);?></h4>
                                    <h4> Status: <?php if($result->status == 'Booked') { ?>
                                            <div>
                                                <p style="color:blue;"><b>Successful</b></p>
                                            </div>
                                        <?php } else if($result->status == 'Cancel') { ?>
                                            <div>
                                                <p style="color:red;"><b>Cancel</b></p>
                                            </div>
                                        <?php } ?>
                                    </h4>
                                    <h4> Modified By: <?php echo htmlentities($result->modifiedBy);?></h4>
                                    <h4> Modified Date: <?php echo htmlentities($result->modifiedDate);?></h4>
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
