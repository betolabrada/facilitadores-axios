<?php 
  include 'asesor_navbar.php';
  require_once 'models/Alumno.php';
  require_once 'models/Asesoria.php';

  $where = "";
  $_SESSION['idAsesor'] = $idAsesor = (int) $_GET['idAsesor'];
  $_SESSION['idAlumno'] = $idAlumno = (int) $_GET['idAlumno'];
  $_SESSION['idIntegrantes'] = $idIntegrantes = (int)$_GET['idIntegrantes'];
  $_SESSION['idTipoAsesoria'] = $idTipoAsesoria = (int) $_GET['idTipoAsesoria'];
  $_SESSION['idMotivoAsesoria'] = $idMotivoAsesoria = (int) $_GET['idMotivoAsesoria'];

  $mail = $_SESSION['user'];

  $alumno_model = new Alumno;
  $asesoria_model = new Asesoria;

  $alumno = $alumno_model->getAlumnoById($_GET['idAlumno']);

  if (isset($_POST['aceptar'])) {
    $fecha = date('Y-m-d', strtotime($_POST['fecha']));
    $observaciones = $_POST['observaciones'];
    if($observaciones !== "") {
      $_SESSION['fecha'] = $fecha;
      $nObservaciones = str_replace('"', "&quot;", $observaciones);
      $_SESSION['obs'] = $nObservaciones;
      echo "<script type='text/javascript'> document.location = 'concentrado_asesoria.php'; </script>";
    }
    $message = "Por favor escribe tus notas de la asesoría en la sección de observaciones";
    echo "<script type='text/javascript'>alert('$message');</script>";
  }
?>


<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <h4 class="display-4 text-center">Nueva asesoría con:</h4>
      <br>
      <h4 class="text-center"><?php echo $alumno['Alumno']; ?></h4>
      <br>
      <form method="post" action="" id="insertForm">

      <div class="text-center">
        <div class="col-sm-2"></div>
          <label for="input-fecha">Fecha de la asesoría</label>
          <br>
          <input name="fecha" type="date" value="<?php echo date("Y-m-d")?>">
          <br>
          <br>
          <label for="input-observaciones">Observaciones</label>
          <br>
          <textarea name="observaciones" rows="10" cols="100" placeholder="Escribe aquí"></textarea>
          <br>
        <div class="col-sm-2"></div>
      </div>

      <div class="row my-4 justify-content-center">
        <div class="col-sm-3">
          <button type="submit" class="btn btn-success btn-lg btn-primary btn-block text-uppercase" name="aceptar" form="insertForm">Aceptar</button>
        </div>
        <div class="col-sm-3">
          <button type="button" class="btn btn-danger btn-lg btn-primary btn-block text-uppercase" onclick="window.location.href='asesor_dashboard.php?inputMail=<?php echo $mail; ?>'">Cancelar</button>
        </div>
      </form>
      </div>
    </div>
  </div>
</div>

</body>

</html>