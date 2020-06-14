<?php include '../config/init.php'; ?>
<?php include 'admin_check.php'; ?>

<!DOCTYPE html>
<html>
<script>
function cerrar() {
  window.location.href = "../logout.php";
}
</script>
<head>
  <meta charset="utf-8">
  <title>ADMIN AXIOS</title>
  <link rel="stylesheet" href="../sauce/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.slim.min.js">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1,
          shrink-to-fit=no">
</head>

<body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
  </script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
  </script>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <a class="navbar-brand" href="#">
    <img src="../sauce/Logo AXIOS.png" width="50" height="50" class="d-inline-block align-top" alt="">
  </a>

  <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <li class="nav-item">
        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Administrador</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="admin_dashboard.php">Inicio</a>
      </li>
      <li>
        <a class="nav-link" href="admin_sedes.php">Administrar Sedes</a>
      </li>
      <li>
        <a class="nav-link" href="admin_facilitadores.php">Administrar Facilitadores</a>
      </li>
      <li>
        <a class="nav-link" href="admin_sedes.php">Administrar Escuelas</a>
      </li>
      <li>
        <a class="nav-link" href="admin_grupos.php">Administrar Grupos</a>
      </li>
    </ul>

    <button class="btn" type="submit" onclick="cerrar()">Cerrar Sesión</button>

  </div>
</nav>