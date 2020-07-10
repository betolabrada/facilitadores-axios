<?php include 'navbar_admin.php'; 
$idSede = (int)$_GET['idSede'];

require_once '../models/Sede.php';

$sede_model = new Sede;

$sede = $sede_model->getSede($idSede);

if (isset($_POST['subir'])) {
  $nombre = $_POST['nombre'];
  $noChanges = 0;

  if($nombre === $oldNombre || $nombre === "") {
    $nombre = $oldNombre;
    $noChanges++;
  }

  if($noChanges == 1) {
    $message = "No se realizaron cambios a los datos de la localidad";
    echo "<script type='text/javascript'>alert('$message');</script>";
  } else {
    // update value
    if ($sede_model->updateSede($sede['idLocalidad'], $nombre)) {
      $message = "Cambios guardados con éxito";
      echo "<script type='text/javascript'>alert('$message');</script>";
      echo "<script type='text/javascript'>document.location = 'admin_sedes.php'; </script>";
    } else {
      $message = "Error: " . $query . "<br>" . $conn->error;
      echo "<script type='text/javascript'>alert('$message');</script>";
      echo "<script type='text/javascript'>document.location = 'admin_sedes.php'; </script>";
    }
  }
}
?>

<div class="container">
  <h4 class="display-4 text-center">Datos de la localidad:</h4>
  <br>
  <h4 class="text-center"><?php echo $sede['nombre']; ?></h4>
    <div class="row justify-content-center">
      <div class="col-md-10">
        <form method="post" action="" id="insertForm" onsubmit="return validateForm()">
        <div class="row my-4">
          <div class="col-sm-2"></div>
          <div class="col-sm-8">
            <label for="input-nombre">Nombre</label>
            <input type="input-nombre" class="form-control" name="nombre" placeholder="<?php echo $sede['nombre']; ?>">
          </div>
        </div>
        </form>
        <div class="row my-4 justify-content-center">
          <div class="col-sm-3">
            <button class="btn btn-success btn-lg btn-primary btn-block text-uppercase" name="subir" form="insertForm">Aceptar cambios</button>
          </div>
          <div class="col-sm-3">
            <button class="btn btn-danger btn-lg btn-primary btn-block text-uppercase" onclick="window.location.href='admin_sedes.php'">Cancelar</button>
          </div>
        </div>
    </div>
  </div>
</body>
</html>