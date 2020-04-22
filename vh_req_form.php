<?php
error_reporting(1);

$db = new DBConnection;

session_start();

if (isset($_POST['submit'])) {
    $passenger = "";
    if (isset($_POST["passenger"]) && is_array($_POST["passenger"])) {
        $passenger = implode(", ", $_POST["passenger"]);
    }

    //the original data
    $UserEmployeeNo = $_SESSION['login'];
    $fromDate = $_POST['date1'];
    $toDate = $_POST['date2'];
    $departTime = $_POST['DepartTime'];
    $returnTime = $_POST['ReturnTime'];
    $VehiclesType = $_POST['VehiclesType'];
    $passengers = strtoupper($passenger);
    $pax = $_POST['pax'];
    $Requisition = strtoupper($_POST['Requisition']);
    $Destination = strtoupper($_POST['Destination']);

    // Additional data
    $driverName = strtoupper($_POST['driverName']);
    $driveremployeeNo = strtoupper($_POST['driveremployeeNo']);
    $driverPosition = $_POST['driverPosition'];
    $driverDepartment = $_POST['driverDepartment'];
    $expiredLicense = $_POST['expiredLicense'];
    $status = 0;
    $pick = $_POST['pick'];
    $timestamp = date("Y-m-d H:i:s");

    if(preg_match('/[\'^£$%&*()}{#~?><>|=_+¬-]/', $passengers)) {
        echo "<script>alert('Invalid Passengers Name.');</script>";
        redirect('?p=vh_req_form');

    } else {
        if ($pick == 'yes'){
            $sql1 = "INSERT INTO tbl_vbooking(UserEmployeeNo, FromDate, ToDate, DepartTime, ReturnTime, VehiclesType, Pax, Requisition, Destination, Passengers, PostingDate)
            VALUES ('" . $UserEmployeeNo . "', '" . $fromDate . "', '" . $toDate . "', '" . $departTime . "', '" . $returnTime . "', '" . $VehiclesType . "', '" . $pax . "', '" . $Requisition . "', '". $Destination ."', '" . $passengers . "', '" . $timestamp . "')";
            $rsIns1 = $db->query($sql1);

            if ($rsIns1 == true) {
                notifyEmailM($UserEmployeeNo, $status);

                echo "<script>alert('Booking successful.');</script>";
                redirect('?p=vh_history');
            } else {
                echo "<script>alert('Something went wrong. Please try again.');</script>";
                redirect('?p=vh_req_form');
            }
        } else {
            $sql2 = "INSERT INTO tbl_vbooking(DriverName, DriverEmployeeNo, DriverPosition, DriverDepartment, ExpiredLicense, PostingDate, UserEmployeeNo, FromDate, ToDate, DepartTime, ReturnTime, VehiclesType, Pax, Requisition, Destination, Passengers)
            VALUES ('" . $driverName . "', '" . $driveremployeeNo . "', '" . $driverPosition . "', '" . $driverDepartment . "', '" . $expiredLicense . "', '" . $timestamp . "', '" . $UserEmployeeNo . "', '" . $fromDate . "', '" . $toDate . "', '" . $departTime . "', '" . $returnTime . "', '" . $VehiclesType . "', '" . $pax . "', '" . $Requisition . "', '". $Destination ."', '" . $passengers . "')";
            $rsIns2 = $db->query($sql2);

            if ($rsIns2 == true) {
                notifyEmailM($UserEmployeeNo, $status);

                echo "<script>alert('Booking successful.');</script>";
                redirect('?p=vh_history');
            } else {
                echo "<script>alert('Something went wrong. Please try again.');</script>";
                redirect('?p=vh_req_form');
            }
        }
    }
}

?>

