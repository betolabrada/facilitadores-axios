<?php 
  include 'asesor_navbar.php';
  require_once 'models/Asesor.php';
  require_once 'models/Alumno.php';
  require_once 'models/Asesoria.php';

  $asesor_model = new Asesor;
  $alumno_model = new Alumno;
  $asesoria_model = new Asesoria;

  $asesor = $asesor_model->getAsesorById($_GET['idAsesor']);
  $alumno = $alumno_model->getAlumnoById($_GET['idAlumno']);
  $motivosAsesoria = $asesoria_model->getMotivos($_GET['idTipoAsesoria']);
?>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-10">
        
        <h4 class="display-4 text-center">Nueva asesoría con:</h4>
        <br>
        <h4 class="text-center"><?php echo $alumno['Alumno']; ?></h4>
        <br>
        <form onsubmit="return validateForm()">
   
        <center>
          <label for="input-tipo">Motivo de Asesoría</label>
        </center>
        <div class="row justify-content-center">
          <div class="col-md-8">
            <div class="row">
              <select id="motivoAsesoria" class="form-control">
              <?php foreach ($motivosAsesoria as $fila): ?>
                <option value="<?php echo $fila['id']; ?>"><?php echo $fila['motivo']; ?></option>
              <?php endforeach; ?>
              </select>
              <br>
            </div>
          </div>
        </div>
        </form>
        
        <div class="row my-4 justify-content-center">
          <div class="col-sm-3">
            <button data-href="fobs_asesoria.php" class="btn btn-success btn-lg btn-primary btn-block text-uppercase">Aceptar</button>
          </div>
          <div class="col-sm-3">
            <button class="btn btn-danger btn-lg btn-primary btn-block text-uppercase" onclick="window.location.href='asesor_dashboard.php?inputMail=<?=$asesor['correo'] ?>'">Cancelar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
<script>
    $(document).ready(function () {
        $(document.body).on("click", "button[data-href]", function () {
            window.location.href = this.dataset.href
                                 + "?idAsesor=" + <?=$_GET['idAsesor'] ?>
                                 + "&idAlumno=" + <?=$_GET['idAlumno'] ?>
                                 + "&idIntegrantes=" + <?=$_GET['idIntegrantes'] ?>
                                 + "&idTipoAsesoria=" + <?=$_GET['idTipoAsesoria'] ?>
                                 + "&idMotivoAsesoria=" + document.getElementById('motivoAsesoria').value;
        });
    });
</script>
</body>
</html>