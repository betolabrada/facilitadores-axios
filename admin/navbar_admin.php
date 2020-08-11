<?php 
  include 'admin_check.php'; 
  $current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html>
<script>function cerrar() { window.location.href = "../logout.php"; }</script>
<head>
  <meta charset="gb18030">  
  <title>ADMIN AXIOS</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/css/bootstrap.min.css" integrity="sha384-VCmXjywReHh4PwowAiWNagnWcLhlEJLA5buUprzK8rxFgeH0kww/aWY76TfkUoSX" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
  <link rel="stylesheet" href="../css/style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1,shrink-to-fit=no">
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#">
      <img src="../assets/logo.png" width="50" height="50" class="d-inline-block align-top" alt="">
    </a>

    <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
      <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
        <li class="nav-item">
          <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Administrador</a>
        </li>
        <li class="nav-item <?=($current_page == 'admin_dashboard.php') ? 'active' : ''?>">
          <a class="nav-link" href="admin_dashboard.php">Inicio</a>
        </li>
        <li class="nav-item <?=($current_page == 'admin_facilitadores.php') ? 'active' : ''?>">
          <a class="nav-link" href="admin_facilitadores.php">Facilitadores</a>
        </li>
        <li class="nav-item <?=($current_page == 'admin_sedes.php') ? 'active' : ''?>">
          <a class="nav-link" href="admin_sedes.php">Sedes</a>
        </li>
        <li class="nav-item <?=($current_page == 'admin_turnos.php') ? 'active' : ''?>">
          <a class="nav-link" href="admin_turnos.php">Turnos</a>
        </li>
        <li class="nav-item <?=($current_page == 'admin_alumnos.php') ? 'active' : ''?>">
          <a class="nav-link" href="admin_alumnos.php">Alumnos</a>
        </li>
        <li class="nav-item <?=($current_page == 'admin_grupos.php') ? 'active' : ''?>">
          <a class="nav-link" href="admin_grupos.php">Grupos</a>
        </li>
        <li class="nav-item <?=($current_page == 'admin_asesorias.php') ? 'active' : ''?>">
          <a class="nav-link" href="admin_asesorias.php">Asesorías</a>
        </li>
      </ul>
      <button class="btn" type="submit" onclick="cerrar()">Cerrar Sesión</button>
    </div>
  </nav>