<h2 class="page-title">Apply Reservation Vehicle</h2>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">Form field</div>
<div class="panel-body">
    <form method="post" class="form-horizontal" enctype="multipart/form-data" action="?p=vh_req_form" name="array_token">
        <!--******************************************** ROW 1 ******************************************************************************-->
        <!-- Date -->
        <div class="form-group">
            <label class="col-sm-2 control-label">Start Date: <span style="color:red">*</span></label>
            <div class="col-sm-3">
                <?php
                $timezone = "Asia/Malaysia";
                date_default_timezone_set($timezone);
                $date1 = date("Y-m-d");
                ?>
                <input type="date" name="date1" value="<?php echo $date1; ?>" class="form-control" required>
                <script>
                    var today = new Date().toISOString().split('T')[0];
                    document.getElementsByName("date1")[0].setAttribute('min', today);
                </script>
            </div>

            <label class="col-sm-4 control-label">End Date: <span style="color:red">*</span></label>
            <div class="col-sm-3">
                <?php
                $timezone = "Asia/Malaysia";
                date_default_timezone_set($timezone);
                $date2 = date("Y-m-d");
                ?>
                <input type="date" name="date2" value="<?php echo $date2; ?>" class="form-control" required>
                <script>
                    var today = new Date().toISOString().split('T')[0];
                    document.getElementsByName("date2")[0].setAttribute('min', today);
                </script>
            </div>
        </div>

        <!-- Time -->
        <div class="form-group">
            <label class="col-sm-2 control-label">Depart Time: <span style="color:red">*</span></label>
            <div class="col-sm-3">
                <input type="time" name="DepartTime" class="form-control" required>
            </div>

            <label class="col-sm-4 control-label">Return Time: <span style="color:red">*</span></label>
            <div class="col-sm-3">
                <input type="time" name="ReturnTime" class="form-control" required>
            </div>
        </div>
<!--**************************************************************************************************************************-->
<!--****************************************** ROW 2 ********************************************************************************-->
        <!--Pax-->
        <div class="form-group">
        <label class="col-sm-2 control-label">No. of Pax: <span style="color:red">*</span></label>
        <div class="col-sm-3">
            <select onChange="getVehicle(this.value);" class="form-control" name="pax" id="amount" required >
                <option value="">Select Pax</option>
                <?php
                for($i=1; $i<=13; $i++) {
                ?>
                    <option value="<?php echo $i;?>"><?php echo $i;?></option>
                <?php } ?>
            </select>

            <label class="control-label" style="color: red"><span style="color:red">*</span>Minimum 5 paxs for Mpv</label>
        </div>

        <!--Vehicles-->
        <label class="col-sm-4 control-label">Type of Vehicle: <span style="color:red"> *</span></label>
        <div class="col-sm-3">
            <select name="VehiclesType" id="VehiclesType-list" class="form-control" required>
                <option value="">Select No. of Pax</option>
            </select>
            <script>
                function getVehicle(val) {
                    $.ajax({
                        type: "POST",
                        url: "vh_get_VehiclesType.php",
                        data:'type_id='+val,
                        success: function(data){
                            $("#VehiclesType-list").html(data);
                        }
                    });
                }
                function selectBrand(val) {
                    $("#search-box").val(val);
                    $("#suggesstion-box").hide();
                }
            </script>
        </div>
    </div>
<!--**************************************************************************************************************************-->
<!--******************************************* ROW 3 *******************************************************************************-->
    <!--Passenger's name-->
        <div class="form-group">
            <!--hidden pax name-->
            <div class="" id="groups">
            </div>
        </div>
<!--**************************************************************************************************************************-->
<!--******************************************* ROW 4 *******************************************************************************-->
        <!--Purpose  -->
        <div class="form-group">
            <label class="col-sm-2 control-label">Purpose: <span style="color:red">*</span></label>
            <div class="col-sm-4">
                <input name="Requisition" type="textfield" class="form-control" required>
            </div>

            <label class="col-sm-2 control-label">Destination: <span style="color:red">*</span></label>
            <div class="col-sm-4">
                <input name="Destination" type="textfield" class="form-control" required>
            </div>
        </div>
<!--**************************************************************************************************************************-->
    <br>
<!--********************************////////// Additional Information \\\\\\\\\\*************************************************-->
    <!-- Radiobutton -->
    <label class=""> Do you require a company driver?</label>
    <div class="Radiobutton">
        <input type="radio" name="pick" onchange="showYes(this)" value="yes" class=" control-label">Yes
        <input type="radio" name="pick" onchange="showNo(this)" value="no" class=" control-label">No
    </div>
    <br>

    <div id="yes"> </div>
    <div id="no" style="display: none">
<!--******************************************* ROW 5 *******************************************************************************-->
    <div>
        <h4>Driver Information (if not company driver)</h4><br>
            <div class="form-group">
                <label class="col-sm-2 control-label">Name:</label>
                <div class="col-sm-4">
                    <input class="form-control" type='text' id='no' name='driverName' required>
                </div>

                <label class="col-sm-2 control-label">Employee No:</label>
                <div class="col-sm-4">
                    <input class="form-control" type='text' id='no' name='driveremployeeNo' required>
                </div>
            </div>
