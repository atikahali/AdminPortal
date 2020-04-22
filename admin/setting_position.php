<?php
error_reporting(1);

$db = new DBConnection;

session_start();
?>
<h2 class="page-title">Manage Position</h2>
<div class="panel panel-default">
    <div class="panel-heading">Form field</div>
        <div class="panel-body">
        <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>No</th>
                <th>Position</th>
                <th>Status</th>
                <th>Created By</th>
                <th>Created Date & Time</th>
                <th>Modified By</th>
                <th>Modified Date & Time</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>No</th>
                <th>Position</th>
                <th>Status</th>
                <th>Created By</th>
                <th>Created Date & Time</th>
                <th>Modified By</th>
                <th>Modified Date & Time</th>
                <th>Action</th>
            </tr>
            </tfoot>
            <tbody>
            <?php
            $servername = "localhost";
            $username = "adminportal";
            $password = "admin123";
            $dbname = "adminportal";

            $sql = "SELECT * FROM position ORDER BY position ASC";

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
                        <td><?php echo htmlentities($result->position);?></td>
                        <td><?php echo htmlentities($result->pstStatus);?></td>
                        <td><?php echo htmlentities($result->createdBy);?></td>
                        <td><?php echo htmlentities($result->createdDate);?></td>
                        <td><?php echo htmlentities($result->modifiedBy);?></td>
                        <td><?php echo htmlentities($result->modifiedDate);?></td>
                        <td><a href ='?a=setting_position_edit&pstId=<?php echo htmlentities($result->pstId);?>'>Edit </a>/
                            <a href ='?a=setting_position_del&pstId=<?php echo htmlentities($result->pstId);?>'> Delete</a></td>
                    </tr>
                <?php $cnt=$cnt+1; }} ?>
            </tbody>
        </table>
        <button onclick="location.href = '?a=setting_position_add';" class="btn btn-primary" style="font-size: 15px;">Add Position&nbsp; <i class="fa fa-chevron-right" style='font-size:15px'></i></button>
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

