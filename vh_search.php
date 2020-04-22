<?php
error_reporting(1);

$db = new DBConnection;

session_start();
?>
<h2 class="page-title">Search Reservation Vehicle</h2>
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
                <label class="col-sm-2 control-label">Type of Vehicle: </label>
                <div class="col-sm-4">
                    <select name="VehiclesType" id="VehiclesType" class="form-control">
                        <option value="">Select Vehicle</option>
                        <?php
                        $sqlVeh = "SELECT VehiclesType FROM tblmastervehicles GROUP BY VehiclesType ";
                        $radmin = mysql_query($sqlVeh);

                        while ( ( $rowAdm = mysql_fetch_array($radmin) ) != false ) {?>
                            <option  value="<?php echo $rowAdm['VehiclesType']; ?>">
                                <?php echo $rowAdm['VehiclesType'];  ?></option>
                        <?php } // close while ?>
                    </select>
                </div></div>
            </br>

            <div class="form-group">
                <div class="col-sm-8 col-sm-offset-2">
                    <button class="btn btn-primary" name="search" type="submit" value="submit" style="width: 100px; height: 45px; font-size: 15px;">Search</button>
                </div>
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
            if(isset($_POST['search'])) {
                $date1 = $_POST['dateFirst'];
                $date2 = $_POST['dateSecond'];
                $VehiclesType = $_POST['VehiclesType'];

                $servername = "localhost";
                $username = "adminportal";
                $password = "admin123";
                $dbname = "adminportal";

                // mysql search query
                $sql = "SELECT tblusers.FullName, department.department, company.company, DATE_FORMAT(tbl_vbooking.FromDate, '%d-%m-%Y') as FromDate, 
                        DATE_FORMAT(tbl_vbooking.ToDate, '%d-%m-%Y') as ToDate, TIME_FORMAT(tbl_vbooking.DepartTime,'%h:%i %p') as DepartTime, TIME_FORMAT(tbl_vbooking.ReturnTime,'%h:%i %p') as ReturnTime, 
                        tbl_vbooking.VehiclesType, tbl_vbooking.Pax, tbl_vbooking.Requisition,
                        tbl_vbooking.PostingDate, tbl_vbooking.Status
                        FROM tblusers, tbl_vbooking, department, company
                        WHERE tblusers.EmployeeNo = tbl_vbooking.UserEmployeeNo AND department.dpmtCode = tblusers.Department AND company.cmpCode = tblusers.Company 
                        AND ((tbl_vbooking.FromDate BETWEEN '$date1' AND '$date2') AND (tbl_vbooking.ToDate BETWEEN '$date1' AND '$date2') 
                        OR tbl_vbooking.VehiclesType = '$VehiclesType')
                        ORDER BY tbl_vbooking.ToDate DESC";

                $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $query = $dbh -> prepare($sql);
                $query -> bindParam(':employeeNo',$employeeNo, PDO::PARAM_STR);
                $query -> execute();
                $results = $query->FetchAll(PDO::FETCH_OBJ);
                $cnt=1;
                if($query->rowCount() > 0) {
                    foreach($results as $result) {
                        if ($result->Status != '2' && $result->Status != '4' && $result->Status != '6'){ ?>
                        <tr>
                            <td><?php echo htmlentities($cnt);?></td>
                            <td><?php echo htmlentities($result->FullName);?></td>
                            <td><?php echo htmlentities($result->department);?></td>
                            <td><?php echo htmlentities($result->FromDate);?></td>
                            <td><?php echo htmlentities($result->DepartTime);?></td>
                            <td><?php echo htmlentities($result->ToDate);?></td>
                            <td><?php echo htmlentities($result->ReturnTime);?></td>
                            <td><?php echo htmlentities($result->VehiclesType);?></td>
                            <td><?php if($result->Status == '1') { ?>
                                    <div>
                                        <p style="color:black;"><b>Process</b></p>
                                    </div>
                                <?php } elseif($result->Status == '2') { ?>
                                    <div>
                                        <p style="color:red;"><b>Rejected by Manager</b></p>
                                    </div>
                                <?php } elseif($result->Status == '3')  { ?>
                                    <div>
                                        <p style="color:black;"><b>Process</b></p>
                                    </div>
                                <?php } elseif($result->Status == '4')  { ?>
                                    <div>
                                        <p style="color:red;"><b>Rejected by Administrator</b></p>
                                    </div>
                                <?php } else if($result->Status == '5')  { ?>
                                    <div>
                                        <p style="color:blue;"><b>Successful</b></p>
                                    </div>
                                <?php } else if($result->Status == '6')  { ?>
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
                        </tr>
                    <?php $cnt=$cnt+1; }}}} ?>
            </tbody>
            <tfoot>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Department</th>
                <th>From Date</th>
                <th>To Date</th>
                <th>Depart Time</th>
                <th>Return Time</th>
                <th>Vehicle</th>
                <th>Status</th>
            </tr>
            </tfoot>
        </table>
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
