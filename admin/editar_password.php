<?php include 'navbar_admin.php';
    $idUsuario = (int)$_GET['idUsuario'];

  
  require_once '../models/Asesor.php';

  $asesor_model = new Asesor;
  
  $asesor = $asesor_model->getAsesorById($idUsuario);

?>

<?php
if (isset($_POST['subir'])) {
    $newPassword = $_POST['newPass'];
    $newConPassword = $_POST['newConPass'];
    if($newPassword === "" || $newConPassword === "") {
        $message = "Por favor no dejes los campos vacios";
        echo "<script type='text/javascript'>alert('$message');</script>";
    } else {
        if($newPassword === $newConPassword) {
            if ($asesor_model->changeAsesorPassword($newPassword)) {
                $message = "Cambios guardados con éxito";
                echo "<script type='text/javascript'>alert('$message');</script>";
                echo "<script type='text/javascript'> document.location = 'admin_facilitadores.php'; </script>";
            } else {
              $message = "Error: " . $query . "<br>";
              echo "<script type='text/javascript'>alert('$message');</script>";
            }
        } else {
            $message = "Las contraseñas no coinciden";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
    }
}
?>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-10">
         <h4 class="display-4 text-center">Editando contraseña</h4>
         <br>
         <h4 class="text-center">Editando contraseña de:&nbsp;<?php echo $asesor['nombre']; ?></h4>
          <form method="post" action="" id="insertForm" onsubmit="return validateForm()">

          <div class="row my-4">
            <div class="col-sm-2"></div>
              <div class="col-sm-8">
                <label for="input-nueva-contraseña">Nueva Contraseña</label>
                <input type="input-nueva-contraseña" class="form-control" name="newPass" placeholder="Nueva contraseña">
                <br>
                <label for="input-confirmar-contraseña">Confirmar Contraseña</label>
                <input type="input-confirmar-contraseña" class="form-control" name="newConPass" placeholder="Confirmar contraseña">
                </div>
              <div class="col-sm-2"></div>
            </div>
          </form>
        
        
        <div class="row my-4 justify-content-center">
          <div class="col-sm-3">
            <button class="btn btn-success btn-lg btn-primary btn-block text-uppercase" name="subir" form="insertForm" >Aceptar</button>
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