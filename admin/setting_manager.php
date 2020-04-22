<?php
error_reporting(1);

$db = new DBConnection;

session_start();
?>

<h2 class="page-title">Manage Manager</h2>
<div class="panel panel-default">
    <div class="panel-heading">Form field</div>
    <div class="panel-body">
        <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Employee No</th>
                <th>Created By</th>
                <th>Created Date & Time</th>
                <th>Modified By</th>
                <th>Modified Date & Time</th>
                <th>Status</th>
                <th>Details</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Employee No</th>
                <th>Created By</th>
                <th>Created Date & Time</th>
                <th>Modified By</th>
                <th>Modified Date & Time</th>
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

            $sql = "SELECT manager.id, manager.ManagerNo, manager.IC, manager.manager, manager.email, position.position, manager.category, department.department, 
                    company.company, manager.status, manager.createdBy, manager.createdDate, manager.modifiedBy, manager.modifiedDate
                    FROM manager, position, department, company
                    WHERE position.pstId = manager.position AND department.dpmtCode = manager.department 
                    AND company.cmpCode = manager.company ORDER BY manager.manager ASC";

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
                        <td><?php echo htmlentities($result->manager);?></td>
                        <td><?php echo htmlentities($result->ManagerNo);?></td>
                        <td><?php echo htmlentities($result->createdBy);?></td>
                        <td><?php echo htmlentities($result->createdDate);?></td>
                        <td><?php echo htmlentities($result->modifiedBy);?></td>
                        <td><?php echo htmlentities($result->modifiedDate);?></td>
                        <td><?php echo htmlentities($result->status);?></td>
                        <td><a href="#?=id<?php echo htmlentities($result->id);?>"data-toggle="modal" data-target="#myModal<?php echo ($result->id)?>">Details </a></td>
                        <td><a href ='?a=setting_manager_edit&id=<?php echo htmlentities($result->id);?>'>Edit </a>/
                            <a href ='?a=setting_manager_del&id=<?php echo htmlentities($result->id);?>'> Delete</a></td>
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
                                    <h4> Name: <?php echo htmlentities($result->manager);?></h4>
                                    <h4> IC Number: <?php echo htmlentities($result->IC);?></h4>
                                    <h4> Employee Number: <?php echo htmlentities($result->ManagerNo);?></h4>
                                    <h4> Email: <?php echo htmlentities($result->email);?></h4>
                                    <h4> Position: <?php echo htmlentities($result->position);?></h4>
                                    <h4> Category: <?php echo htmlentities($result->category);?></h4>
                                    <h4> Department: <?php echo htmlentities($result->department);?></h4>
                                    <h4> Company: <?php echo htmlentities($result->company);?></h4>
                                    <h4> Status: <?php echo htmlentities($result->status);?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $cnt=$cnt+1; }} ?>
            </tbody>
        </table>
        <button onclick="location.href = '?a=setting_manager_add';" class="btn btn-primary" style="font-size: 15px;">Add Manager&nbsp; <i class="fa fa-chevron-right" style='font-size:15px'></i></button>

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

