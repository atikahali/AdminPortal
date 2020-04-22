<?php
mysql_connect("localhost","adminportal","admin123");
mysql_select_db("adminportal");
//limitation of vehicle
if(($_POST["type_id"]) >= 5) {

    $query1 = "SELECT VehiclesType FROM tblmastervehicles WHERE status = 'Active' GROUP BY VehiclesType ASC";
    $result1 = mysql_query($query1);
    ?>

    <option value=""></option>
    <?php while($row1=mysql_fetch_array($result1)) {?>
        <option value="<?php echo $row1["VehiclesType"]; ?>"><?php echo $row1["VehiclesType"]; ?></option>
        <?php
    }
} else {

    $query2 = "SELECT VehiclesType FROM tblmastervehicles WHERE NOT VehiclesType = 'Mpv' AND status = 'Active' GROUP BY VehiclesType ASC";
    $result2 = mysql_query($query2);
    ?>

    <option value=""></option>
    <?php while($row2=mysql_fetch_array($result2)) {?>
        <option value="<?php echo $row2["VehiclesType"]; ?>"><?php echo $row2["VehiclesType"]; ?></option>
        <?php
    }
}
?>
