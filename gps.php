<?php
$date=$_GET['date'];
$long=$_GET['longitude'];
$lat=$_GET['latitude'];

if (isset($date)){
  echo $sql;
    $liga = mysqli_connect('localhost', 'root', 'root', 'RTL');
    $sql = mysqli_query($liga, "INSERT INTO gps (Data,Longitude,Latitude) values ('" . $date . "','" . $long ."','". $lat . "')");
    if ($liga->query($sql) === TRUE) {
    echo "Dados inseridos";
   } 
    echo  "INSERT INTO gps (Data,Longitude,Latitude) values ('$date','$long','$lat')";
}
echo $date . $long . $lat;
?>
