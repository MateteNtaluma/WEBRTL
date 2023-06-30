<?php
$liga = mysqli_connect('20.71.94.247', 'root', 'root', 'RTL');

if ($liga === false) {
  die("Erro na conexão: " . mysqli_connect_error());
}

$sql = "SELECT * FROM gps";
$result = $liga->query($sql);

if ($result === false) {
  die("Erro na consulta: " . $liga->error);
}

$dadosLocalizacao = array();

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $latitude = $row['latitude'];
    $longitude = $row['longitude'];
    $data = $row['data'];

    // Fazer a solicitação à API de geocodificação para obter o nome do local
    // Substitua {API_KEY} pelo seu valor de chave de API válida
    $geocodingAPIURL = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$long&key=AIzaSyBf2a8jJFDPp9gPOzdi9tirTZKomFjTmZc";

    // Fazer a solicitação à API de geocodificação
    $geocodingResponse = file_get_contents($geocodingAPIURL);
    if ($geocodingResponse === false) {
      die("Erro ao obter a resposta da API de geocodificação");
    }

    $geocodingData = json_decode($geocodingResponse);

    // Extrair o nome do local da resposta
    $locationName = '';
    if ($geocodingData && isset($geocodingData->results) && count($geocodingData->results) > 0) {
      $locationName = $geocodingData->results[0]->formatted_address;
    }

    // Imprimir os dados na página HTML
    echo "Data: $data<br>";
    echo "Latitude: $latitude<br>";
    echo "Longitude: $longitude<br>";
    echo "Localização: $locationName<br>";
    echo "<br>";

    // Adicionar os dados ao array de localizações
    $dadosLocalizacao[] = array(
      'data' => $data,
      'localizacao' => $locationName,
      'latitude' => $latitude,
      'longitude' => $longitude,
    );
  }
}

$liga->close();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Histórico de Localização</title>
  <style>
    /* Estilos CSS para tornar o histórico visualmente atraente */
    /* ... (estilos CSS omitidos para brevidade) ... */
  </style>
</head>
<body>
  <div class="back-button">              
    <a href="GPSPRIN.html">Início</a>  
  </div>

  <div class="page-title">              
    <h1>Histórico de Localizações</h1>
  </div>

  <div class="location-list" id="locationList">
    <!-- Locais de localização serão adicionados aqui automaticamente -->
  </div>

  <div class="site-properties">
    Todos os direitos autorais reservados © RTL.
  </div>

  <script>
    // Função para carregar o histórico de localizações
    function carregarHistoricoLocalizacoes() {
      var locationList = document.getElementById('locationList');

      // Fazer a solicitação ao arquivo PHP (gps.php) para obter os dados de localização
      fetch('gps.php')
        .then(response => response.json())
        .then(dadosLocalizacao => {
          // Adicionar os dados de localização ao histórico
          for (var i = 0; i < dadosLocalizacao.length; i++) {
            var dados = dadosLocalizacao[i];
            adicionarLocalizacao(dados.data, dados.localizacao, dados.latitude, dados.longitude);
          }
        })
        .catch(error => {
          console.error('Erro ao obter os dados de localização:', error);
        });
    }

    // Função para adicionar uma nova localização ao histórico
    function adicionarNovaLocalizacao() {
      // Fazer a solicitação ao arquivo PHP (gps.php) para adicionar uma nova localização
      fetch('gps.php', { method: 'POST' })
        .then(response => response.json())
        .then(dadosLocalizacao => {
          // Adicionar a nova localização ao histórico
          var dados = dadosLocalizacao[0];
          adicionarLocalizacao(dados.data, dados.localizacao, dados.latitude, dados.longitude);
        })
        .catch(error => {
          console.error('Erro ao adicionar a nova localização:', error);
        });
    }

    // Função para adicionar uma localização ao histórico
    function adicionarLocalizacao(data, localizacao, latitude, longitude) {
      var locationList = document.getElementById('locationList');

      var locationItem = document.createElement('div');
      locationItem.className = 'location-item';

      var dateElement = document.createElement('p');
      dateElement.className = 'date';
      dateElement.textContent = new Date(data).toLocaleString();
      locationItem.appendChild(dateElement);

      var coordinatesElement = document.createElement('p');
      coordinatesElement.className = 'coordinates';
      coordinatesElement.textContent = 'Latitude: ' + latitude + ', Longitude: ' + longitude;
      locationItem.appendChild(coordinatesElement);

      var locationNameElement = document.createElement('p');
      locationNameElement.className = 'location-name';
      locationNameElement.textContent = 'Localização: ' + localizacao;
      locationItem.appendChild(locationNameElement);

      locationList.appendChild(locationItem);
    }

    // Carregar o histórico de localizações
    carregarHistoricoLocalizacoes();
  </script>
</body>
</html>
