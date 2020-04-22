<?php
error_reporting(1);

$db = new DBConnection;

session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $result = mysql_query('SELECT tblusers.id, tblusers.FullName, tblusers.EmployeeNo, tblusers.Position, position.position, manager.manager, department.department, company.company, 
                            tblusers.Email, tblusers.RegDate, tblusers.status 
                        FROM tblusers, position, manager, department, company
                        WHERE position.pstId = tblusers.Position AND manager.ManagerNo = tblusers.Manager AND department.dpmtCode = tblusers.Department AND company.cmpCode = tblusers.Company AND tblusers.id = ' . $id . '');

    if (mysql_num_rows($result) > 0) {
        // output data of each row
        $row = mysql_fetch_assoc($result);
        $id = $row['id'];
        $FullName = $row['FullName'];
        $EmployeeNo = $row['EmployeeNo'];
        $Position = $row['Position'];
        $Manager = $row['Manager'];
        $Department = $row['Department'];
        $Company = $row['Company'];
        $Email = $row['Email'];
        $status = $row['status'];
    } else {
        echo "<script>alert('No data found.');</script>";
    }
}

if (isset($_POST['submit'])) {

    $id = $_GET['id'];
    $FullName = strtoupper($_POST['FullName']);
    $EmployeeNo = strtoupper($_POST['EmployeeNo']);
    $Position = $_POST['Position'];
    $Manager = $_POST['Manager'];
    $Department = $_POST['Department'];
    $Company = $_POST['Company'];
    $Email = strtolower($_POST['Email']);
    $status = $_POST['status'];
    $modifiedBy = $_POST['modifiedBy'];

    $sql = "DELETE FROM tblusers WHERE id = '$id'";
    if ($rst = mysql_query($sql)) {
        echo "<script>alert('The user details is deleted successful.');</script>";
        { redirect('?a=setting_users'); }
    } else {
        echo "<script>alert('Please try again.');</script>";
    }

}
?>
<h2 class="page-title">Delete User Details</h2>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">Form field</div>
            <!--**************************************************************************************************************************-->
            <div class="panel-body">
                <!--**************************************************************************************************************************-->
                <form method="post" class="form-horizontal" enctype="multipart/form-data" >
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Full Name: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <input name="FullName" type="textfield" value="<?php echo $row["FullName"]?>" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Employee No: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <input name="EmployeeNo" type="textfield" value="<?php echo $row["EmployeeNo"]?>" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Email: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <input name="Email" type="email" value="<?php echo $row["Email"]?>" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Position: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <select name="Position" class="form-control" disabled>
                                <option value="" ><?php echo $row["position"]?></option>
                                <?php
                                $sql = "SELECT pstId, position FROM position ORDER BY position ASC";
                                $radmin = mysql_query($sql);

                                while ( ( $rowAdm = mysql_fetch_array($radmin) ) != false ) {
                                    ?>
                                    <option  value="<?php echo $rowAdm['pstId']; ?>">
                                        <?php echo $rowAdm['position'];  ?></option>

                                <?php } // close while ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Manager: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <select name="Manager" class="form-control" disabled>
                                <option value="" ><?php echo $row["manager"]?></option>
                                <?php
                                $sql = "SELECT ManagerNo, manager FROM manager ORDER BY manager ASC";
                                $radmin = mysql_query($sql);

                                while ( ( $rowAdm = mysql_fetch_array($radmin) ) != false ) {
                                    ?>
                                    <option  value="<?php echo $rowAdm['ManagerNo']; ?>">
                                        <?php echo $rowAdm['manager'];  ?></option>

                                <?php } // close while ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Department: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <select name="Department" class="form-control" disabled>
                                <option value="" ><?php echo $row["department"]?></option>
                                <?php
                                $sql = "SELECT dpmtCode, department FROM department ORDER BY department ASC";
                                $radmin = mysql_query($sql);

                                while ( ( $rowAdm = mysql_fetch_array($radmin) ) != false ) {
                                    ?>
                                    <option  value="<?php echo $rowAdm['dpmtCode']; ?>">
                                        <?php echo $rowAdm['department'];  ?></option>

                                <?php } // close while ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Company: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <select name="Company" class="form-control" disabled>
                                <option value="" ><?php echo $row["company"]?></option>
                                <?php
                                $sql = "SELECT cmpCode, company FROM company ORDER BY cmpCode ASC";
                                $radmin = mysql_query($sql);

                                while ( ( $rowAdm = mysql_fetch_array($radmin) ) != false ) {
                                    ?>
                                    <option  value="<?php echo $rowAdm['cmpCode']; ?>">
                                        <?php echo $rowAdm['company'];  ?></option>

                                <?php } // close while ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Status: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <select id="status" name="status" class="form-control" disabled>
                                <option value="" selected="selected"><?php echo $row["status"]?></option></br>
                                <option value="Active">Active</option></br>
                                <option value="Inactive">Inactive</option></br>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-8 col-sm-offset-2">
                            <button class="btn btn-primary" name="submit" type="submit" value="submit" style="width: 90px; height: 45px; font-size: 15px;">Delete</button>
                        </div>
                    </div>
                </form>
                <!--**************************************************************************************************************************-->

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