<?php
function msgAlert($msg) {
    echo"<script>window.alert(\"$msg\");</script>";
}

function redirect($url) {
    $path = $url;
    echo"<script>window.location=\"$path\"</script>";
}

function newWin($url) {
    $path = $url;
    echo"<script>window.open(\"$path\")</script>";
}

//From Admin to Manager
function notifyEmailM($EmployeeNo, $Status){
    $db = new DBConnection;

    $sql = "SELECT manager.email, manager.ManagerNo, manager.IC, tblusers.FullName, tblusers.Email, tbl_vbooking.PostingDate, tbl_vbooking.FromDate, tbl_vbooking.ToDate, 
            tbl_vbooking.DepartTime, tbl_vbooking.ReturnTime, tbl_vbooking.Requisition, tbl_vbooking.Destination, 
            tbl_vbooking.Status, tbl_vbooking.Pax 
            FROM manager, tblusers, tbl_vbooking
            WHERE tbl_vbooking.UserEmployeeNo = tblusers. EmployeeNo AND 
                    manager.ManagerNo = tblusers.Manager AND tblusers.EmployeeNo = '$EmployeeNo' ";
    $rs  = $db->query($sql);

    while (($row = $db->fetch($rs)) != false ) {
        $ManagerNo = $row['ManagerNo'];
        $IC = $row['IC'];
        $email = $row['email'];
        $FullName = $row['FullName'];
        $Email = $row['Email'];
        $PostingDate = $row['PostingDate'];
        $FromDate = $row['FromDate'];
        $ToDate = $row['ToDate'];
        $DepartTime = $row['DepartTime'];
        $ReturnTime = $row['ReturnTime'];
        $Requisition = $row['Requisition'];
        $Destination = $row['Destination'];
        $Status = $row['Status'];
        $Pax = $row['Pax'];
    }

    $newPostingDate = date("d-m-Y h:i A", strtotime($PostingDate));
    $newFromDate = date("d-m-Y", strtotime($FromDate));
    $newDepartTime = date("h:i A", strtotime($DepartTime));
    $newToDate = date("d-m-Y", strtotime($ToDate));
    $newReturnTime = date("h:i A", strtotime($ReturnTime));

    if ($rs == true) {
        if ($Status == '0') {
            $message = "<b>Requested by:</b> $FullName \r\n
                        <b>Requested on:</b> $newPostingDate \r\n
                        <b>Departure:</b> $newFromDate, $newDepartTime \r\n
                        <b>Return:</b> $newToDate, $newReturnTime \r\n
                        <b>Destination:</b> $Destination \r\n
                        <b>Purpose:</b> $Requisition \r\n
                        <b>Pax:</b> $Pax \r\n \r\n 
                        Please login to <a href='http://172.16.1.5/adminportal/index.php' target='_top'>Admin e-Booking Portal</a> by using your <b>Username:</b> $ManagerNo and <b>Password:</b> your IC No";
            $subject = "Admin e-Booking Portal: New Vehicle Reservation";
            $to = $email;

        }
        smtpmailer($to,nl2br($message),$subject);

    }
}

