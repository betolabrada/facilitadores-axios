<?php include 'navbar_admin.php' ?>
<?php 
  include '../lib/Database.php';
  $db = new Database;
  $escuela = isset($_GET['idEscuela']) ? $db->getEscuela($_GET['idEscuela']) : "Error cargando escuela";
  $turno = isset($_GET['turno']) ? $_GET['turno'] : "Error cargando turno";
  $grado = isset($_GET['grado']) ? $_GET['grado'] : "Error cargando grado";
  $grupo = isset($_GET['grupo']) ? $_GET['grupo'] : "Error cargando grupo";


  if (isset($_POST['subir'])) {
    $_SESSION['message'] = "Grupo creado";
  }

?>
<div class="container mt-3">
  <?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-success">
    <?php
      echo $_SESSION['message'];
      unset($_SESSION['message']);
    ?>
    </div><!--alert-->
  <?php else: ?>
  <form method="post" action="admin_crear_grupo.php">
    <div class="form-group">
      <label for="escuela">Escuela</label>
      <input type="text" class="form-control" id="escuela" placeholder="<?=$escuela?>" readonly>
      <label for="turno">Turno</label>
      <input type="text" class="form-control" id="turno" placeholder="<?=$turno?>" readonly>
      <label for="escuela">Nuevo Grupo</label>
      <input type="text" class="form-control" id="escuela" placeholder="<?=$grado . $grupo?>" readonly>
    </div>
    <div class="row my-4 justify-content-center">
      <div class="col-sm-8">
        <button type="submit" class="btn btn-success btn-block text-uppercase" name="subir">Crear grupo</button>
      </div>
    </div>
  </form>
  <?php endif;?>
  <div class="row my-4 justify-content-center">
    <div class="col-sm-5">
      <a href="admin_grupos.php" class="btn btn-danger btn-block text-uppercase" >Regresar</a>
    </div>
  </div>
</div>