<!--**************************************************************************************************************************-->
<!--******************************************* ROW 6 *******************************************************************************-->
         <div class="form-group">
            <label class="col-sm-2 control-label">Position:</label>
            <div class="col-sm-4">
                <select id="no" name="driverPosition" class="form-control" required>
                    <option value="" >Select Position</option>
                    <?php
                    /*mysql_connect("localhost","root","");
                    mysql_select_db("reservationdb");*/

                    $sql = "SELECT pstId, position FROM position ORDER BY position ASC";
                    $radmin = mysql_query($sql);

                    while ( ( $rowAdm = mysql_fetch_array($radmin) ) != false ) {
                        ?>
                        <option  value="<?php echo $rowAdm['position']; ?>">
                            <?php echo $rowAdm['position'];  ?></option>

                    <?php } // close while ?>
                </select>
            </div>

            <label class="col-sm-2 control-label">Department:</label>
            <div class="col-sm-4">
                <select id="no" name="driverDepartment" class="form-control" required>
                    <option value="" >Select Department</option>
                    <?php
                    /*mysql_connect("localhost","root","");
                    mysql_select_db("reservationdb");*/

                    $sql = "SELECT dpmtCode, department FROM department ORDER BY department ASC";
                    $radmin = mysql_query($sql);

                    while ( ( $rowAdm = mysql_fetch_array($radmin) ) != false ) {
                        ?>
                        <option  value="<?php echo $rowAdm['department']; ?>">
                            <?php echo $rowAdm['department'];  ?></option>

                    <?php } // close while ?>
                </select>
            </div>
         </div>
<!--**************************************************************************************************************************-->
<!--******************************************* ROW 7 *******************************************************************************-->
         <div class="form-group">
            <label class="col-sm-2 control-label">Expiry date of license(D): </label>
            <div class="col-sm-4">
                <input class="form-control" type='date' id='acc' name='expiredLicense' required>
            </div>
        </div>
    </div>
    <!--         <div  id="no" style="display: none">-->
    <div>
        <!-- ////////// EMPTY FORM \\\\\\\\\\ -->
    </div>
    </div>
 <!--**************************************************************************************************************************-->
<!--************************************************* SUBMIT BUTTON *************************************************************************-->
    <div class="form-group">
        <div class="col-sm-8 col-sm-offset-2">
            <button class="btn btn-primary" name="submit" type="submit" value="submit" style="font-size: 15px;">Confirm Reservation</button>
        </div>
    </div>
<!--**************************************************************************************************************************-->
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
<!--*************************************** RADIO BUTTON ***********************************************************************************-->
<script type="text/javascript">
    //driver needed
    function showNo(x)
    {
        var nodes = document.getElementById("yes").getElementsByTagName('*');
        for(var i = 0; i < nodes.length; i++)
        {
             nodes[i].disabled = true;
        }
        
        var nodes2 = document.getElementById("no").getElementsByTagName('*');
        for(var i = 0; i < nodes2.length; i++)
        {
             nodes2[i].disabled = false;
        }
        
        if (x.checked)
        {
            document.getElementById('yes').style.display = 'none';
            document.getElementById('no').style.display = 'initial';
        }
    }
    
    function showYes(x)
    {
        var nodes = document.getElementById("no").getElementsByTagName('*');
        for(var i = 0; i < nodes.length; i++)
        {
             nodes[i].disabled = true;
        }
        
        var nodes2 = document.getElementById("yes").getElementsByTagName('*');
        for(var i = 0; i < nodes2.length; i++)
        {
             nodes2[i].disabled = false;
        }
        
        if (x.checked)
        {
            document.getElementById('no').style.display = 'none';
            document.getElementById('yes').style.display = 'initial';
        }
    }       
</script>
<!--**************************************************************************************************************************-->
<!--****************************************** PASSENGER ********************************************************************************-->
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

//passengger name
function createHTML(number){
	var group = '';
  for(var i=1;i<=number;i++){
    group += '<div id="group">' +
      '<input type="hidden" name="array_token" value="{{{ csrf_token() }}}" />'+
      '<label class="col-sm-2 control-label">Passenger Name '+i+': <span style="color:red"> * </span></label>'+
        '<div class="col-sm-4">'+'<br>'+
      '<input type="text" id="passenger'+i+'" name="passenger[]" class="form-control"  autocomplete="off" onkeydown="testForEnter();">'+
      '</div>'+
      '</div>';
 
  }
     
  $('#groups').append(group);
}
</script>
<!--**************************************************************************************************************************-->
</body>
</html>
<?php /*}*/ ?>