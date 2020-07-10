<?php 
  include 'asesor_navbar.php';
  require_once 'models/Asesor.php';
  require_once 'models/Alumno.php';

  $asesor_model = new Asesor;
  $alumno_model = new Alumno;

  $asesor = $asesor_model->getAsesorById($_GET['id']);
  $alumnosDeAsesor = $alumno_model->getAlumnosDeAsesor($asesor['idAsesor']);


?>

<div class="container">
  <h4 class="display-4 text-center">Registro de nueva asesoría</h4>
  <br>
  <h4 class="text-center">Escriba el nombre del alumno</h4>
  <center>
      <input id="search" type="text" size="50" style="text-align:center;" placeholder="Escriba aquí">
  </center>
  <br>
  <div class="row justify-content-center">
    <div class="col-md-10">
      <table id="houdini" class="table table-striped table-dark table-sm table-bordered" style="visibility: collapse;">
        <thead>
          <th scope="col">Alumno</th>
          <th scope="col">Escuela</th>
          <th scope="col">Grado</th>
          <th scope="col">Grupo</th>
        </thead>
        <tbody id="filter"> 
          <?php foreach ($alumnosDeAsesor as $fila): ?>
            <tr>
              <td data-href="datos_alumno.php" data-id="<?php echo $fila['id']; ?>" class="align-middle"><?php echo $fila['Alumno']; ?></td>
              <td class="align-middle"><?php echo $fila['Escuela']; ?></td>
              <td class="align-middle"><?php echo $fila['Grado']; ?></td>
              <td class="align-middle"><?php echo $fila['Grupo']; ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody> 
      </table> 
      
      <div class="row my-4 justify-content-center">
        <div class="col-sm-3">
          <button class="btn btn-danger btn-lg btn-primary btn-block text-uppercase" onclick="window.location.href='asesor_dashboard.php?inputMail=<?=$asesor['correo'] ?>'">Cancelar</button>
        </div>
      </div>
    </div>
  </div>
</div>
  
<script src="js/houdini.js"></script>

<script>
    $(document).ready(function () {
        $(document.body).on("click", "td[data-href]", function () {
            window.location.href = this.dataset.href + "?idAsesor=" + <?=$asesor['idAsesor'] ?> + "&idAlumno=" + this.dataset.id;
        });
    });
</script>
</body>
</html>