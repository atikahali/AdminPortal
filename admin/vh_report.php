<?php
error_reporting(1);

$db = new DBConnection;

session_start();
?>
<html>
<head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['bar']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = google.visualization.arrayToDataTable([
                //Edit Data Here
                ['Vehicle', 'Frequency'],
                <?php
                $query = "SELECT tbl_vbooking.VehiclesBrand, tbl_vbooking.VehiclesPlateNo, COUNT(tbl_vbooking.VehiclesPlateNo) as CountVehicle FROM tbl_vbooking WHERE NOT tbl_vbooking.VehiclesPlateNo = 'NULL' AND tbl_vbooking.Status = '5' GROUP BY tbl_vbooking.VehiclesPlateNo ORDER BY tbl_vbooking.VehiclesBrand ASC ";
                $result = mysql_query($query);
                while ($row = mysql_fetch_assoc($result)){
                    echo "['".$row['VehiclesBrand']."' + ' - ' + '".$row['VehiclesPlateNo']."',".$row['CountVehicle']."],";
                }
                ?>
            ]);

            var options = {
                chart: {
                    title: 'Vehicle Used Frequency', //Title
                    //subtitle: 'Vehicle Used',
                }
            };

            var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

            chart.draw(data, google.charts.Bar.convertOptions(options));
        }
    </script>
</head>
<body>
    <div id="columnchart_material" style="width: 900px; height: 500px;"></div>
    <button class="btn btn-primary" name="back" type="submit" value="back" style="font-size: 15px;" onclick="goBack()"><i class="fa fa-chevron-left" style='font-size:15px'></i> &nbsp;Back</button>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</body>
</html>