//From Admin to Admin
function notifyEmailA($EmployeeNo, $Status, $bookingId){
    $db = new DBConnection;

    $sql = "SELECT tblusers.FullName, tbl_vbooking.bookingId, tbl_vbooking.PostingDate, tbl_vbooking.FromDate, tbl_vbooking.ToDate, 
            tbl_vbooking.DepartTime, tbl_vbooking.ReturnTime, tbl_vbooking.Requisition, tbl_vbooking.Destination, 
            tbl_vbooking.Status, tbl_vbooking.Pax 
            FROM tblusers, tbl_vbooking
            WHERE tbl_vbooking.UserEmployeeNo = tblusers. EmployeeNo AND tblusers.EmployeeNo = '$EmployeeNo' AND tbl_vbooking.bookingId = '$bookingId' ";
    $rs  = $db->query($sql);

    while (($row = $db->fetch($rs)) != false ) {
        $bookingId = $row['bookingId'];
        $FullName = $row['FullName'];
        $PostingDate = $row['PostingDate'];
        $FromDate = $row['FromDate'];
        $ToDate = $row['ToDate'];
        $DepartTime = $row['DepartTime'];
        $ReturnTime = $row['ReturnTime'];
        $Requisition = $row['Requisition'];
        $Destination = $row['Destination'];
        $Status = $row['Status'];
        $Pax = $row['Pax'];

    }

    $newPostingDate = date("d-m-Y h:i A", strtotime($PostingDate));
    $newFromDate = date("d-m-Y", strtotime($FromDate));
    $newDepartTime = date("h:i A", strtotime($DepartTime));
    $newToDate = date("d-m-Y", strtotime($ToDate));
    $newReturnTime = date("h:i A", strtotime($ReturnTime));
    $to = 'adminportal@epicgroup.com.my';

    if ($rs == true) {
        if ($Status == '1'){
            $message = "<b>Requested by:</b> $FullName \r\n
                        <b>Requested on:</b> $newPostingDate \r\n
                        <b>Departure:</b> $newFromDate, $newDepartTime \r\n
                        <b>Return:</b> $newToDate, $newReturnTime \r\n
                        <b>Destination:</b> $Destination \r\n
                        <b>Purpose:</b> $Requisition \r\n
                        <b>Pax:</b> $Pax \r\n \r\n 
                        Reservation has been APPROVED by user N + 1. \r\n 
                        Please login to <a href='http://172.16.1.5/adminportal/index.php' target='_top'>Admin e-Booking Portal</a> for details.";
            $subject = "Admin e-Booking Portal: New Vehicle Reservation";
        }
        smtpmailer($to,nl2br($message),$subject);
    }
}

//From Admin to User
function notifyEmailU($EmployeeNo, $Status, $bookingId){
    $db = new DBConnection;

    $sql = "SELECT manager.email, manager.ManagerNo, manager.IC, tblusers.FullName, tblusers.Email, tbl_vbooking.bookingId, 
            tbl_vbooking.PostingDate, tbl_vbooking.FromDate, tbl_vbooking.ToDate, 
            tbl_vbooking.DepartTime, tbl_vbooking.ReturnTime, tbl_vbooking.Requisition, tbl_vbooking.Destination, 
            tbl_vbooking.Status, tbl_vbooking.Pax 
            FROM manager, tblusers, tbl_vbooking
            WHERE tbl_vbooking.UserEmployeeNo = tblusers. EmployeeNo AND 
                    manager.ManagerNo = tblusers.Manager AND tblusers.EmployeeNo = '$EmployeeNo' AND tbl_vbooking.bookingId = '$bookingId' ";
    $rs  = $db->query($sql);

    while (($row = $db->fetch($rs)) != false ) {
        $bookingId = $row['bookingId'];
        $ManagerNo = $row['ManagerNo'];
        $IC = $row['IC'];
        $email = $row['email'];
        $FullName = $row['FullName'];
        $Email = $row['Email'];
        $PostingDate = $row['PostingDate'];
        $FromDate = $row['FromDate'];
        $ToDate = $row['ToDate'];
        $DepartTime = $row['DepartTime'];
        $ReturnTime = $row['ReturnTime'];
        $Requisition = $row['Requisition'];
        $Destination = $row['Destination'];
        $Status = $row['Status'];
        $Pax = $row['Pax'];
    }

    $newPostingDate = date("d-m-Y h:i A", strtotime($PostingDate));
    $newFromDate = date("d-m-Y", strtotime($FromDate));
    $newDepartTime = date("h:i A", strtotime($DepartTime));
    $newToDate = date("d-m-Y", strtotime($ToDate));
    $newReturnTime = date("h:i A", strtotime($ReturnTime));

    if ($rs == true) {
        if ($Status == '2') {
            $message = "<b>Requested by:</b> $FullName \r\n
                        <b>Requested on:</b> $newPostingDate \r\n
                        <b>Departure:</b> $newFromDate, $newDepartTime \r\n
                        <b>Return:</b> $newToDate, $newReturnTime \r\n
                        <b>Destination:</b> $Destination \r\n
                        <b>Purpose:</b> $Requisition \r\n
                        <b>Pax:</b> $Pax \r\n \r\n 
                        Your Vehicle Reservation has been REJECTED by your N + 1. \r\n
                        Please login to <a href='http://172.16.1.5/adminportal/index.php' target='_top'>Admin e-Booking Portal</a> for details.";
            $subject = "Admin e-Booking Portal: Vehicle Reservation REJECTED";
            $to = $Email;

        } elseif ($Status == '4') {
            $message = "<b>Requested by:</b> $FullName \r\n
                        <b>Requested on:</b> $newPostingDate \r\n
                        <b>Departure:</b> $newFromDate, $newDepartTime \r\n
                        <b>Return:</b> $newToDate, $newReturnTime \r\n
                        <b>Destination:</b> $Destination \r\n
                        <b>Purpose:</b> $Requisition \r\n
                        <b>Pax:</b> $Pax \r\n \r\n 
                        Your Vehicle Reservation has been REJECTED by Administrator. \r\n
                        Please login to <a href='http://172.16.1.5/adminportal/index.php' target='_top'>Admin e-Booking Portal</a> for details.";
            $subject = "Admin e-Booking Portal: Vehicle Reservation REJECTED";
            $to = $Email;

        }
        smtpmailer($to,nl2br($message),$subject);

    }
}

