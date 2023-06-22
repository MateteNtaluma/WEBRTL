<?php
$nome=$_GET['nome'];
$data=$_GET['data'];
$long=$_GET['longitude'];
$lat=$_GET['latitude'];

if (isset($data)){
  echo "1";
    $liga = mysqli_connect('localhost', 'root', 'root', 'RTL');
  echo "2";
    $sql = mysqli_query($liga, "INSERT INTO gps (Data,Longitude,Latitude) values ('$data','$long','$lat')");
  echo "3";
    if ($liga->query($sql) === TRUE) {
    echo "Dados inseridos";
   } 
}
echo $data . $long . $lat;
?>
