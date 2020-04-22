<?php
error_reporting(1);

$db = new DBConnection;

session_start();

?>
<h2 class="page-title">Manage Vehicle</h2>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">Form field</div>
            <div class="panel-body">
                <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Vehicle Type</th>
                        <th>Vehicle Brand</th>
                        <th>Vehicle Plate No </th>
                        <th>Model Year</th>
                        <th>Seating capacity</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sql = "SELECT * FROM tblmastervehicles ORDER BY VehiclesType";
                    $rst = mysql_query($sql);
                    ?>
                    <?php
                    if((mysql_num_rows($rst) > 0)){
                        $no = 1;
                        while($row = mysql_fetch_assoc($rst)){?>
                            <tr><td> <?php echo $no; $no++; ?> </td>
                                <td><?php echo$row["VehiclesType"]?></td>
                                <td><?php echo$row["VehiclesBrand"]?></td>
                                <td><?php echo$row["VehiclesPlateNo"]?></td>
                                <td><?php echo$row["ModelYear"]?></td>
                                <td><?php echo$row["SeatingCapacity"]?></td>
                                <td><?php echo$row["Status"]?></td>
                                <td><a href="?a=vh_manage_vehicles_edit&vehicleId=<?php echo $row["vehicleId"];?>">Edit </a>/
                                    <a href="?a=vh_manage_vehicles_del&vehicleId=<?php echo $row["vehicleId"];?>" > Delete</a></td>
                            </tr> <?php
                        }
                    } else {
                        echo "<script>alert('No data found.');</script>";
                    }
                    ?>
                    </tbody>
                </table>
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
