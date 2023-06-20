<?php
$date=$_GET['date'];
$long=$_GET['longitude'];
$lat=$_GET['latitude'];

if (isset($data)){
    $liga = mysqli_connect('localhost', 'root', 'root', 'RTL');
    $verifica = mysqli_query($liga, "INSERT INTO GPS (date,longitude,latitude) values ($date,$long,$lat)");
    echo  "INSERT INTO GPS (date,longitude,latitude) values ($data,$long,$lat)";
}
echo $date . $long . $lat;
?>
