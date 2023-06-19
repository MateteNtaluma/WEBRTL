<?php
// Variaveis do registo html
$nome = $_POST['nome_completo'];
$telefone = $_POST['telefone'];
$nascimento = $_POST['data_nascimento'];
$email = $_POST['email_registo'];
$pass = $_POST['senha_registo'];

if (isset($nome) && isset($telefone) && isset($nascimento) && isset($email) && isset($pass)) {
  $liga = mysqli_connect('localhost', 'root', '', 'RTL');
  $sql = "INSERT INTO utilizadores (id, email, nome, telefone, data_nascimento, pass) VALUES (NULL, '$email','$nome','$telefone','$nascimento','$pass')";
  if ($liga->query($sql) === TRUE) {
    // Mudar para a página que pretende ir
    // header("Location: ddd.html");
    echo "Utilizador Registado";
  } else {
    echo "Erro: " . $sql . "<br>" . $conn->error;
  }
}
else {
  header("Location: HTML.RTL.Entrar.html");
}
?>
