<?php
error_reporting(1);

$db = new DBConnection;

session_start();

if(isset($_POST['submit'])) {
    $UserEmployeeNo = $_SESSION['login'];
    $requestDate = $_POST['requestDate'];
    $purpose = strtoupper($_POST['purpose']);
    $dateStart = $_POST['dateStart'];
    $dateEnd = $_POST['dateEnd'];
    $timeStart = $_POST['timeStart'];
    $timeEnd = $_POST['timeEnd'];
    $room = $_POST['room'];
    $drink = $_POST['drink'];
    $pax = $_POST['pax'];
    $status = $_POST['status'];
    $timestamp = date("Y-m-d H:i:s");

    //Check Booking Exist
    $query = "SELECT dateStart, dateEnd, timeStart, timeEnd, room, status FROM tbl_mbooking_r
                WHERE (room = '$room' AND NOT (GREATEST ('{$timeStart}', '{$timeEnd}') < timeStart OR LEAST ('{$timeStart}', '{$timeEnd}') > timeEnd) 
                AND NOT (GREATEST ('{$dateStart}', '{$dateEnd}') < dateStart OR LEAST ('{$dateStart}', '{$dateEnd}') > dateEnd))";

    $result = mysql_query($query);
    $rowchk = mysql_num_rows($result);
    if (mysql_num_rows($result) > 0) {
        $row = mysql_fetch_assoc($result);
        $status = $row['status'];
    }
    if ($rowchk > 0 ) {
        if ($status == "Cancel") {
            $sql = "INSERT INTO tbl_mbooking_r (EmployeeNo, purpose, dateStart, dateEnd, timeStart, timeEnd, room, drink, pax, status, requestDate) 
                    VALUES ('" . $_SESSION['login'] . "', '$purpose', '$dateStart', '$dateEnd', '$timeStart', '$timeEnd', '$room', '$drink', '$pax', 'Booked', '$timestamp')";
            if (mysql_query($sql)) {
                echo "<script>alert('Booking success.');</script>";
                { redirect('?p=mt_history'); }
            } else {
                echo "Error: " . $sql . "<br>" . mysql_error();
            }
        } else {
            echo "<script>alert('Meeting Room already booked.');</script>";
            { redirect('?p=mt_req_form'); }
        }
    } else {
        $sql = "INSERT INTO tbl_mbooking_r (EmployeeNo, purpose, dateStart, dateEnd, timeStart, timeEnd, room, drink, pax, status, requestDate)
                    VALUES ('" . $_SESSION['login'] . "', '$purpose', '$dateStart', '$dateEnd', '$timeStart', '$timeEnd', '$room', '$drink', '$pax', '$status', '$timestamp')";
        if (mysql_query($sql)) {
            echo "<script>alert('Booking successful.');</script>";
            { redirect('?p=mt_history'); }
        } else {
            echo "Error: " . $sql . "<br>" . mysql_error();
        }
    }
}

?>

