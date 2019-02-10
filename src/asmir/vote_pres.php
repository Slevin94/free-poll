<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
#Diese page sollte optimalerweiße nicht seperat sein sondern teil von vote-result werden
$username = "andreas";
$password = "yF1K^R6Jqh8IbK9";
$dbname = "freepoll";
$servername = "localhost";
$con=mysqli_connect("localhost","$username","$password","$dbname");
session_start();
$id_des_polls = $_SESSION["poll-id"];

$sql = "SELECT * FROM poll_option WHERE poll_id = '$id_des_polls'";
$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        echo $row["option_name"] . " hat " . $row["count"] . " Stimmen " . "<br>";
    }
} else {
    echo "No Results for your Query";
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>
        Create Google Charts
    </title>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
        google.load("visualization", "1", {packages:["corechart"]});
        google.setOnLoadCallback(drawChart);
        function drawChart() {

            var data = google.visualization.arrayToDataTable([
                ['Browser', 'Visits'],
                <?php
                $query = "SELECT * FROM poll_option WHERE poll_id = '$id_des_polls'";

                $exec = mysqli_query($con,$query);
                while($row = mysqli_fetch_array($exec)){

                    echo "['".$row['option_name']."',".$row['count']."],";
                }
                ?>
            ]);

            var options = {
                title: 'Grafische Darstellung: '
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);
        }
    </script>
</head>
<body>
<div id="piechart" style="width: 900px; height: 500px;"></div>
</body>
</html>