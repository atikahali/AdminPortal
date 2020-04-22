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
                            WHERE tbl_mbooking_r.status = "Booked" AND tbl_mbooking_r.id = ' . $no . '');

    if (mysql_num_rows($result) > 0) {

        // output data of each row
        $row = mysql_fetch_assoc($result);
        $id = $row['id'];
        $purpose = $row['purpose'];
        $dateStart = $row['dateStart'];
        $dateEnd = $row['dateEnd'];
        $timeStart = $row['timeStart'];
        $timeEnd = $row['timeEnd'];
        $description = $row['description'];
        $drink = $row['drink'];
        $pax = $row['pax'];
    } else {
        echo "<script>alert('No data found.');</script>";
    }
}

if (isset($_POST['submit'])) {

    $no = $_GET['no'];
    $status = $_POST['status'];
    $modifiedBy = $_POST['modifiedBy'];

    $sql = "UPDATE tbl_mbooking_r SET status = '$status', modifiedBy = '".$_SESSION['login']."' WHERE id = '$no'";
    if ($rst = mysql_query($sql)) {
        echo "<script>alert('The reservation is cancelled successful.');</script>";
        { redirect('?p=mt_history'); }
    } else {
        echo "<script>alert('Please try again.');</script>";
    }
}
?>

<h2 class="page-title">Room Reservation</h2>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">Form field</div>
            <div class="panel-body">
                <form method="post" class="form-horizontal" enctype="multipart/form-data" >
                    <!--Purpose-->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Purpose: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <input name="purpose" type="textfield" value="<?php echo $purpose?>" class="form-control" disabled="disabled">
                        </div>
                    </div>

                    <!-- Date -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Start Date: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <input name="bookingDate" type="date" value="<?php echo $dateStart ?>" class="form-control" disabled="disabled">
                        </div>

                        <label class="col-sm-2 control-label">End Date: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <input name="bookingDate" type="date" value="<?php echo $dateEnd ?>" class="form-control" disabled="disabled">
                        </div>
                    </div>

                    <!-- Time -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Start Time: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <input name="timeStart" type="time" step="" value="<?php echo $timeStart?>" class="form-control" onchange="return tConvert(tm)" disabled="disabled">
                        </div>
                        <script>
                            $(function(){
                                $('#time').combodate({
                                    firstItem: 'name', //show 'hour' and 'minute' string at first item of dropdown
                                    minuteStep: 1
                                });
                            });
                        </script>
                        <label class="col-sm-2 control-label">End Time: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <input name="timeEnd" type="time" step="" value="<?php echo $timeEnd?>" class="form-control" onchange="return tConvert(tm)" disabled="disabled">
                        </div>
                    </div>

                    <!--Room-->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Type of Room: <span style="color:red">*</span></label>
                        <div class="col-sm-15">
                            <select name="room" class="form-control" disabled="disabled">
                                <option value="" selected="selected"><?php echo $row['description']; ?></option></br>
                            </select>
                        </div>
                    </div>

                    <!--Drink-->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Type of Drink: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <select name="drink" placeholder="" class="form-control" disabled="disabled">
                                <option value="" selected="selected"><?php echo $row['drink']; ?></option></br>
                            </select>
                        </div>
                    </div>

                    <!--Pax-->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">No. of Pax : <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <select class="form-control" name="pax" disabled="disabled" >
                                <option value="" selected="selected"><?php echo $row['pax']; ?></option></br>
                            </select>
                        </div>
                    </div>

                    <div class="form-group" hidden>
                        <label class="col-sm-2 control-label" >Status: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <input name="status" type="textfield" value="Cancel" class="form-control" >
                        </div>
                    </div>

                    <!--Button-->
                    <div class="form-group">
                        <div class="col-sm-8 col-sm-offset-2">
                            <button class="btn btn-primary" name="submit" type="submit" value="submit" style="width: 100px; height: 45px; font-size: 15px;">Cancel</button>
                        </div>
                    </div>
                </form>
                <button class="btn btn-primary" name="back" type="submit" value="back" style="font-size: 15px;" onclick="goBack()"><i class="fa fa-chevron-left" style='font-size:15px'></i> &nbsp;Back</button>
                <script>
                    function goBack() {
                        window.history.back();
                    }
                </script>
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