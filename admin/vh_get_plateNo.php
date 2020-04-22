<?php
mysql_connect("localhost","adminportal","admin123");
mysql_select_db("adminportal");
session_start();
if(!empty($_POST["brand_id"])) {
        
    $query = "SELECT plateId, VehiclesPlateNo FROM tblmastervehicles WHERE status = 'Active' AND VehiclesBrand = '" . $_POST["brand_id"] . "'";
    $plate = mysql_query($query);
?>

<option value="">Select Plate No</option>
<?php while($row=mysql_fetch_array($plate)) {?>
    <option value="<?php echo $row["VehiclesPlateNo"]; ?>"><?php echo $row["VehiclesPlateNo"]; ?></option>
<?php
    }
}
?>
