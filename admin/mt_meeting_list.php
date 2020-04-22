<?php
error_reporting(1);

$db = new DBConnection;

session_start();
?>

<h2 class="page-title">Reservation List</h2>
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
        <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Employee No</th>
                <th>Department</th>
                <th>Start Date</th>
                <th>Start Time</th>
                <th>End Date</th>
                <th>End Time</th>
                <th>Room</th>
                <th>Details</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Employee No</th>
                <th>Department</th>
                <th>Start Date</th>
                <th>Start Time</th>
                <th>End Date</th>
                <th>End Time</th>
                <th>Room</th>
                <th>Details</th>
            </tr>
            </tfoot>
            <tbody>
            <?php
            $servername = "localhost";
            $username = "adminportal";
            $password = "admin123";
            $dbname = "adminportal";

            $sql = "SELECT tbl_mbooking_r.id, tblusers.FullName, tblusers.EmployeeNo, position.position, department.department, 
                        company.company, tbl_mbooking_r.requestDate, tbl_mbooking_r.purpose, 
                        DATE_FORMAT(tbl_mbooking_r.dateStart,'%d-%m-%Y') as dateStart, 
                        DATE_FORMAT(tbl_mbooking_r.dateEnd,'%d-%m-%Y') as dateEnd, 
                        TIME_FORMAT(tbl_mbooking_r.timeStart,'%h:%i %p') as timeStart,
                        TIME_FORMAT(tbl_mbooking_r.timeEnd,'%h:%i %p') as timeEnd, 
                        tblroom.description, tbl_mbooking_r.drink, tbl_mbooking_r.pax, tbl_mbooking_r.status
                        FROM tblusers, tbl_mbooking_r, tblroom, department, company, position
                        WHERE position.pstId = tblusers.Position AND tblusers.EmployeeNo = tbl_mbooking_r.EmployeeNo AND tblroom.roomId = tbl_mbooking_r.room AND department.dpmtCode = tblusers.Department AND company.cmpCode = tblusers.Company AND (tbl_mbooking_r.dateStart >= CURDATE() OR tbl_mbooking_r.dateEnd >= CURDATE()) AND tbl_mbooking_r.status = 'Booked'
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
                        <td><?php echo htmlentities($result->EmployeeNo);?></td>
                        <td><?php echo htmlentities($result->department);?></td>
                        <td><?php echo htmlentities($result->dateStart);?></td>
                        <td><?php echo htmlentities($result->timeStart);?></td>
                        <td><?php echo htmlentities($result->dateEnd);?></td>
                        <td><?php echo htmlentities($result->timeEnd);?></td>
                        <td><?php echo htmlentities($result->description);?></td>
                        <td><a href="#?=id<?php echo htmlentities($result->id);?>"data-toggle="modal" data-target="#myModal<?php echo ($result->id)?>">Details </a></td>
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
                                    <h4> Start Date: <?php echo htmlentities($result->dateStart);?></h4>
                                    <h4> Start Time: <?php echo htmlentities($result->timeStart);?></h4>
                                    <h4> End Date: <?php echo htmlentities($result->dateEnd);?></h4>
                                    <h4> End Time: <?php echo htmlentities($result->timeEnd);?></h4>
                                    <h4> Room: <?php echo htmlentities($result->description);?></h4>
                                    <h4> Drink: <?php echo htmlentities($result->drink);?></h4>
                                    <h4> Pax: <?php echo htmlentities($result->pax);?></h4>
                                    <h4> Status: <?php echo htmlentities($result->status);?></h4>
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
