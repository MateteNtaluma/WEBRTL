<!DOCTYPE html>
<html>

<head>
  <title>Perfil do Usuário</title>
  <style>
    /* Estilos gerais do corpo da página */
    body {
      font-family: Arial, sans-serif;
      background-color: #686767;
      color: #ffffff;
      margin: 0;
      padding: 0;
    }

    /* Estilos do cabeçalho do perfil */
    .profile-header {
      background-color: #686767;
      padding: 20px;
      text-align: center;
      color: #fff;
    }

    .profile-header h1 {
      font-size: 36px;
      margin-bottom: 10px;
    }

    .profile-header p {
      font-size: 18px;
      color: #fff;
      margin-top: -10px;
    }

    /* Estilos do conteúdo do perfil */
    .profile-content {
      margin: 20px;
    }

    .profile-content p {
      font-size: 16px;
      margin-bottom: 10px;
    }

    .profile-content .label {
      font-weight: bold;
    }

    .profile-content .data {
      background-color: transparent;
      color: #fff;
    }

    /* Estilos do rodapé do perfil */
    .profile-footer {
      text-align: center;
      margin-top: 30px;
    }

    .profile-footer a {
      display: inline-block;
      background-color: #0099cc;
      color: rgb(255, 255, 255);
      padding: 10px 20px;
      text-decoration: none;
      border-radius: 5px;
    }

    /* Estilos do logotipo do perfil */
    .profile-logo {
      text-align: center;
      padding: 10px;
    }

    .profile-logo img {
      max-width: 150px;
      height: auto;
      border-radius: 50%;
      border: none;
    }

    /* Estilos do avatar do perfil */
    .profile-avatar {
      position: absolute;
      top: 20px;
      left: 20px;
      width: 80px;
      height: 80px;
      border-radius: 50%;
      overflow: hidden;
    }

    .profile-avatar img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    /* Estilos do campo de senha */
    .password-field {
      position: relative;
    }

    .password-field input[type="password"] {
      padding-right: 30px;
      border-radius: 5%;
    }

    .password-field .toggle-password {
      position: absolute;
      top: 50%;
      right: 10px;
      transform: translateY(-50%);
      cursor: pointer;
      color: #888;
    }

    .password-field .toggle-password:hover {
      color: #333;
    }

    /* Estilos do campo de upload de avatar */
    .profile-avatar input[type="file"] {
      display: none;
    }

    .profile-avatar label {
      position: relative;
      display: inline-block;
      width: 80px;
      height: 80px;
      border-radius: 50%;
      overflow: hidden;
      cursor: pointer;
    }

    .profile-avatar label::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      opacity: 0;
      transition: opacity 0.3s;
    }

    .profile-avatar label:hover::before {
      opacity: 1;
    }

    .profile-avatar label img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
  </style>
</head>

<body>
  <?php
  $email = $_COOKIE['RTL'];

  if (isset($email)) {
    $liga = mysqli_connect('localhost', 'root', 'root', 'RTL');
    $verifica = mysqli_query($liga, "SELECT * FROM utilizadores WHERE email='$email'");
    $linha = mysqli_fetch_array($verifica);
  } else {
    header("Location: HTML.RTL.Entrar.html");
  }
  ?>
  <div class="profile-header">
    <div class="profile-avatar">
      <label for="avatar-upload">
        <img src="placeholder.png" alt="Avatar">
      </label>
      <input type="file" id="avatar-upload">
    </div>
    <div class="profile-logo">
      <img src="RTL.png" alt="Logo">
    </div>
    <h1>Perfil do Usuário</h1>
    <p>Bem-vindo(a) de volta!</p>
  </div>
  <div class="profile-content">
    <p><span class="label">Nome:</span> <span class="data" id="nome-usuario">
        <?php echo $linha['nome']; ?>
      </span></p>
    <p><span class="label">Email:</span> <span class="data" id="email-usuario"><?php echo $linha['email']; ?></span></p>
    <p><span class="label">Telefone:</span> <span class="data" id="telefone-usuario"><?php echo $linha['telefone']; ?></span></p>
    <p><span class="label">Data de Nascimento:</span><?php echo $linha['data_nascimento']; ?><span class="data" id="data-nascimento-usuario"></span></p>
    <p><span class="label">Último Login:</span> <span class="data" id="ultimo-login-usuario"><?php echo $linha['ultimo']; ?></span></p>
    <div class="password-field">
      <label for="password">Senha:</label>
      <input type="password" id="password" value="<?php echo $linha['pass']; ?>">
      <span class="toggle-password">Mostrar</span>
    </div>
  </div>
  <div class="profile-footer">
    <a href="/">Inicio</a>
  </div>
  <script>
    // Alternar visibilidade da senha
    var passwordInput = document.getElementById("password");
    var togglePassword = document.querySelector(".toggle-password");

    togglePassword.addEventListener("click", function () {
      if (passwordInput.type === "password") {
        passwordInput.type = "text";
        togglePassword.textContent = "Ocultar";
      } else {
        passwordInput.type = "password";
        togglePassword.textContent = "Mostrar";
      }
    });
  </script>
</body>

</html>
