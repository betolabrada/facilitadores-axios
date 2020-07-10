<?php include 'navbar_admin.php';
    $idUsuario = (int)$_GET['idUsuario'];

  require_once '../models/Asesor.php';

  $asesor_model = new Asesor;

  $asesor = $asesor_model->getAsesorById($idUsuario);
  $nombre = $asesor['nombre'];
  $correo = $asesor['correo'];
?>

<?php

if (isset($_POST['eliminar'])) {
  // ESTE DELETE ES UN METODO INSEGURO, BORRAR ASESOR IMPLICA BORRAR SUS ASESORIAS Y 
  // DONDE MAS ESTE REFERENCIADO
  if ($asesor_model->deleteAsesor($idUsuario)) {
    $message = "Usuario eliminado con éxito";
    echo "<script type='text/javascript'>alert('$message');</script>";
    echo "<script type='text/javascript'> document.location = 'admin_facilitadores.php'; </script>";
  } else {
    $message = "Error: " . $query . "<br>";
    echo "<script type='text/javascript'>alert('$message');</script>";
  }
}
?>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-10">
        <h4 class="display-4 text-center">Eliminando usuario</h4>
          <br>
          <h4 class="text-center">¿Estas seguro de que deseas eliminar a: <?php echo $nombre; ?>?</h4>
          <form method="post" action="" id="insertForm" onsubmit="return validateForm()">

          <div class="row my-4">
            <div class="col-sm-2"></div>
              <div class="col-sm-8">
                <label for="input-nombre">Nombre</label>
                <input type="input-nombre" class="form-control" name="nombre" placeholder="<?php echo $nombre; ?>" disabled>
                <br>
                <label for="input-correo">Correo</label>
                <input type="input-correo" class="form-control" name="correo" placeholder="<?php echo $correo; ?>" disabled>
               </div>
              <div class="col-sm-2"></div>
            </div>
          </form>
        
        
        <div class="row my-4 justify-content-center">
          <div class="col-sm-3">
            <button class="btn btn-success btn-lg btn-primary btn-block text-uppercase" name="eliminar" form="insertForm" >Eliminar</button>
          </div>
          <div class="col-sm-3">
            <button class="btn btn-danger btn-lg btn-primary btn-block text-uppercase" onclick="window.location.href='admin_facilitadores.php'">Cancelar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>