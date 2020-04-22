<?php
error_reporting(0);

include('lib/conn.php');
include('lib/function.php');

$db = new DBConnection;
?>
<head>
    <title>Administrative Portal | User Login</title>
    <link rel="stylesheet" href="css/stylelogin.css" type="text/css">

</head>
<body>
     <?php
        $err = $_REQUEST['err'];

        switch($err){
           case 1 :
                 $msg = "Sila masukkan ID Pengguna dan Kata Laluan";
                 break;
               case 2 :
                 $msg = "ID Pengguna atau Kata Laluan tidak sah";	 
                 break;  
        }
      ?>
    <div class="mobile-screen">
  <div class="header">
   <h1>Log in</h1>
  </div>
         
        <ul class="tab">
  <li id="li_tab1" onclick="tab('tab1')"><a>User</a></li>
            
<li id="li_tab2" onclick="tab('tab2')"><a>Admin</a></li>           
        </ul>
 
        <!--This is the user form-->
<div id="tab1" >
    <br>
    <h3>User</h3>
	 <span class="alert" style="color:red;font-weight:bold"><?php echo $msg; ?></span>
 <form id="login-form" role="form" action="loginAction.php" method="post">
    <input type="text" name="employeeNo" placeholder="Employee No" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="submit" value="Log In" name="login" class="login-btn button">
  </form>
    
  <div class="other-choices">
      <div class="choices" id="newUser">
          <a href="register.php">
              <p class="choices-text">New User</p>
          </a>
      </div>
  </div>
      </div>
<!--///////////////////////////////////////////////\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\-->

                <!--This is the admin form-->
 <div id="tab2" style="display: none;">
      <br>
     
     <h3>Admin</h3>
     
            <form id="login-form" role="form" action="loginAction2.php" method="post">   

        <select id="UserName" name="username" placeholder="Username"  required>
          <option value="" ></option>
<?php
         /* mysql_connect("localhost","root","");
          mysql_select_db("reservationdb");
          */

          
          $sqlUser = "SELECT UserName FROM admin ORDER BY UserName DESC";
            $radmin = mysql_query($sqlUser);

				while ( ( $rowAdm = mysql_fetch_array($radmin) ) != false ) { 
				?>
				<option  value="<?php echo $rowAdm['UserName']; ?>">
                    <?php echo $rowAdm['UserName'];  ?></option>
          
				        <?php } // close while ?>
        
                </select> 
    <input type="password" name="password" placeholder="Password">
    <input type="submit" value="Log In" name="Alogin" class="login-btn button">
  </form>
</div> 
    </div>
    
</body>


<script type="text/javascript">
function tab(tab) {
document.getElementById('tab1').style.display = 'none';
document.getElementById('tab2').style.display = 'none';
document.getElementById('li_tab1').setAttribute("class", "");
document.getElementById('li_tab2').setAttribute("class", "");
document.getElementById(tab).style.display = 'block';
document.getElementById('li_'+tab).setAttribute("class", "active");
}
</script>