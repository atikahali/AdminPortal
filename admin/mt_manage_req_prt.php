<?php
error_reporting(1);

$db = new DBConnection;

session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $result = mysql_query('SELECT tblusers.FullName, tblusers.EmployeeNo, position.position, department.department, company.company,
        tbl_mbooking_r.id, tbl_mbooking_r.purpose, tbl_mbooking_r.dateStart, tbl_mbooking_r.dateEnd, 
        tbl_mbooking_r.timeStart, tbl_mbooking_r.timeEnd, tblroom.description, 
        tbl_mbooking_r.drink, tbl_mbooking_r.pax, tbl_mbooking_r.status 
    FROM tblusers, tbl_mbooking_r, tblroom, department, company, position
    WHERE position.pstId = tblusers.Position AND tblusers.EmployeeNo = tbl_mbooking_r.EmployeeNo AND tblroom.roomId = tbl_mbooking_r.room AND department.dpmtCode = tblusers.Department AND company.cmpCode = tblusers.Company AND tbl_mbooking_r.id = ' . $id . '');

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
?>

<h2 class="page-title">Room Reservation</h2>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">Form field</div>
            <div class="panel-body">

                <!--**************************************************************************************************************************-->
                <form method="post" class="form-horizontal" enctype="multipart/form-data" >
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Name: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <?php echo $row["FullName"]?>
                        </div>

                        <label class="col-sm-2 control-label">Position: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <?php echo $row["position"]?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Department: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <?php echo $row["department"]?>
                        </div>

                        <label class="col-sm-2 control-label">Company: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <?php echo $row["company"]?>
                        </div>
                    </div>

                    <!--Purpose-->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Purpose: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <?php echo $row["purpose"]?>
                        </div>
                    </div>

                    <!-- Date -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Start Date: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <?php echo date("d-m-Y", strtotime($dateStart)); ?>
                        </div>

                        <label class="col-sm-2 control-label">End Date: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <?php echo date("d-m-Y", strtotime($dateEnd)); ?>
                        </div>
                    </div>

                    <!-- Time -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Start Time: <span style="color:red">*</span></label>
                        <div class="col-sm-2">
                            <?php echo date("h:i A", strtotime($timeStart)); ?>
                        </div>

                        <label class="col-sm-4 control-label">End Time: <span style="color:red">*</span></label>
                        <div class="col-sm-2">
                            <?php echo date("h:i A", strtotime($timeEnd)); ?>
                        </div>
                    </div>

                    <!--Room-->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Type of Room: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <?php echo $row["description"]?>
                        </div>
                    </div>

                    <div class="form-group">
                        <!--Pax-->
                        <label class="col-sm-2 control-label">No. of pax: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <?php echo $row["pax"]?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Drink: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <?php echo $row["drink"]?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Status: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <?php echo $row["status"]?>
                        </div>
                    </div>
                    <script>
                        window.print();
                    </script>
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