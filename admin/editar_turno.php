<?php include 'navbar_admin.php';
  $idTurno = (int)$_GET['idTurno'];

  $asesor_model = new Asesor();
  $turno_model = new Turno();

  $asesores = $asesor_model->getAsesores();

  $turno = $turno_model->getTurnoById($idTurno);
  print_r($turno);
  echo '<br>';

  print_r($_POST);

if (isset($_POST['aceptar']) && isset($_POST['asesor'])) {
  $idAsesor = (int) $_POST['asesor'];

  if ($turno_model->updateTurno($idAsesor, $idTurno)) {
    $message = "Cambios guardados con éxito";
    echo "<script type='text/javascript'>alert('$message');</script>";
    echo "<script type='text/javascript'> document.location = 'admin_turnos.php'; </script>";
  } else {
    $message = "Error: " . $query . "<br>";
    echo "<script type='text/javascript'>alert('$message');</script>";
  }
}
?>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-10">
        <h4 class="display-4 text-center">Cambiar Facilitador de Turno</h4>
        <br>
        <h4 class="text-center">Editando a:&nbsp;<?=$turno['turno'] ?></h4>
        <form method="post">
          <div class="row py-2 my-4 justify-content-center">
            <div class="col-sm-8">
              <label for="input-correo">Cambiar Asesor</label>
              <?php if (count($asesores) === 0): ?>
              <h6>Errores</h6>
              <?php else: ?>
              <select id="filtroAsesor" class="form-control" name="asesor">
                <option value="" selected>Facilitador</option>
                <?php foreach ($asesores as $fila): ?>
                <option value="<?=$fila['idAsesor'] ?>"><?=$fila['nombre'] ?></option>
                <?php endforeach; ?>
              </select>
              <?php endif;?>
            </div><!--col-->
          </div><!--row-->
          <div class="row my-5 justify-content-center">
            <div class="col-sm-3">
              <button class="btn btn-success btn-lg btn-primary btn-block text-uppercase" 
              name="aceptar">Aceptar</button>
            </div><!--col-->
            <div class="col-sm-3">
              <button type="button" class="btn btn-danger btn-lg btn-primary btn-block text-uppercase"
                onclick="window.history.go(-1)">Cancelar</button>
            </div><!--col-->
          </div><!--row-->
        </form>
      </div><!--col-->
    </div><!--row-->
  </div><!--container-->
</body>
</html>