//From Admin to Admin Manager
function notifyEmailAM($EmployeeNo, $Status, $bookingId){
    $db = new DBConnection;

    $sql = "SELECT tblusers.FullName, tbl_vbooking.bookingId, tbl_vbooking.PostingDate, tbl_vbooking.FromDate, tbl_vbooking.ToDate, 
            tbl_vbooking.DepartTime, tbl_vbooking.ReturnTime, tbl_vbooking.Requisition, tbl_vbooking.Destination, 
            tbl_vbooking.Status, tbl_vbooking.Pax 
            FROM tblusers, tbl_vbooking
            WHERE tbl_vbooking.UserEmployeeNo = tblusers. EmployeeNo AND tblusers.EmployeeNo = '$EmployeeNo' AND tbl_vbooking.bookingId = '$bookingId' ";
    $rs  = $db->query($sql);

    while (($row = $db->fetch($rs)) != false ) {
        $bookingId = $row['bookingId'];
        $FullName = $row['FullName'];
        $PostingDate = $row['PostingDate'];
        $FromDate = $row['FromDate'];
        $ToDate = $row['ToDate'];
        $DepartTime = $row['DepartTime'];
        $ReturnTime = $row['ReturnTime'];
        $Requisition = $row['Requisition'];
        $Destination = $row['Destination'];
        $Status = $row['Status'];
        $Pax = $row['Pax'];

    }

    $newPostingDate = date("d-m-Y h:i A", strtotime($PostingDate));
    $newFromDate = date("d-m-Y", strtotime($FromDate));
    $newDepartTime = date("h:i A", strtotime($DepartTime));
    $newToDate = date("d-m-Y", strtotime($ToDate));
    $newReturnTime = date("h:i A", strtotime($ReturnTime));
    $to = 'rokiah@epicgroup.com.my'; //Email Admin Manager

    if ($rs == true) {
        if ($Status == '3') {
            $message = "<b>Requested by:</b> $FullName \r\n
                            <b>Requested on:</b> $newPostingDate \r\n
                            <b>Departure:</b> $newFromDate, $newDepartTime \r\n
                            <b>Return:</b> $newToDate, $newReturnTime \r\n
                            <b>Destination:</b> $Destination \r\n
                            <b>Purpose:</b> $Requisition \r\n
                           <b>Pax:</b> $Pax \r\n
                          Your Vehicle Reservation has been APPROVED by Administrator. \r\n
                          Please login to <a href='http://172.16.1.5/adminportal/index.php' target='_top'>Admin e-Booking Portal</a> for details.";
         $subject = "Admin e-Booking Portal: Administrative Manager APPROVAL";

    }
        smtpmailer($to,nl2br($message),$subject);
    }
}

