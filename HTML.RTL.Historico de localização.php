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

