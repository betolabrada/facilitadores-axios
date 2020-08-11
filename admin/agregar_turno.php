<?php 
include 'navbar_admin.php';

$escuela_model = new Escuela();
$turno_model = new Turno();
$escuelas = $escuela_model->getEscuelas();

if (isset($_POST['registrar'])) {
  extract($_POST);
  if ($turno_model->getTurnoByTipoyEscuela($turno, $idEscuela)) {
    $_SESSION['message'] = "El turno que intentas agregar ya existe, por favor verifícalo e intenta de nuevo";
  } else {
    echo "NO EXISTE AGREGAR";
    if ($turno_model->agregarTurno($turno, $idEscuela, 0)) {
      $message = "¡Turno agregado con éxito!";
      echo "<script type='text/javascript'>alert('$message');</script>";
      echo "<script type='text/javascript'> document.location = 'admin_turnos.php'; </script>";
    } else {
      $_SESSION['message'] = "Hubo un error";
    }
  }
}

?>


  <div class="container">
    <?php if (isset($_SESSION['message'])):?>
      <div class="alert alert-danger">
        <?php
          echo $_SESSION['message'];
          unset($_SESSION['message']);
        ?>
      </div><!--alert-->
    <?php endif; ?>
    <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card card-signin my-5">
          <div class="card-body text-center">
            <img src="../assets/logo.png" class="img-responsive" style="width:100px;" /><br>
            <h5 class="card-title text-center">Nuevo Turno</h5>
            <form method="post" class="form-signup" id="form-signup">
              <div class="form-label-group">
                <select id="selectEscuela" class="form-control" name="idEscuela">
                  <option value="" selected>Escuela</option>
                  <?php foreach ($escuelas as $fila): ?>
                  <option value="<?=$fila['idEscuela'] ?>"><?=$fila['nombre'] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-label-group">
                <select id="selectTurno" class="form-control" name="turno">
                  <option value="" selected>Turno</option>
                  <option value="M">Matutino</option>
                  <option value="V">Vespertino</option>
                </select>
              </div>
              <button role="button" class="btn btn-lg btn-primary btn-block text-uppercase" 
                name="registrar">Registrar</button>
              <a href="admin_turnos.php">Cancelar</a>
              <hr class="my-4">
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>