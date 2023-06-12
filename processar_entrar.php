<?php
$email=$_POST['email'];
$senha=$_POST['senha'];

if (isset($email) && isset($senha)){ 
  $liga=mysqli_connect('localhost','root','root','RTL');
  $verifica = mysqli_query($liga,"SELECT * FROM utilizadores WHERE email='$email'");
  if (mysqli_num_rows($verifica) > 0 ){
    echo "Utilizador Existente!!!";
  }
  else {
    echo "<h1>Utilizador não Existente</h1>";
  }
}

?>
