<?php
error_reporting(1);

$db = new DBConnection;

session_start();
?>

<h2 class="page-title">Search Reservation Meeting Room</h2>
<div class="panel panel-default">
    <div class="panel-heading">Reservation Info</div>
    <div class="panel-body">
        <form name="view_booking" method="post" class="form-horizontal" enctype="multipart/form-data" >
            <!--******************************************** ROW 1 ******************************************************************************-->
            <!-- Date -->
            <div class="form-group">
                <label class="col-sm-2 control-label">Reserve Date: </label>
                <label class="col-sm-1 control-label">From</label>
                <div class="col-sm-3">
                    <input name="dateFirst" type="date" id="dateFirst" class="form-control" >
                </div>

                &nbsp<label class="col-sm-1 control-label">To</label>
                <div class="col-sm-3">
                    <input name="dateSecond" type="date" id="dateSecond" class="form-control" >
                </div>
            </div>

            <div class="form-group">
                &nbsp;<label class="col-sm-2 control-label">Type of Room :</label>
                <div class="col-sm-5">
                    <select name="room" id="room" class="form-control">
                        <option value="" >Select Room</option>
                        <?php
                        $sql = "SELECT roomId, description FROM tblroom WHERE status = 'Active' ORDER BY roomId ASC";
                        $radmin = mysql_query($sql);

                        while ( ( $rowAdm = mysql_fetch_array($radmin) ) != false ) {
                            ?><option  value="<?php echo $rowAdm['roomId']; ?>"><?php echo $rowAdm['description']; ?></option><?php
                        } // close while ?>
                    </select>
                </div>

                <button class="btn btn-primary" name="search" type="submit" style="width: 90px; height: 45px; font-size: 15px;margin-left:10px">Search</button></br>
            </div>
        </form></br></br>
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
                <th>Pax</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if(isset($_POST['search'])) {
                $date1 = $_POST['dateFirst'];
                $date2 = $_POST['dateSecond'];
                $room = $_POST['room'];

                $servername = "localhost";
                $username = "adminportal";
                $password = "admin123";
                $dbname = "adminportal";

                $sql = "SELECT tbl_mbooking_r.id, tblusers.FullName, tblusers.EmployeeNo, department.department, company.company, tbl_mbooking_r.requestDate, 
                        DATE_FORMAT(tbl_mbooking_r.dateStart, '%d-%m-%Y') as dateStart, DATE_FORMAT(tbl_mbooking_r.dateEnd, '%d-%m-%Y') as dateEnd, TIME_FORMAT(tbl_mbooking_r.timeStart,'%h:%i %p') as timeStart, TIME_FORMAT(tbl_mbooking_r.timeEnd,'%h:%i %p') as timeEnd, tbl_mbooking_r.room, 
                        tblroom.description, tbl_mbooking_r.pax, tbl_mbooking_r.status 
                  FROM tblusers, tbl_mbooking_r, tblroom, department, company 
                  WHERE tblusers.EmployeeNo = tbl_mbooking_r.EmployeeNo AND tblroom.roomId = tbl_mbooking_r.room AND department.dpmtCode = tblusers.Department AND company.cmpCode = tblusers.Company
                         AND ((tbl_mbooking_r.dateStart BETWEEN '$date1' AND '$date2') AND (tbl_mbooking_r.dateEnd BETWEEN '$date1' AND '$date2') 
                        OR tbl_mbooking_r.room = '$room') AND tbl_mbooking_r.status = 'Booked'
                  ORDER BY tbl_mbooking_r.dateEnd DESC";

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
                        <td><?php echo htmlentities($result->FullName);?></td>
                        <td><?php echo htmlentities($result->department);?></td>
                        <td><?php echo htmlentities($result->dateStart);?></td>
                        <td><?php echo htmlentities($result->timeStart);?></td>
                        <td><?php echo htmlentities($result->dateEnd);?></td>
                        <td><?php echo htmlentities($result->timeEnd);?></td>
                        <td><?php echo htmlentities($result->description);?></td>
                        <td><?php echo htmlentities($result->pax);?></td>
                    </tr>
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
                <th>Pax</th>
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
