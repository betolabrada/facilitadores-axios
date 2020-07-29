<?php

session_start();
if (isset($_SESSION['admin'])) {
  include '../navbar_admin.php';
} else {
  include '../../asesor_navbar.php';
}

require_once '../../models/Asesoria.php';

$asesoria_model = new Asesoria();

$idAsesoria = (int) $_POST['idAsesoria'];

$asesoria = $asesoria_model->getAsesoriaById($idAsesoria);

$mail = $_SESSION['user'];

?>

<div class="container">
  <h3 class="display-3 text-center">Datos de la Asesoria</h3>
  <br>
    <div class="row my-4">
        <div class="col-sm-2"></div>
          <div class="col-sm-8">           
            <h5 class="display-5 text-center">Nombre del Alumno: <?php echo $_POST['nombreAlumno']?></h5>
            <h5 class="display-5 text-center">Fecha: <?php echo $asesoria[0]['fecha']?></h5>
            <h5 class="display-5 text-center">Observaciones: <?php echo $asesoria[0]['observaciones']?></h5>
          </div>
        </div>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <form action="borrar_asesoria.php" method="POST" id="confirmarForm">
                <input type="number" name="idAsesoria" value="<?php echo $_POST['idAsesoria']?>" hidden="hidden"/>
            </form>
            <form action="../../asesor_dashboard.php?inputMail=<?php echo $mail?>" method="POST" id="cancelarForm">
            </form>
            <div class="row my-4 justify-content-center">
              <div class="col-sm-3">
                <button class="btn btn-danger btn-lg btn-primary btn-block text-uppercase" name="subir" form="confirmarForm">Borrar</button>
              </div>
              <div class="col-sm-3">
                <button class="btn btn-success btn-lg btn-primary btn-block text-uppercase" name="cancelar" form="cancelarForm">Cancelar</button>
              </div>
            </div>
        </div>
    </div>
</body>
</html>