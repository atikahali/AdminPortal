<?php
error_reporting(1);

$db = new DBConnection;

session_start();
?>
<h2 class="page-title">Manage Room</h2>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">Form field</div>
            <!--**************************************************************************************************************************-->
            <div class="panel-body">
                <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                    <tr>
                        <th>No</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Created By</th>
                        <th>Created Date & Time</th>
                        <th>Modified By</th>
                        <th>Modified Date & Time</th>
                        <th>Action</th>
                    </tr>
                <?php
                $sql = "SELECT * FROM tblroom";
                $rst = mysql_query($sql);
                $no = 1;
                if((mysql_num_rows($rst) > 0)){
                    while($row = mysql_fetch_assoc($rst)){ ?>
                            <tr>
                                <td> <?php echo $no; $no++; ?> </td>
                                <td><?php echo$row["description"]?></td>
                                <td><?php echo$row["status"]?></td>
                                <td><?php echo$row["createdBy"]?></td>
                                <td><?php echo$row["createdDate"]?></td>
                                <td><?php echo$row["modifiedBy"]?></td>
                                <td><?php echo$row["modifiedDate"]?></td>
                                <td><a href = '?a=mt_manage_room_edit&roomId=<?php echo $row["roomId"]?>'>Edit </a>/
                                <a href = '?a=mt_manage_room_del&roomId=<?php echo $row["roomId"]?>'> Delete</a></td>
                            </tr> <?php
                    }
                } else {
                    echo "<script>alert('No data found.');</script>";
                }
                ?>
                </table>
                <button onclick="location.href = '?a=mt_manage_room_add';" class="btn btn-primary" style="font-size: 15px;">Add Room&nbsp; <i class="fa fa-chevron-right" style='font-size:15px'></i></button>
            </div>
        </div>
    </div>
</div>
<!--**************************************************************************************************************************-->
<!-- Loading Scripts -->
<script src="../js/combodate.js"></script>
<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap-select.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/jquery.dataTables.min.js"></script>
<script src="../js/dataTables.bootstrap.min.js"></script>
<script src="../js/Chart.min.js"></script>
<script src="../js/fileinput.js"></script>
<script src="../js/chartData.js"></script>
<script src="../js/main.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<!--**************************************************************************************************************************-->

</body>
</html>