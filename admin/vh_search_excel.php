<?php
error_reporting(1);

$db = new DBConnection;

session_start();

//export.php
$output = '';
if(isset($_GET['date1']) && isset($_GET['date2']))  {
    $date1 = $_GET['date1'];
    $date2 = $_GET['date2'];

    $query = "SELECT tblusers.FullName, tblusers.EmployeeNo, manager.manager, position.position, department.department, company.company, tbl_vbooking.VehiclesType,
                tbl_vbooking.bookingId, tbl_vbooking.FromDate, tbl_vbooking.ToDate,
                 TIME_FORMAT(tbl_vbooking.DepartTime,'%h:%i %p') as DepartTime, TIME_FORMAT(tbl_vbooking.ReturnTime,'%h:%i %p') as ReturnTime, tbl_vbooking.Pax, tbl_vbooking.Passengers,
                tbl_vbooking.Requisition, tbl_vbooking.Destination, tbl_vbooking.Status, tbl_vbooking.Remark, tbl_vbooking.DriverName, tbl_vbooking.VehiclesPlateNo, tbl_vbooking.VehiclesBrand, tbl_vbooking.Issuance, tbl_vbooking.FuelCard, 
                tbl_vbooking.PostingDate, tbl_vbooking.DriverEmployeeNo, tbl_vbooking.DriverDepartment, DATE_FORMAT(tbl_vbooking.expiredLicense, '%d-%m-%Y') as expiredLicense
                FROM tbl_vbooking, tblusers, department, company, position, manager
                WHERE manager.ManagerNo = tblusers.Manager AND position.pstId = tblusers.Position AND tblusers.EmployeeNo = tbl_vbooking.UserEmployeeNo AND department.dpmtCode = tblusers.Department AND company.cmpCode = tblusers.Company
                AND ((tbl_vbooking.FromDate BETWEEN '$date1' AND '$date2') AND (tbl_vbooking.ToDate BETWEEN '$date1' AND '$date2'))
                ORDER BY tbl_vbooking.FromDate DESC";
    $result = mysql_query($query);
    if(mysql_num_rows($result) > 0)
    {
        $output .= '
                    <table class="table" bordered="1">  
                    <tr>  
                        <th>Name</th>
                        <th>Department</th>
                        <th>Destination</th>
                        <th>Vehicle Plate No</th>
                        <th>Depart Date</th>
                        <th>Depart Time</th>
                        <th>Return Date</th>
                        <th>Return Time</th>
                        <th>Driver Name</th>
                        <th>Pax</th>
                        <th>Fuel Card</th>
                        <th>Status</th>
                    </tr>
                  ';
        while($row = mysql_fetch_array($result))
        {
            $Status = $row["Status"];
            if ($Status == '0'){
                $Status = 'PENDING';
            } elseif ($Status == '1'){
                $Status = 'MANAGER APPROVE';
            } elseif ($Status == '2'){
                $Status = 'MANAGER REJECT';
            } elseif ($Status == '3'){
                $Status = 'ADMIN APPROVE';
            } elseif ($Status == '4'){
                $Status = 'ADMIN REJECT';
            } elseif ($Status == '5'){
                $Status = 'SUCCESSFUL';
            } elseif ($Status == '6'){
                $Status = 'REJECTED';
            }
            $output .= '
                        <tr>  
                             <td>'.$row["FullName"].'</td>  
                             <td>'.$row["department"].'</td>  
                             <td>'.$row["Destination"].'</td>  
                             <td>'.$row["VehiclesPlateNo"].'</td>  
                             <td>'.$row["FromDate"].'</td>
                             <td>'.$row["DepartTime"].'</td>
                             <td>'.$row["ToDate"].'</td>    
                             <td>'.$row["ReturnTime"].'</td>  
                             <td>'.$row["DriverName"].'</td>  
                             <td>'.$row["Pax"].'</td>
                             <td>'.$row["FuelCard"].'</td>  
                             <td>'.$Status.'</td>
                        </tr>
                       ';
        }
        $output .= '</table>';
        $filename = "Report_".date("d_m_Y").".xls";
        //header('Content-Type: text/csv');
        //header('Content-Disposition: attachment; filename="'.$filename.'";');
        header('Content-Type: application/xls');
        header('Content-Disposition: attachment; filename="'.$filename.'";');
        echo $output;
    }
}
?>