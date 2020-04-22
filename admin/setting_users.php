<?php
error_reporting(1);

$db = new DBConnection;

session_start();
?>
<h2 class="page-title">Manage Users</h2>
<div class="panel panel-default">
    <div class="panel-heading">Form field</div>
    <div class="panel-body">
        <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Employee No</th>
                <th>Position</th>
                <th>Manager</th>
                <th>Department</th>
                <th>Company</th>
                <th>Details</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Employee No</th>
                <th>Position</th>
                <th>Manager</th>
                <th>Department</th>
                <th>Company</th>
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

            $sql = "SELECT tblusers.id, tblusers.FullName, tblusers.EmployeeNo, position.position, manager.manager, department.department, company.company, 
                            tblusers.Email, tblusers.Password, tblusers.RegDate, tblusers.status, tblusers.modifiedBy, tblusers.modifiedDate
                        FROM tblusers, position, manager, department, company
                        WHERE position.pstId = tblusers.Position AND manager.ManagerNo = tblusers.Manager AND department.dpmtCode = tblusers.Department AND company.cmpCode = tblusers.Company
                        ORDER BY tblusers.FullName ASC";

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
                        <td><?php echo htmlentities($result->position);?></td>
                        <td><?php echo htmlentities($result->manager);?></td>
                        <td><?php echo htmlentities($result->department);?></td>
                        <td><?php echo htmlentities($result->company);?></td>
                        <td><a href="#?=id<?php echo htmlentities($result->id);?>"data-toggle="modal" data-target="#myModal<?php echo ($result->id)?>">Details </a></td>
                        <td><a href ='?a=setting_users_edit&id=<?php echo htmlentities($result->id);?>'>Edit </a>/
                            <a href ='?a=setting_users_del&id=<?php echo htmlentities($result->id);?>'> Delete</a></td>
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
                                    <h4> Pass Id No: <?php echo htmlentities($result->Password);?></h4>
                                    <h4> Email: <?php echo htmlentities($result->Email);?></h4>
                                    <h4> Position: <?php echo htmlentities($result->position);?></h4>
                                    <h4> Manager: <?php echo htmlentities($result->manager);?></h4>
                                    <h4> Department: <?php echo htmlentities($result->department);?></h4>
                                    <h4> Company: <?php echo htmlentities($result->company);?></h4>
                                    <h4> Registration Date: <?php echo htmlentities($result->RegDate);?></h4>
                                    <h4> Modified By: <?php echo htmlentities($result->modifiedBy);?></h4>
                                    <h4> Modified Date: <?php echo htmlentities($result->modifiedDate);?></h4>
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
