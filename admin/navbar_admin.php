<?php 
  require_once '../config/db.php'; 
  require_once '../lib/Database.php'; 

  $current_page = basename($_SERVER['PHP_SELF']);
?>
<?php include 'admin_check.php'; ?>

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
        <a class="nav-link" href="admin_dashboard.php">Inicio
          <?php if ($current_page == 'admin_dashboard.php') echo '<span class="sr-only">(current)</span>';?>
        </a>
      </li>
      <li class="nav-item <?=($current_page == 'admin_facilitadores.php') ? 'active' : ''?>">
        <a class="nav-link" href="admin_facilitadores.php">Administrar Facilitadores
          <?php if ($current_page == 'admin_facilitadores.php') echo '<span class="sr-only">(current)</span>';?>
        </a>
      </li>
      <li class="nav-item <?=($current_page == 'admin_sedes.php') ? 'active' : ''?>">
        <a class="nav-link" href="admin_sedes.php">Administrar Sedes
          <?php if ($current_page == 'admin_sedes.php') echo '<span class="sr-only">(current)</span>';?>
        </a>
      </li>
      <li class="nav-item <?=($current_page == 'admin_alumnos.php') ? 'active' : ''?>">
        <a class="nav-link" href="admin_alumnos.php">Administrar Alumnos
          <?php if ($current_page == 'admin_alumnos.php') echo '<span class="sr-only">(current)</span>';?>
        </a>
      </li>
      <li class="nav-item <?=($current_page == 'admin_grupos.php') ? 'active' : ''?>">
        <a class="nav-link" href="admin_grupos.php">Administrar Grupos
          <?php if ($current_page == 'admin_grupos.php') echo '<span class="sr-only">(current)</span>';?>
        </a>
      </li>
    </ul>
    <button class="btn" type="submit" onclick="cerrar()">Cerrar Sesión</button>
  </div>
</nav>