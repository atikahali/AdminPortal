<?php
error_reporting(1);

$db = new DBConnection;

session_start();

if($_SESSION['Mlogin']){
    $sql = "SELECT * FROM manager WHERE ManagerNo = '".$_SESSION['Mlogin']."'";
    $rst = mysql_query($sql);
    if (mysql_num_rows($rst) > 0) {
        while($row = mysql_fetch_assoc($rst)){
            $manager = $row["manager"];
        }
    }
}
?>
<div class="brand clearfix">
	<a href="?a=dashboard" style="font-size: 20px;">Admin e-Booking Portal | Manager Panel</a>
    <span class="menu-btn"><i class="fa fa-bars"></i></span>
    <ul class="ts-profile-nav">
        <li class="ts-account">
            <a href="#"><?php echo $manager;?><i class="fa fa-angle-down hidden-side"></i></a>
            <ul>
                <li><a href="?m=profile-setting"><i class="fa fa-cogs"></i>&nbsp;&nbsp; Profile Setting</a></li>
                <li><a href="../logout.php"><i class="fa fa-sign-out"></i>&nbsp;&nbsp; Logout</a></li>
            </ul>
        </li>
    </ul>
</div>
