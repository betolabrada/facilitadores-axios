<?php include 'navbar_admin.php';
  $idTurno = (int)$_GET['idTurno'];

  $asesor_model = new Asesor();
  $turno_model = new Turno();

  $asesor = $asesor_model->getAsesores();

  $turno = $turno_model->getTurnoById($idTurno);
?>

<?php

// if (isset($_POST['subir'])) {
//   $nombre = $_POST['nombre'];
//   $correo = $_POST['correo'];
//   if($nombre === $oldNombre || $nombre === "") {
//     $nombre = $oldNombre;
//   }

//   if($correo === $oldCorreo || $correo === "") {
//     $correo = $oldCorreo;
//   }

//   if ($asesor_model->updateAsesor($idUsuario, $nombre, $correo)) {
//     $message = "Cambios guardados con éxito";
//     echo "<script type='text/javascript'>alert('$message');</script>";
//     echo "<script type='text/javascript'> document.location = 'admin_facilitadores.php'; </script>";
//   } else {
//     $message = "Error: " . $query . "<br>";
//     echo "<script type='text/javascript'>alert('$message');</script>";
//   }
// }
?>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-10">
        <h4 class="display-4 text-center">Cambiar Facilitador de Turno</h4>
        <br>
        <h4 class="text-center">Editando a:&nbsp;<?=$turno['turno'] ?></h4>
        <form method="post" action="" id="insertForm" onsubmit="return validateForm()">

          <div class="row py-2 my-4 justify-content-center">
            <div class="col-sm-8">
              <label for="input-nombre">Nombre</label>
              <input type="input-nombre" class="form-control" name="nombre" 
                placeholder="">
              <br>
              <label for="input-correo">Correo</label>
              <input type="input-correo" class="form-control" name="correo" 
                placeholder="" >
              <br>
              <label for="input-correo">Turno</label>
              <?php if (count($turnos) === 0) :?>
                <h6>Este Asesor no está manejando ningún turno</h6>
              <?php else: ?>
                <?php foreach ($turnos as $fila): ?>
                  <input type="text" class="form-control" 
                    placeholder="<?=str_replace('"', '\'', $fila['turno'])?>" disabled>
                <?php endforeach;?>
              <?php endif;?>
            </div><!--col-->
          </div><!--row-->
          <div class="row my-5 justify-content-center">
            <div class="col-sm-3">
              <button class="btn btn-success btn-lg btn-primary btn-block text-uppercase" name="subir" form="insertForm" >Aceptar</button>
            </div><!--col-->
            <div class="col-sm-3">
              <button type="button" class="btn btn-danger btn-lg btn-primary btn-block text-uppercase"
                onclick="window.location.href='admin_facilitadores.php'">Cancelar</button>
            </div><!--col-->
          </div><!--row-->
        </form>
      </div><!--col-->
    </div><!--row-->
  </div><!--container-->
</body>
</html>