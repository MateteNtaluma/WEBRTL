<?php
$data=$_GET['data'];
$long=$_GET['longitude'];
$lat=$_GET['latitude'];

if (isset($data)){
    $liga = mysqli_connect('localhost', 'root', 'root', 'RTL');
    $verifica = mysqli_query($liga, "INSERT INTO GPS (data,longitude,latitude) values ($data,$long,$lat)");
    echo  "INSERT INTO GPS (data,longitude,latitude) values ($data,$long,$lat)";
}
echo $data . $long . $lat;
?>
