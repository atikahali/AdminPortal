<?php
error_reporting(1);

$db = new DBConnection;

session_start();

if (isset($_GET['no'])) {
    $no = $_GET['no'];

    $result = mysql_query('SELECT tbl_mbooking_r.id, tbl_mbooking_r.purpose, tbl_mbooking_r.dateStart, tbl_mbooking_r.dateEnd, 
                                        tbl_mbooking_r.timeStart, tbl_mbooking_r.timeEnd, tblroom.description, 
                                        tbl_mbooking_r.drink, tbl_mbooking_r.pax, tbl_mbooking_r.status 
                                    FROM tbl_mbooking_r, tblroom
                                    WHERE tblroom.roomId = tbl_mbooking_r.room AND tbl_mbooking_r.status = "Booked" AND tbl_mbooking_r.id = ' . $no . '');

    if (mysql_num_rows($result) > 0) {
        // output data of each row
        $row = mysql_fetch_assoc($result);
        $id = $row['id'];
        $purpose = $row['purpose'];
        $dateStart = $row['dateStart'];
        $dateEnd = $row['dateEnd'];
        $timeStart = $row['timeStart'];
        $timeEnd = $row['timeEnd'];
        $room = $row['room'];
        $drink = $row['drink'];
        $pax = $row['pax'];
    } else {
        echo "<script>alert('No data found.');</script>";
    }
}

if (isset($_POST['submit'])) {

    $no = $_GET['no'];
    $purpose = $_POST['purpose'];
    $dateStart = $row['dateStart'];
    $dateEnd = $row['dateEnd'];
    $timeStart = $_POST['timeStart'];
    $timeEnd = $_POST['timeEnd'];
    $room = $_POST['room'];
    $drink = $_POST['drink'];
    $pax = $_POST['pax'];
    $modifiedBy = $_POST['modifiedBy'];
    $timestamp = date("Y-m-d H:i:s");

    $query = "SELECT id, dateStart, dateEnd, timeStart, timeEnd, room FROM tbl_mbooking_r
                WHERE (room = '$room' AND NOT (GREATEST ('{$timeStart}', '{$timeEnd}') < timeStart OR LEAST ('{$timeStart}', '{$timeEnd}') > timeEnd) 
                AND NOT (GREATEST ('{$dateStart}', '{$dateEnd}') < dateStart OR LEAST ('{$dateStart}', '{$dateEnd}') > dateEnd))
                AND id = '$no'";

    $result = mysql_query($query);
    $rowchk = mysql_num_rows($result);
    if (mysql_num_rows($result) > 0) {
        // output data of each row
        $row = mysql_fetch_assoc($result);
        $status = $row['status'];
    }
    if ($rowchk > 0 ) {
        if ($status == "Cancel"){
            $sql = "UPDATE tbl_mbooking_r SET purpose = '$purpose', dateStart = '$dateStart', dateEnd = '$dateEnd', timeStart = '$timeStart', timeEnd = '$timeEnd', room = '$room', drink = '$drink', pax = '$pax', modifiedBy = '".$_SESSION['Alogin']."', modifiedDate = '$timestamp' WHERE id = '$no'";
            if ($rst = mysql_query($sql)) {
                echo "<script>alert('The details is edited successfully.');</script>";
                { redirect('?a=mt_manage_req'); }
            } else {
                echo "<script>alert('Please try again.');</script>";
            }
        } else {
            echo "<script>alert('Meeting Room already booked.');</script>";
            { redirect('?a=mt_manage_req'); }
        }
    } else {
        $sql = "UPDATE tbl_mbooking_r SET purpose = '$purpose', dateStart = '$dateStart', dateEnd = '$dateEnd', timeStart = '$timeStart', timeEnd = '$timeEnd', room = '$room', drink = '$drink', pax = '$pax', modifiedBy = '".$_SESSION['Alogin']."', modifiedDate ='$timestamp' WHERE id = '$no'";
        if ($rst = mysql_query($sql)) {
            echo "<script>alert('The details is edited successfully.');</script>";
            { redirect('?a=mt_manage_req'); }
        } else {
            echo "<script>alert('Please try again.');</script>";
        }
    }
}
?>

<h2 class="page-title">Room Reservation</h2>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">Form field</div>
            <div class="panel-body">
                <!--**************************************************************************************************************************-->
                <form method="post" class="form-horizontal" enctype="multipart/form-data" >
                    <!--Purpose-->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Purpose: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <input name="purpose" type="textfield" value="<?php echo $row["purpose"]?>" class="form-control" required>
                        </div>
                    </div>

                    <!-- Date -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Start Date: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <input name="dateStart" type="date" value="<?php echo $row["dateStart"]?>" class="form-control" required>
                            <script>
                                var today = new Date().toISOString().split('T')[0];
                                document.getElementsByName("dateStart")[0].setAttribute('min', today);
                            </script>
                        </div>

                        <label class="col-sm-2 control-label">End Date: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <input name="dateEnd" type="date" value="<?php echo $row["dateEnd"]?>" class="form-control" required>
                            <script>
                                var today = new Date().toISOString().split('T')[0];
                                document.getElementsByName("dateEnd")[0].setAttribute('min', today);
                            </script>
                        </div>
                    </div>

                    <!-- Time -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Start Time: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <input name="timeStart" type="time" step="" value="<?php echo $row["timeStart"]?>" class="form-control" onchange="return tConvert(tm)" required>
                        </div>

                        <label class="col-sm-2 control-label">End Time: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <input name="timeEnd" type="time" step="" value="<?php echo $row["timeEnd"]?>" class="form-control" onchange="return tConvert(tm)" required>
                        </div>
                    </div>

                    <!--Room-->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Type of Room: <span style="color:red">*</span></label>
                        <div class="col-sm-5">
                            <select id="room" name="room" class="form-control" required>
                                <option value="" ><?php echo $row['description']; ?></option>
                                <?php
                                mysql_connect("localhost","root","");
                                mysql_select_db("adminportal");

                                $sql = "SELECT roomId, description FROM tblroom WHERE status = 'Active' ORDER BY roomId ASC";
                                $radmin = mysql_query($sql);

                                while ( ( $rowAdm = mysql_fetch_array($radmin) ) != false ) {
                                    ?>
                                    <option  value="<?php echo $rowAdm['roomId']; ?>">
                                        <?php echo $rowAdm['description'];  ?></option>

                                <?php } // close while ?>
                            </select>
                        </div>
                    </div>

                    <!--Drink-->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Type of Drink: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <select name="drink" placeholder="" class="form-control" required>
                                <option value="" selected="selected"><?php echo $row['drink']; ?></option></br>
                                <option value="None">None</option></br>
                                <option value="Coffee">Coffee</option></br>
                                <option value="Tea">Tea</option></br>
                                <option value="Coffee and Tea">Both</option></br>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <!--Pax-->
                        <label class="col-sm-2 control-label">No. of Pax: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <select class="form-control" name="pax" id="amount" required >
                                <option value=""><?php echo $row["pax"]?></option>
                                <?php
                                for($i=1; $i<=30; $i++) {
                                    ?>
                                    <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                    <?php
                                } ?>
                            </select>
                        </div>

                        <label class="control-label" style="color: red"><span style="color:red">*</span>Minimum 4 paxs to request a drink</label>
                    </div>

                    <div class="form-group">
                        <!--hidden drink name-->
                        <div class="" id="groups">
                        </div>
                    </div>

                    <!--Button-->
                    <div class="form-group">
                        <div class="col-sm-8 col-sm-offset-2">
                            <button class="btn btn-primary" name="submit" type="submit" value="submit" style="width: 90px; height: 45px; font-size: 15px;">Save</button>
                        </div>
                    </div>
                </form>
                <button class="btn btn-primary" name="back" type="submit" value="back" style="font-size: 15px;" onclick="goBack()"><i class="fa fa-chevron-left" style='font-size:15px'></i> &nbsp;Back</button>
                <script>
                    function goBack() {
                        window.history.back();
                    }
                </script>
                <!--**************************************************************************************************************************-->

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