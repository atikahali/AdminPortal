<?php
error_reporting(1);

$db = new DBConnection;

session_start();

if($_SESSION['Mlogin']){
    $sql = "SELECT manager.manager, manager.Ic, manager.ManagerNo, manager.email, position.position, department.department, company.company
        FROM manager, position, department, company
        WHERE position.pstId = manager.position AND department.dpmtCode = manager.department AND company.cmpCode = manager.company 
        AND manager.ManagerNo = '".$_SESSION['Mlogin']."'";
    $rst = mysql_query($sql);
    if (mysql_num_rows($rst) > 0) {
        while($row = mysql_fetch_assoc($rst)){
            $manager = $row['manager'];
            $Ic = $row['Ic'];
            $ManagerNo = $row['ManagerNo'];
            $email = $row['email'];
            $position = $row['position'];
            $department= $row['department'];
            $company = $row['company'];
        }
    }
}

if (isset($_POST['submit'])) {
    $ManagerNo = $_GET['ManagerNo'];
    $position = $_POST['position'];
    $department= $_POST['department'];
    $company = $_POST['company'];
    $modifiedBy = $_POST['modifiedBy'];

    $sql = "UPDATE manager SET position = '$position', department = '$department', company = '$company', modifiedBy = '".$_SESSION['Mlogin']."' WHERE ManagerNo = '".$_SESSION['Mlogin']."'";
    if ($rst = mysql_query($sql)) {
        echo "<script>alert('The user details is edited successful.');</script>";
        { redirect('?m=dashboard'); }
    } else {
        echo "<script>alert('Please try again.');</script>";
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
                            <input name="manager" type="textfield" value="<?php echo $manager; ?>" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Ic No: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <input name="Ic" type="textfield" value="<?php echo $Ic; ?>" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Employee No: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <input name="ManagerNo" type="textfield" value="<?php echo $ManagerNo; ?>" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Email: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <input name="email" type="textfield" value="<?php echo $email; ?>" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Position: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <select id="position" name="position" class="form-control" required>
                                <option value="" ><?php echo $position; ?></option>
                                <?php
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
                        <label class="col-sm-2 control-label">Department: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <select id="department" name="department" class="form-control" required>
                                <option value="" ><?php echo $department; ?></option>
                                <?php
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
                            <select id="company" name="company" class="form-control" required>
                                <option value="" ><?php echo $company; ?></option>
                                <?php
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