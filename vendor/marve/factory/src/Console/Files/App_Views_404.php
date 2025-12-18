<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Página no encontrada</title>

  <!-- Bootstrap & jQuery -->
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

  <!-- Estilos personalizados -->
  <style>
    body {
      background-color: #f8f9fa;
      margin: 0;
      padding: 0;
    }
    .page-wrap {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem;
    }
    .display-1 {
      font-size: 5rem;
      font-weight: bold;
      color: #dc3545;
    }
    .lead {
      font-size: 1.2rem;
      margin-bottom: 1.5rem;
    }
    .btn-link {
      font-size: 1rem;
    }
  </style>
</head>

<body>
  <div class="page-wrap">
    <div class="container text-center">
      <span class="display-1">404</span>
      <p class="lead">La página que buscas no existe o no está disponible.</p>
      <a href="/Dashboard/Login" class="btn btn-link">Ir al inicio</a><br>
      <a href="#" class="btn btn-link" onclick="window.history.back();">Regresar a la página anterior</a>
    </div>
  </div>
</body>
</html>
