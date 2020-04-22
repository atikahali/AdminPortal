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
                                    WHERE tblroom.roomId = tbl_mbooking_r.room AND
                                    tbl_mbooking_r.status = "Booked" AND tbl_mbooking_r.id = ' . $no . '');

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
        $status = $row['status'];
    } else {
        echo "<script>alert('No data found.');</script>";
    }
}

if (isset($_POST['submit'])) {

    $no = $_GET['no'];
    $purpose = strtoupper($_POST['purpose']);
    $drink = $_POST['drink'];
    $pax = $_POST['pax'];
    $timestamp = date("Y-m-d H:i:s");

    $sql = "UPDATE tbl_mbooking_r SET purpose = '$purpose', drink = '$drink', pax = '$pax', modifiedBy = '".$_SESSION['login']."', modifiedDate = '$timestamp' WHERE id = '$no'";
    if ($rst = mysql_query($sql)) {
        echo "<script>alert('The reservation is edited successful.');</script>";
        { redirect('?p=mt_history'); }
    } else {
        echo "<script>alert('Please try again.');</script>";
        { redirect('?p=mt_history'); }
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
                        <div class="col-sm-15">
                            <input name="purpose" type="textfield" value="<?php echo $row["purpose"]?>" class="form-control" required>
                        </div>
                    </div>

                    <!-- Date -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Start Date: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <input name="dateStart" type="date" value="<?php echo $row["dateStart"]?>" class="form-control" disabled>
                            <script>
                                var today = new Date().toISOString().split('T')[0];
                                document.getElementsByName("dateStart")[0].setAttribute('min', today);
                            </script>
                        </div>

                        <label class="col-sm-2 control-label">End Date: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <input name="dateEnd" type="date" value="<?php echo $row["dateEnd"]?>" class="form-control" disabled>
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
                            <input name="timeStart" type="time" value="<?php echo $row["timeStart"]?>" class="form-control" disabled>
                        </div>

                        <label class="col-sm-2 control-label">End Time: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <input name="timeEnd" type="time" value="<?php echo $row["timeEnd"]?>" class="form-control" disabled>
                        </div>
                    </div>

                    <!--Room-->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Type of Room: <span style="color:red">*</span></label>
                        <div class="col-sm-15">
                            <select id="room" name="room" class="form-control" disabled>
                                <option value="" ><?php echo $row['description']; ?></option>
                                <?php
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
    if(number >= 4){
        group += '<div id="group">' +
            //      '<h1 style=" font-size: 14px;color: rgb(0, 0, 0);"><u>PASSENGERS DETAILS : '+i+'</u></h1>'+
            '<input type="hidden" name="array_token" value="{{{ csrf_token() }}}" />'+


            '<label class="col-sm-2 control-label">Type of Drink: <span style="color:red">*</span></label>'+
            '<div class="col-sm-4">'+'<br>'+
            '<select id="drink" name="drink" class="form-control" required>'+
            '<option value="" selected="selected">Select</option></br>'+
            '<option value="None">None</option></br>\n' +
            '<option value="Coffee">Coffee</option></br>\n' +
            '<option value="Tea">Tea</option></br>\n' +
            '<option value="Coffee and Tea">Both</option></br>\n' +
            '</select>'+
            '</div>'+
            '</div>';
    }else{
        group += '<div id="group">' +
            //      '<h1 style=" font-size: 14px;color: rgb(0, 0, 0);"><u>PASSENGERS DETAILS : '+i+'</u></h1>'+
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