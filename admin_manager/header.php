<div class="brand clearfix">
    <a href="?a=dashboard" style="font-size: 20px;">Admin e-Booking Portal | Admin Manager Panel</a>
    <span class="menu-btn"><i class="fa fa-bars"></i></span>
    <ul class="ts-profile-nav">
        <li class="ts-account">
            <a href="#"><?php echo $_SESSION['AMlogin']; ?><i class="fa fa-angle-down hidden-side"></i></a>
            <ul>
                <li><a href="?a=change-password"><i class="fa fa-lock"></i>&nbsp;&nbsp; Change password</a></li>
                <li><a href="../logout.php"><i class="fa fa-sign-out"></i>&nbsp;&nbsp; Logout</a></li>
            </ul>
        </li>
    </ul>
</div>
