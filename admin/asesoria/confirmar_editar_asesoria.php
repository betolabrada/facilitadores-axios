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

//var_dump($asesoria)

?>

<div class="container">
  <h4 class="display-4 text-center">Editar Asesoria</h4>
  <br>
    <div class="row justify-content-center">
      <div class="col-md-10">
          <form method="post" action="editar_asesoria.php" id="editForm">
            <div class="row my-4">
              <div class="col-sm-2"></div>
              <div class="col-sm-8">
                  
                <label>Alumno</label>
                <input type="text" class="form-control" name="nombre" disabled="disabled" value="<?php echo $_POST['nombreAlumno']?>"/>

                <label>Fecha</label>
                <input type="date" class="form-control" name="fecha" required="required" value="<?php echo $asesoria[0]['fecha']?>"/>

                <label for="input-dinamica">Dinamica</label>
                <select id="input-dinamica" class="form-control" name="integrantes">
                    <option value="1" <?php echo $asesoria[0]['idIntegrantes'] == "1"?'checked/"checked/"':'' ?>>Sólo alumno</option>
                    <option value="2" <?php echo $asesoria[0]['idIntegrantes'] == "2"?'checked/"checked/"':'' ?>>Con padres</option>
                </select>
                
                <label>Nombre alumno</label>
                <input type="text" class="form-control" name="observaciones" value="<?php echo $asesoria[0]['observaciones']?>"/>
                
                <input type="number" name="idAsesoria" value="<?php echo $_POST['idAsesoria']?>" hidden="hidden"/>
                
              </div>
            </div>
        </form>
        <form action="../../asesor_dashboard.php?inputMail=<?php echo $mail?>" method="POST" id="cancelarForm">
        </form>
        <div class="row my-4 justify-content-center">
          <div class="col-sm-3">
            <button class="btn btn-success btn-lg btn-primary btn-block text-uppercase" name="subir" form="editForm">Aceptar cambios</button>
          </div>
          <div class="col-sm-3">
            <button class="btn btn-danger btn-lg btn-primary btn-block text-uppercase" form="cancelarForm">Cancelar</button>
          </div>
        </div>
    </div>
  </div>
</body>
</html>