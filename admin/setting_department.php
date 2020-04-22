<?php
error_reporting(1);

$db = new DBConnection;

session_start();

$sql = "SELECT * FROM department ORDER BY department ASC";
$rst = mysql_query($sql);
?>
<h2 class="page-title">Manage Department</h2>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">Form field</div>
            <div class="panel-body">
                <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Code</th>
                        <th>Department</th>
                        <th>Status</th>
                        <th>Created By</th>
                        <th>Created Date & Time</th>
                        <th>Modified By</th>
                        <th>Modified Date & Time</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if((mysql_num_rows($rst) > 0)){
                        $no = 1;
                        while($row = mysql_fetch_assoc($rst)){?>
                            <tr><td> <?php echo $no; $no++; ?> </td>
                                <td><?php echo$row["dpmtCode"]?></td>
                                <td><?php echo$row["department"]?></td>
                                <td><?php echo$row["dpmtStatus"]?></td>
                                <td><?php echo$row["createdBy"]?></td>
                                <td><?php echo$row["createdDate"]?></td>
                                <td><?php echo$row["modifiedBy"]?></td>
                                <td><?php echo$row["modifiedDate"]?></td>
                                <td><a href="?a=setting_department_edit&dpmtId=<?php echo$row["dpmtId"];?>">Edit </a>/
                                    <a href="?a=setting_department_del&dpmtId=<?php echo$row["dpmtId"];?>" > Delete</a></td>
                            </tr> <?php
                        }
                    } else {
                        echo "<script>alert('No data found.');</script>";
                    }
                    ?>
                    </tbody>
                </table>
                <button onclick="location.href = '?a=setting_department_add';" class="btn btn-primary" style="font-size: 15px;">Add Department&nbsp; <i class="fa fa-chevron-right" style='font-size:15px'></i></button>
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