<?php
$liga = mysqli_connect('localhost', 'root', 'root', 'RTL');

// Verifica se a conexão foi realizada com sucesso
if ($liga === false) {
  die("Erro na conexão: " . mysqli_connect_error());
}

// Verifica o método da requisição
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Se o método da requisição for POST, significa que adicionamos uma nova localização

  // Obter a data e hora atual
  $data = date('Y-m-d H:i:s');

  // Faz a inserção no banco de dados
  $sql = "INSERT INTO gps (data) VALUES ('$data')";
  $result = $liga->query($sql);

  // Verifica se a inserção foi bem-Realizada
  if ($result === false) {
    die("Erro ao inserir a nova localização: " . $liga->error);
  }

  // Prepara os dados da nova localização para retornar ao JavaScript
  $novaLocalizacao = array(
    'data' => $data,
    'localizacao' => '',
    'latitude' => '',
    'longitude' => '',
  );

  // Converte os dados para o formato JSON e retorna a resposta ao JavaScript
  echo json_encode([$novaLocalizacao]);
} else {
  // Se o método da requisição for GET, significa que iremos obter o histórico da localizações

  // Executa a consulta para selecionar todas as localizações da tabela "gps"
  $sql = "SELECT * FROM gps";
  $result = $liga->query($sql);

  // Verifica se a consulta foi bem-Realizada
  if ($result === false) {
    die("Erro na consulta: " . $liga->error);
  }

  // Array onde estão armazenadas as localizações
  $dadosLocalizacao = array();

  // Verifica se existem registros retornados pela consulta
  if ($result->num_rows > 0) {
    // Itera sobre cada registro retornado
    while ($row = $result->fetch_assoc()) {
      $latitude = $row['latitude'];
      $longitude = $row['longitude'];
      $data = $row['dt'];

      // Faz a solicitação à API de geocodificação para obter o nome do local
      // Substitua {API_KEY} pelo seu valor de chave de API válida
      $geocodingAPIURL = "https://maps.googleapis.com/maps/api/geocode/json?latlng=" . $latitude . "," . $longitude . "&key=AIzaSyBf2a8jJFDPp9gPOzdi9tirTZKomFjTmZc";

      // Faz a solicitação à API de geocodificação
      $geocodingResponse = file_get_contents($geocodingAPIURL);
      if ($geocodingResponse === false) {
        die("Erro ao obter a resposta da API de geocodificação");
      }

      // Descodifica a resposta JSON da API de geocodificação
      $geocodingData = json_decode($geocodingResponse);

      // Extrair o nome do local da resposta
      $locationName = '';
      if ($geocodingData && isset($geocodingData->results) && count($geocodingData->results) > 0) {
        $locationName = $geocodingData->results[0]->formatted_address;
      }

      // Adiciona os dados da localização ao array
      $dadosLocalizacao[] = array(
        'data' => $data,
        'localizacao' => $locationName,
        'latitude' => $latitude,
        'longitude' => $longitude,
      );
    }
  }
