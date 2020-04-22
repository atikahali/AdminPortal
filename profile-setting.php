<?php
error_reporting(1);

$db = new DBConnection;

session_start();

if($_SESSION['login']){
    $sql = "SELECT tblusers.FullName, tblusers.EmployeeNo, tblusers.Email, position.position, manager.manager, department.department, company.company
            FROM tblusers, position, manager, department, company
            WHERE position.pstId = tblusers.Position AND manager.ManagerNo = tblusers.Manager AND department.dpmtCode = tblusers.Department 
            AND company.cmpCode = tblusers.Company AND tblusers.EmployeeNo = '".$_SESSION['login']."'";
    $rst = mysql_query($sql);
    if (mysql_num_rows($rst) > 0) {
        while($row = mysql_fetch_assoc($rst)){
            $EmployeeNo = $row['EmployeeNo'];
            $FullName = $row['FullName'];
            $Email = $row['Email'];
            $position = $row['position'];
            $manager = $row['manager'];
            $department= $row['department'];
            $company = $row['company'];
        }
    }
}

if (isset($_POST['submit'])) {

    $EmployeeNo = $_GET['EmployeeNo'];
    $Position = $_POST['Position'];
    $Manager = $_POST['Manager'];
    $Department = $_POST['Department'];
    $Company = $_POST['Company'];
    $modifiedBy = $_POST['modifiedBy'];

    $sql = "UPDATE tblusers SET Position = '$Position', Manager = '$Manager', Department = '$Department', Company = '$Company', modifiedBy = '".$_SESSION['login']."' WHERE EmployeeNo = '".$_SESSION['login']."'";
    if ($rst = mysql_query($sql)) {
        echo "<script>alert('The user details is edited successfully.');</script>";
        { redirect('?p=user_dashboard'); }
    }
}
?>
<h2 class="page-title">Profile Setting</h2>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">Form field</div>
            <div class="panel-body">
                <!--**************************************************************************************************************************-->
                <form method="post" class="form-horizontal" enctype="multipart/form-data" >
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Full Name: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <input name="FullName" type="textfield" value="<?php echo $FullName; ?>" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Employee No: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <input name="EmployeeNo" type="textfield" value="<?php echo $EmployeeNo; ?>" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Email: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <input name="Email" type="textfield" value="<?php echo $Email; ?>" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Position: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <select id="Position" name="Position" class="form-control" required>
                                <option value="" ><?php echo $position; ?></option>
                                <?php
                                /*mysql_connect("localhost","root","");
                                mysql_select_db("reservationdb");*/

                                $sql = "SELECT pstId, position FROM position WHERE pstStatus = 'Active' ORDER BY position ASC";
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
                        <label class="col-sm-2 control-label">N + 1: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <select id="Manager" name="Manager" class="form-control" required>
                                <option value="" ><?php echo $manager; ?></option>
                                <?php
                                /*mysql_connect("localhost","root","");
                                mysql_select_db("reservationdb");*/

                                $sql = "SELECT ManagerNo, manager FROM manager WHERE status = 'Active' ORDER BY manager ASC";
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
                            <select id="Department" name="Department" class="form-control" required>
                                <option value="" ><?php echo $department; ?></option>
                                <?php
                                /*mysql_connect("localhost","root","");
                                mysql_select_db("reservationdb");*/

                                $sql = "SELECT dpmtCode, department FROM department WHERE dpmtStatus = 'Active' ORDER BY department ASC";
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
                            <select id="Company" name="Company" class="form-control" required>
                                <option value="" ><?php echo $company; ?></option>
                                <?php
                                /*mysql_connect("localhost","root","");
                                mysql_select_db("reservationdb");*/

                                $sql = "SELECT cmpCode, company FROM company WHERE cmpStatus = 'Active' ORDER BY company ASC";
                                $radmin = mysql_query($sql);

                                while ( ( $rowAdm = mysql_fetch_array($radmin) ) != false ) {
                                    ?>
                                    <option  value="<?php echo $rowAdm['cmpCode']; ?>">
                                        <?php echo $rowAdm['company'];  ?></option>

                                <?php } // close while ?>
                            </select>
                        </div>
                    </div>

                    <!--Button-->
                    <div class="form-group">
                        <div class="col-sm-8 col-sm-offset-2">
                            <button class="btn btn-primary" name="submit" type="submit" value="submit" style="width: 100px; height: 45px; font-size: 15px;">Save</button>
                        </div>
                    </div>
                </form>
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
