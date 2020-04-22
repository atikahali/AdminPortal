<?php
error_reporting(1);

$db = new DBConnection;

session_start();
?>
<html>
<head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = google.visualization.arrayToDataTable([
                //Edit Data Here
                ['Room', 'Frequency'],
                <?php
                $query = "SELECT tblroom.description, COUNT(tblroom.description) as CountRoom FROM tbl_mbooking_r, tblroom WHERE tblroom.roomId = tbl_mbooking_r.room AND tbl_mbooking_r.status = 'Booked' GROUP BY tblroom.description ORDER BY tblroom.roomId ASC ";
                $result = mysql_query($query);
                while ($row = mysql_fetch_assoc($result)){
                    echo "['".$row['description']."',".$row['CountRoom']."],";
                }
                ?>
            ]);

            var options = {
                title: 'Room Used Frequency' //Title
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);
        }
    </script>
</head>
<body>
    <div id="piechart" style="width: 900px; height: 500px;"></div>
    <button class="btn btn-primary" name="back" type="submit" value="back" style="font-size: 15px;" onclick="goBack()"><i class="fa fa-chevron-left" style='font-size:15px'></i> &nbsp;Back</button>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</body>
</html>
