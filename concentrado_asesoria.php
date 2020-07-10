<?php 
  include 'asesor_navbar.php';

  require_once 'models/Alumno.php';
  require_once 'models/Asesoria.php';
  require_once 'models/Asesor.php';

  $alumno_model = new Alumno;
  $asesoria_model = new Asesoria;
  $asesor = new Asesor;

  $alumno = $alumno_model->getAlumnoById($_SESSION['idAlumno']);
  $integrantes = $_SESSION['idIntegrantes'] == 1 ? 'Solo Alumno' : 'Con Padres';
  $tipo = $asesoria_model->getTipo($_SESSION['idIntegrantes']);
  $motivo = $asesoria_model->getMotivo($_SESSION['idMotivoAsesoria']);

  print_r($_SESSION);

  $idAsesor = (int)$_SESSION['idAsesor'];
  $idAlumno = (int)$_SESSION['idAlumno'];
  $idIntegrantes = (int)$_SESSION['idIntegrantes'];
  $idTipoAsesoria = (int)$_SESSION['idTipoAsesoria'];
  $idMotivoAsesoria = (int)$_SESSION['idMotivoAsesoria'];
  $fecha = $_SESSION['fecha'];
  $observaciones = $_SESSION['obs'];

  $mail = $_SESSION['user'];

  if (isset($_POST['subir'])) {
    if ($asesoria_model->insertAsesoria($idAlumno, $idMotivoAsesoria, $idAsesor, $idIntegrantes, $fecha,
      $observaciones)) {
      echo "<script type='text/javascript'> document.location = 'carga_exitosa.php?mail=$mail'; </script>";
    } else {
      $message = "Error: " . $query . "<br>" . $conn->error;
      echo "<script type='text/javascript'>alert('$message');</script>";
    }
  }

?>

<div class="container">
  
  <h4 class="display-4 text-center">Resumen de asesoría con:</h4>
  <br>
  <h4 class="text-center"><?php echo $alumno['Alumno']; ?></h4>
  <div class="row justify-content-center">
    <div class="col-md-10">
        <div class="row my-4 justify-content-center">
          <div class="col-sm-8">
            <label for="input-escuela">Escuela</label>
            <input type="input-escuela" class="form-control" placeholder="<?php echo $alumno['nombreEscuela']; ?>" disabled>
            <label for="input-grado">Grado</label>
            <input type="input-grado" class="form-control" placeholder="<?php echo $alumno['Grado']; ?>" disabled>
            <label for="input-grupo">Grupo</label>
            <input type="input-grupo" class="form-control" placeholder="<?php echo $alumno['Grupo']; ?>" disabled>
            <label for="input-integrantes">Integrantes de la asesoría</label>
            <input type="input-integrantes" class="form-control" placeholder="<?=$integrantes?>" disabled>
            <label for="input-tipo">Tipo de asesoría</label>
            <input type="input-tipo" class="form-control" placeholder="<?=$tipo?>" disabled>
            <label for="input-motivo">Motivo de asesoría</label>
            <input type="input-motivo" class="form-control" placeholder="<?=$motivo?>" disabled>
            <label for="input-fecha">Fecha</label>
            <input type="input-fecha" class="form-control" placeholder="<?=$fecha ?>" disabled>
            <label for="input-observaciones">Observaciones</label>
            <input type="input-observaciones" class="form-control" placeholder="<?=$observaciones ?>" disabled>
            </div>
        </div>
      <form method="post" action="" id="insertForm">
        <div class="row my-4 justify-content-center">
          <div class="col-sm-8">
              <button type="submit" class="btn btn-success btn-lg btn-primary btn-block text-uppercase" name="subir" form="insertForm">Subir asesoría</button>
          </div>
        </div>
      </form>
      <div class="row my-4 justify-content-center">
        <div class="col-sm-5">
          <button class="btn btn-danger btn-lg btn-primary btn-block text-uppercase" onclick="window.location.href='asesor_dashboard.php?inputMail=<?php echo $mail; ?>'">Cancelar</button>
        </div>
      </div>
    </div>
  </div>
</div>

</body>

</html>