<h2 class="page-title">Apply Reservation Meeting Room</h2>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">Form field</div>
            <div class="panel-body">
                <form name="array_token" action="?p=mt_req_form" method="post" class="form-horizontal" enctype="multipart/form-data">
                    <!--******************************************** ROW 1 ******************************************************************************-->
                    <!--Purpose-->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Purpose: <span style="color:red">*</span></label>
                        <div class="col-sm-15">
                            <textarea name="purpose" type="textfield" id="purpose" class="form-control" required></textarea>
                        </div>
                    </div>

                    <!-- Date -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Start Date: <span style="color:red">*</span></label>
                        <?php
                        $timezone = "Asia/Malaysia";
                        date_default_timezone_set($timezone);
                        $today = date("Y-m-d");
                        ?>
                        <div class="col-sm-13">
                            <input name="dateStart" type="date" id="datepicker" value="<?php echo $today; ?>" class="form-control" required>
                        </div>
                        <script>
                            var today = new Date().toISOString().split('T')[0];
                            document.getElementsByName("dateStart")[0].setAttribute('min', today);
                        </script>

                        <label class="col-sm-14 control-label">End Date: <span style="color:red">*</span></label>
                        <?php
                        $timezone = "Asia/Malaysia";
                        date_default_timezone_set($timezone);
                        $today = date("Y-m-d");
                        ?>
                        <div class="col-sm-13">
                            <input name="dateEnd" type="date" id="datepicker" value="<?php echo $today; ?>" class="form-control" required>
                        </div>
                        <script>
                            var today = new Date().toISOString().split('T')[0];
                            document.getElementsByName("dateEnd")[0].setAttribute('min', today);
                        </script>
                        <label class="control-label" style="color: red; font-size: 12px;"><span style="color:red">*</span>Please book 2 days before the meeting date</label>

                    </div>

                    <!-- Time -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Start Time: <span style="color:red">*</span></label>
                        <div class="col-sm-13">
                            <input name="timeStart" type="time" class="form-control" min="08:00" required>
                        </div>

                        <label class="col-sm-14 control-label">End Time: <span style="color:red">*</span></label>
                        <div class="col-sm-13">
                            <input name="timeEnd" type="time" class="form-control" required>
                        </div>
                    </div>

                    <!--Room-->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Type of Room: <span style="color:red">*</span></label>
                        <div class="col-sm-15">
                            <select id="room" name="room" class="form-control"  required>
                                <option value="" >Select Room</option>
                                <?php
                                /*mysql_connect("localhost","root","");
                                mysql_select_db("adminportal");*/

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

                    <!--Pax-->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">No. of Pax: <span style="color:red">*</span></label>
                        <div class="col-sm-13">
                            <select class="form-control" name="pax" id="amount" required >
                                <option value="">Select Pax</option>
                                <?php
                                for($i=1; $i<=30; $i++) {
                                    ?>
                                    <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                    <?php
                                } ?>
                            </select>
                        </div>

                        <label class="control-label" style="color: red;font-size: 12px;"><span style="color:red">*</span>Minimum 4 paxs to request a drink</label>
                    </div>

                    <div class="form-group">
                        <!--hidden drink name-->
                        <div class="" id="groups">
                        </div>
                    </div>
                    <!--**************************************************************************************************************************-->
                    <!--Status Booking-->
                    <div class="form-group" hidden>
                        <label class="col-sm-2 control-label" >Status: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <input name="status" type="textfield" value="Booked" class="form-control">
                        </div>
                    </div>
                    <!--************************************************* SUBMIT BUTTON **********************************************************************-->

                    <div class="form-group">
                        <div class="col-sm-8 col-sm-offset-2">
                            <button class="btn btn-primary" name="submit" type="submit" value="submit" style="font-size: 15px;">Confirm Reservation</button>
                        </div>
                    </div>
                    <!--*************************************************************************************************************************-->
                </form>
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
<script>
$(document).ready(function(){
    //by default generate html based on the default selected value.
    $('#groups').empty();
    var number = parseInt($("#amount").val());
        createHTML(number);


    $('#amount').change(function(){
        $('#groups').empty();
        number = parseInt($(this).val());
        createHTML(number);
    });
});

function createHTML(number){
    var group = '';
    //limitation of drinks
    if(number >= 4){
        group += '<div id="group">' +
            //      '<h1 style=" font-size: 14px;color: rgb(0, 0, 0);"><u>PASSENGERS DETAILS : '+i+'</u></h1>'+
            '<input type="hidden" name="array_token" value="{{{ csrf_token() }}}" />'+
            '<label class="col-sm-2 control-label">Type of Drink: <span style="color:red">*</span></label>'+
            '<div class="col-sm-13">'+'<br>'+
            '<select id="drink" name="drink" class="form-control" required>'+
            '<option value="" selected="selected">Select Drink</option></br>'+
            '<option value="None">None</option></br>\n' +
            '<option value="Coffee">Coffee</option></br>\n' +
            '<option value="Tea">Tea</option></br>\n' +
            '<option value="Coffee and Tea">Both</option></br>\n' +
            '</select>'+
            '</div>'+
            '</div>';
    }else{
        group += '<div id="group">' +
            '<input type="hidden" name="array_token" value="{{{ csrf_token() }}}" />'+
            '<input id="drink" name="drink" value="None" hidden>'+
            '</div>';
    }

    $('#groups').append(group);
}
</script>

</body>
</html>
<?php /*}*/ ?>