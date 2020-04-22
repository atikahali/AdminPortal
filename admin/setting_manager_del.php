<?php
error_reporting(1);

$db = new DBConnection;

session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $result = mysql_query('SELECT manager.id, manager.ManagerNo, manager.IC, manager.manager, manager.email, position.position, manager.category, department.department, 
                    company.company, manager.status, manager.createdBy, manager.createdDate, manager.modifiedBy, manager.modifiedDate
                    FROM manager, position, department, company
                    WHERE position.pstId = manager.position AND department.dpmtCode = manager.department 
                    AND company.cmpCode = manager.company AND manager.id = ' . $id . '');

    if (mysql_num_rows($result) > 0) {
        // output data of each row
        $row = mysql_fetch_assoc($result);
        $id = $_GET['id'];
        $ManagerNo = $row['ManagerNo'];
        $IC = $row['IC'];
        $manager = $row['manager'];
        $company = $row['company'];
        $department = $row['department'];
        $position = $row['position'];
        $email = $row['email'];
        $category = $row['category'];
        $status = $row['status'];
        $modifiedBy = $row['modifiedBy'];
        $modifiedDate = $row['modifiedDate'];
    } else {
        echo "<script>alert('No data found.');</script>";
    }
}

if (isset($_POST['submit'])) {

    $id = $_GET['id'];
    $ManagerNo = $_POST['ManagerNo'];
    $IC = $_POST['IC'];
    $manager = $_POST['manager'];
    $company = $_POST['company'];
    $department = $_POST['department'];
    $position = $_POST['position'];
    $email = $_POST['email'];
    $category = $_POST['category'];
    $status = $_POST['status'];
    $modifiedBy = $_POST['modifiedBy'];
    $modifiedDate = $_POST['modifiedDate'];

    $sql = "DELETE FROM manager WHERE id = '$id'";
    if ($rst = mysql_query($sql)) {
        echo "<script>alert('Manager details is deleted successfully.');</script>";
        { redirect('?a=setting_manager'); }
    } else {
        echo "<script>alert('Please try again.');</script>";
    }

}
?>
<h2 class="page-title">Delete Manager</h2>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">Form field</div>
            <!--**************************************************************************************************************************-->
            <div class="panel-body">
                <!--**************************************************************************************************************************-->
                <form method="post" class="form-horizontal" enctype="multipart/form-data" >
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Name: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <input name="manager" type="textfield" value="<?php echo $row["manager"]?>" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Employee Number: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <input name="ManagerNo" type="textfield" value="<?php echo $row["ManagerNo"]?>" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">IC Number: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <input name="IC" type="textfield" value="<?php echo $row["IC"]?>" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Email: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <input name="email" type="textfield" value="<?php echo $row["email"]?>" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Position: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <select name="position" class="form-control" disabled>
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
                        <label class="col-sm-2 control-label">Category: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <select name="category" class="form-control" disabled>
                                <option value="" selected="selected"><?php echo $row["category"]?></option></br>
                                <option value="CEO">CEO</option></br>
                                <option value="GMC">GMC</option></br>
                                <option value="GM">GM</option></br>
                                <option value="SM">SM</option></br>
                                <option value="M">M</option></br>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Department: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <select name="department" class="form-control" disabled>
                                <option value="" ><?php echo $row["department"]?></option>
                                <?php

                                $sql = "SELECT dpmtId, department FROM department ORDER BY department ASC";
                                $radmin = mysql_query($sql);

                                while ( ( $rowAdm = mysql_fetch_array($radmin) ) != false ) {
                                    ?>
                                    <option  value="<?php echo $rowAdm['dpmtId']; ?>">
                                        <?php echo $rowAdm['department'];  ?></option>

                                <?php } // close while ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Company: <span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <select name="company" class="form-control" disabled>
                                <option value="" ><?php echo $row["company"]?></option>
                                <?php

                                $sql = "SELECT cmpCode, company FROM company ORDER BY company ASC";
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
                            <select name="status" class="form-control" disabled>
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