//From Admin Manager to User and Administrator
function notifyEmailUA($EmployeeNo, $Status, $bookingId){
    $db = new DBConnection;

    $sql = "SELECT manager.email, manager.ManagerNo, manager.IC, tblusers.FullName, tblusers.Email, tbl_vbooking.bookingId, 
            tbl_vbooking.PostingDate, tbl_vbooking.FromDate, tbl_vbooking.ToDate, 
            tbl_vbooking.DepartTime, tbl_vbooking.ReturnTime, tbl_vbooking.Requisition, tbl_vbooking.Destination, 
            tbl_vbooking.Status, tbl_vbooking.Pax 
            FROM manager, tblusers, tbl_vbooking
            WHERE tbl_vbooking.UserEmployeeNo = tblusers. EmployeeNo AND 
                    manager.ManagerNo = tblusers.Manager AND tblusers.EmployeeNo = '$EmployeeNo' AND tbl_vbooking.bookingId = '$bookingId' ";
    $rs  = $db->query($sql);

    while (($row = $db->fetch($rs)) != false ) {
        $bookingId = $row['bookingId'];
        $ManagerNo = $row['ManagerNo'];
        $IC = $row['IC'];
        $email = $row['email'];
        $FullName = $row['FullName'];
        $Email = $row['Email'];
        $PostingDate = $row['PostingDate'];
        $FromDate = $row['FromDate'];
        $ToDate = $row['ToDate'];
        $DepartTime = $row['DepartTime'];
        $ReturnTime = $row['ReturnTime'];
        $Requisition = $row['Requisition'];
        $Destination = $row['Destination'];
        $Status = $row['Status'];
        $Pax = $row['Pax'];
    }

    $newPostingDate = date("d-m-Y h:i A", strtotime($PostingDate));
    $newFromDate = date("d-m-Y", strtotime($FromDate));
    $newDepartTime = date("h:i A", strtotime($DepartTime));
    $newToDate = date("d-m-Y", strtotime($ToDate));
    $newReturnTime = date("h:i A", strtotime($ReturnTime));

    if ($rs == true) {
        if ($Status == '5') {
            $message = "<b>Requested by:</b> $FullName \r\n
                        <b>Requested on:</b> $newPostingDate \r\n
                        <b>Departure:</b> $newFromDate, $newDepartTime \r\n
                        <b>Return:</b> $newToDate, $newReturnTime \r\n
                        <b>Destination:</b> $Destination \r\n
                        <b>Purpose:</b> $Requisition \r\n
                        <b>Pax:</b> $Pax \r\n
                        Your Vehicle Reservation has been APPROVED. \r\n
                        Please login to <a href='http://172.16.1.5/adminportal/index.php' target='_top'>Admin e-Booking Portal</a> for details.";
            $subject = "Admin e-Booking Portal: Vehicle Reservation APPROVED";
            $to = $Email;

        } elseif ($Status == '6') {
            $message = "<b>Requested by:</b> $FullName \r\n
                        <b>Requested on:</b> $newPostingDate \r\n
                        <b>Departure:</b> $newFromDate, $newDepartTime \r\n
                        <b>Return:</b> $newToDate, $newReturnTime \r\n
                        <b>Destination:</b> $Destination \r\n
                        <b>Purpose:</b> $Requisition \r\n
                        <b>Pax:</b> $Pax \r\n \r\n 
                        Your Vehicle Reservation has been REJECTED. \r\n
                        Please login to <a href='http://172.16.1.5/adminportal/index.php' target='_top'>Admin e-Booking Portal</a> for details.";
            $subject = "Admin e-Booking Portal: Vehicle Reservation REJECTED";
            $to = $Email;

        }
        smtpmailers($to,nl2br($message),$subject);

    }
}


function smtpmailer($to,$message,$subject) {
    require 'PHPMailerAutoload.php';

    $mail = new PHPMailer;

    //$mail->SMTPDebug = 3;                               // Enable when to debug 3/4

    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'ssl://smtp.epicgroup.com.my';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'adminportal@epicgroup.com.my';                 // SMTP username
    $mail->Password = 'PA$$w0rd19';                           // SMTP password
    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 465;                                    // TCP port to connect to

    $mail->setFrom('adminportal@epicgroup.com.my', 'Admin e-Booking Portal');
    $mail->addAddress($to);     // Add a recipient

    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = $subject;
    $mail->Body    = $message;
    //$mail->AltBody = $message;

    if(!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Message has been sent';
    }
}

function smtpmailers($to,$message,$subject) {
    require 'PHPMailerAutoload.php';

    $mail = new PHPMailer;

    //$mail->SMTPDebug = 3;                               // Enable when to debug 3/4

    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'ssl://smtp.epicgroup.com.my';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'adminportal@epicgroup.com.my';                 // SMTP username
    $mail->Password = 'PA$$w0rd19';                           // SMTP password
    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 465;                                    // TCP port to connect to

    $mail->setFrom('adminportal@epicgroup.com.my', 'Admin e-Booking Portal');
    $mail->addAddress($to);     // Add a recipient
    $mail->addAddress('adminportal@epicgroup.com.my');

    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = $subject;
    $mail->Body    = $message;
    //$mail->AltBody = $message;

    if(!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Message has been sent';
    }
}
?>
