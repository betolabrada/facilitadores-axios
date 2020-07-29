<?php 
  include 'asesor_navbar.php';
  require_once 'models/Asesor.php';
  require_once 'models/Alumno.php';

  $asesor_model = new Asesor;
  $alumno_model = new Alumno;

  $asesor = $asesor_model->getAsesorById($_GET['idAsesor']);
  $alumno = $alumno_model->getAlumnoById($_GET['idAlumno']);

  $mail = $asesor['correo'];
?>

<div class="container">
  <h4 class="display-4 text-center">Nueva asesoría con:</h4>
  <br>
  <h4 class="text-center"><?php echo $alumno['Alumno']; ?></h4>
  <div class="row justify-content-center">
    <div class="col-md-10">
      <form onsubmit="return validateForm()">
        <div class="row my-4 justify-content-center">
          <div class="col-sm-8">
            <label for="input-escuela">Escuela</label>
            <input type="input-escuela" class="form-control" placeholder="<?php echo $alumno['nombreEscuela']; ?>" disabled>
            <label for="input-grado">Grado</label>
            <input type="input-grado" class="form-control" placeholder="<?php echo $alumno['Grado']; ?>" disabled>
            <label for="input-grupo">Grupo</label>
            <input type="input-grupo" class="form-control" placeholder="<?php echo $alumno['Grupo']; ?>" disabled>
          </div>
        </div>
      </form>
      <div class="row my-4">
        <div class="col-sm-2"></div>
        <div class="col-sm-8">
          <strong>Seleccione si la asesoría fue:</strong>
          <br>
          <form>
            <div>
              <input type="radio" name="integrantes" value="1" id="solo" checked>
              <label for="solo">Solo Alumno</label>
            </div>
            <div>
              <input type="radio" name="integrantes" value="2" id="padres">
              <label for="padres">Con Padres</label>
            </div>
            <br>
          </form>
          <div class="col-sm-2"></div>
        </div>
      </div>
      
      <div class="row my-4 justify-content-center">
        <div class="col-sm-3">
          <button data-href="tipo_asesoria.php" class="btn btn-success btn-lg btn-primary btn-block text-uppercase">Aceptar</button>
        </div>
        <div class="col-sm-3">
          <button class="btn btn-danger btn-lg btn-primary btn-block text-uppercase" onclick="window.location.href='asesor_dashboard.php?inputMail=<?php echo $mail; ?>'">Cancelar</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
    $(document).ready(function () {
        $(document.body).on("click", "button[data-href]", function () {
          if($('input[name="integrantes"]:checked').val() === undefined) {
            alert("Por favor selecciona una de las opciones");
          } else {
            window.location.href = this.dataset.href
                                 + "?idAsesor=" + <?=$_GET['idAsesor'] ?>
                                 + "&idAlumno=" + <?=$_GET['idAlumno'] ?>
                                 + "&idIntegrantes=" + $('input[name="integrantes"]:checked').val();
          }
            
        });
    });
</script>
  
</body>
</html>