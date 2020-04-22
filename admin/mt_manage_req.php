<?php
error_reporting(1);

$db = new DBConnection;

session_start();
?>

<h2 class="page-title">Manage Reservation</h2>
<!-- Zero Configuration Table -->
<div class="panel panel-default">
    <div class="panel-heading">Reservation Info
        <button onclick="myFunction()" style="margin-left: 75%;">Print this page</button>
        <script>
            function myFunction() {
                window.print();
            }
        </script>
    </div>
    <div class="panel-body">
        <form name="view_booking" method="post" class="form-horizontal" enctype="multipart/form-data" >
            <!--******************************************** ROW 1 ******************************************************************************-->
            <!-- Date -->
            <div class="form-group">
                <label class="col-sm-2 control-label">Booking Date :</label>
                <label class="col-sm-1 control-label">From</label>
                <div class="col-sm-3">
                    <input name="dateFirst" type="date" id="dateFirst" class="form-control" >
                </div>

                &nbsp;<label class="col-sm-1 control-label">To</label>
                <div class="col-sm-3">
                    <input name="dateSecond" type="date" id="dateSecond" class="form-control" >
                </div>

                <button class="btn btn-primary" name="search" type="submit" value="Search" style="font-size: 15px;margin-left:10px">Search</button>
            </div>
        </form>
        <!--*************************************************************************************************************************-->
        <!--************************************************* SEARCH BOOKING **********************************************************************-->

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
                <th>Details</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if(isset($_POST['search'])) {
                $date1 = $_POST['dateFirst'];
                $date2 = $_POST['dateSecond'];

                $servername = "localhost";
                $username = "adminportal";
                $password = "admin123";
                $dbname = "adminportal";

                $sql = "SELECT tbl_mbooking_r.id, tblusers.FullName, tblusers.EmployeeNo, position.position, department.department, company.company, tbl_mbooking_r.requestDate, tbl_mbooking_r.purpose, 
                        tbl_mbooking_r.dateStart, tbl_mbooking_r.dateEnd, tbl_mbooking_r.timeStart, tbl_mbooking_r.timeEnd, 
                        tblroom.description, tbl_mbooking_r.drink, tbl_mbooking_r.pax, tbl_mbooking_r.status, tbl_mbooking_r.modifiedBy, tbl_mbooking_r.modifiedDate
                  FROM tblusers, tbl_mbooking_r, tblroom, department, company, position
                  WHERE position.pstId = tblusers.Position AND tblusers.EmployeeNo = tbl_mbooking_r.EmployeeNo AND tblroom.roomId = tbl_mbooking_r.room AND department.dpmtCode = tblusers.Department AND company.cmpCode = tblusers.Company
                         AND ((tbl_mbooking_r.dateStart BETWEEN '$date1' AND '$date2') AND (tbl_mbooking_r.dateEnd BETWEEN '$date1' AND '$date2'))
                  ORDER BY tbl_mbooking_r.dateStart DESC";

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
                            <td><?php echo htmlentities($result->FullName);?></td>
                            <td><?php echo htmlentities($result->department);?></td>
                            <td><?php echo htmlentities($dateStart);?></td>
                            <td><?php echo htmlentities($timeStart);?></td>
                            <td><?php echo htmlentities($dateEnd);?></td>
                            <td><?php echo htmlentities($timeEnd);?></td>
                            <td><?php echo htmlentities($result->description);?></td>
                            <td><a href="#?=id<?php echo htmlentities($result->id);?>"data-toggle="modal" data-target="#myModal<?php echo ($result->id)?>">Details </a></td>
                            <td><?php if (($result->dateStart >= date("Y-m-d") || $result->dateEnd >= date("Y-m-d")) && ($result->timeStart <= date("H:i:s") || $result->timeEnd >= date("H:i:s")) && ($result->status == "Booked")){ ?>
                                    <div>
                                        <a href = '?a=mt_manage_req_edit&no=<?php echo htmlentities($result->id);?>'>Edit </a> /
                                        <a href = '?a=mt_manage_req_del&no=<?php echo htmlentities($result->id);?>'> Cancel</a>
                                    </div>
                                <?php } elseif (($result->dateStart >= date("Y-m-d") || $result->dateEnd >= date("Y-m-d")) && ($result->timeStart <= date("H:i:s") || $result->timeEnd >= date("H:i:s")) && ($result->status == "Cancel")){ ?>
                                    <div>
                                        <a> </a>
                                    </div>
                                <?php } else {?>
                                    <div>
                                        <a> </a>
                                    </div>
                                <?php } ?>
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
                                        <h4> Name: <?php echo htmlentities($result->FullName);?></h4>
                                        <h4> Employee No: <?php echo htmlentities($result->EmployeeNo);?></h4>
                                        <h4> Position: <?php echo htmlentities($result->position);?></h4>
                                        <h4> Department: <?php echo htmlentities($result->department);?></h4>
                                        <h4> Company: <?php echo htmlentities($result->company);?></h4>
                                        <h4> Purpose: <?php echo htmlentities($result->purpose);?></h4>
                                        <h4> Start Date: <?php echo htmlentities($dateStart);?></h4>
                                        <h4> Start Time: <?php echo htmlentities($timeStart);?></h4>
                                        <h4> End Date: <?php echo htmlentities($dateEnd);?></h4>
                                        <h4> End Time: <?php echo htmlentities($timeEnd);?></h4>
                                        <h4> Room: <?php echo htmlentities($result->description);?></h4>
                                        <h4> Drink: <?php echo htmlentities($result->drink);?></h4>
                                        <h4> Pax: <?php echo htmlentities($result->pax);?></h4>
                                        <h4> Status: <?php echo htmlentities($result->status);?></h4>
                                        <h4> Modified By: <?php echo htmlentities($result->modifiedBy);?></h4>
                                        <h4> Modified Date: <?php echo htmlentities($result->modifiedDate);?></h4>

                                    </div>
                                    <div class="modal-footer">
                                        <button onclick="location.href = '?a=mt_manage_req_prt&id=<?php echo ($result->id)?>';">Print this page</td>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php $cnt=$cnt+1; }}} ?>
            </tbody>
            <tfoot>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Department</th>
                <th>Start Date</th>
                <th>Start Time</th>
                <th>End Date</th>
                <th>End Time</th>
                <th>Room</th>
                <th>Details</th>
                <th>Action</th>
            </tr>
            </tfoot>
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
